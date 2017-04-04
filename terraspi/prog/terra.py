#! /usr/bin/env python
#-*- coding: utf-8 -*-

# import des librairies
import os
import json
import MySQLdb
import sys
import Adafruit_DHT
import csv
import ephem
import datetime
import time
import RPi.GPIO as GPIO
import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEBase import MIMEBase
from email.MIMEText import MIMEText
from email.Utils import COMMASPACE, formatdate
from email import Encoders


GPIO.setwarnings(False)   # pour éviter alarme : (This channel is already in use)
GPIO.setmode(GPIO.BCM)  # gpio numérotation BCM

    
GPIO.setup(4, GPIO.OUT)  # lumière
GPIO.setup(17, GPIO.OUT)  # chauffage

# on ouvre le fichier config .json
with open('/var/www/html/terraspi/csv/bdd.json') as config:    
    config = json.load(config)

 # on recupère le login et mdp de la bdd   
login = config["mysql"]["loginmysql"]
mdp = config["mysql"]["mdpmysql"]

# on se connecte a la bdd
db = MySQLdb.connect(host="localhost", 
                     user=login,     
                     passwd=mdp, 
                     db="Terrarium")  
cur = db.cursor()
cur.execute("SELECT * FROM config")   # on sort tout de la table config

for row in cur.fetchall():        # et on récupère les champs qui nous intéresse
    longitude = row[3]
    latitude = row[4]
    altitude = row[5]
    limiteBasse = row[6]
    limiteHaute = row[7]
    jour = row[8]
    nuit = row[9]
    envoyeur = row[11]
    mdpenvoyeur = row[12]
    receveur = row[13]
    HeureEI = row[15]

db.close()                  # on ferme la connexion a la bdd

# ici on régle en fonction des coordonnées mis sur la page admin
somewhere = ephem.Observer()     
somewhere.lon = str(longitude)   #  longitude
somewhere.lat = str(latitude)
somewhere.elevation = int(altitude)   #  altitude 

# Heure actuelle ( du pi, GMT) convertie en chiffres
heurenow = int(time.strftime('%H%M'))

# Récupérer la date et l'heure
dateandtime = time.strftime('%Y-%m-%d %H:%M',time.localtime())      

sun = ephem.Sun()
# r1 = heure lever soleil UTC
r1 = somewhere.next_rising(sun)
# s1 = heure coucher soleil UTC
s1 = somewhere.next_setting(sun)

# coucher = heure du coucher du soleil, en chiffres
# on commence par convertir l'heure de coucher en chiffres
# après avoir extrait les informations inutiles (date, etc.)
heurec = str(s1)
long = len(heurec)
fin = long - 8
heurec = heurec[fin:long-3]
coucher = int(heurec[0:2] + heurec[3:5])

# lever = heure du lever du soleil, en chiffres
# on commence par convertir l'heure de lever en chiffres
# après avoir extrait les informations inutiles (date, etc.)
heurel = str(r1)
long = len(heurel)
fin = long - 8
heurel = heurel[fin:long-3]
lever = int(heurel[0:2] + heurel[3:5])

lever = lever + HeureEI          #heure ete hiver
coucher = coucher + HeureEI


if lever < heurenow < coucher:    # si l'heure actuelle est comprise entre l'heure du lever et du coucher, s'il faut jour quoi.
  GPIO.output (4, True)            # on allume la lumière (on intervertira True et False suivant le branchement du relais  'normalement ouvert ou fermer'  )
  target = jour                    # on donne la consigne de jour comme température au point chaud
   
else:                                   
  GPIO.output (4, False)           # sinon on éteint la lumière
  target = nuit                    # on donne la consigne de nuit comme température au point chaud


fname1 = "/var/www/html/terraspi/csv/ephem.csv"    # on créer le fichier 
file1 = open(fname1, "wb")  
  
try:
    # Création de  CSV.
    writer1 = csv.writer(file1)
    # Écriture de la ligne d'en-tête avec le titre
    # des colonnes.
    writer1.writerow( ('lever' ,'coucher') )
    # Écriture des quelques données.
    writer1.writerow( (lever, coucher) )       

finally:    
    # Fermeture du fichier source
    file1.close()     
    
# on lit les sondes
humF, tempF = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 22)   #   point froid
humC, tempC = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 27)   #  point chaud

# on arrondi a 2 chiffres
humF = round(humF,2)                   
tempF = round(tempF,2)
humC = round(humC,2)
tempC = round(tempC,2)

# le contrôle du chauffage
if tempC > target:      # si la température du point chaud dépasse la target (nuit ou jour)
    GPIO.output (17, False)     # on coupe le chauffage
								# (on intervertira True et False suivant le branchement du relais 'normalement ouvert ou fermer')
else:
    GPIO.output (17, True)      # sinon on l'allume        

# on créer le fichier
fname = "/var/www/html/terraspi/csv/result.csv"    
file = open(fname, "wb")
 
try:
    # Création du CSV   
    writer = csv.writer(file)
    # Écriture de la ligne d'en-tête avec le titre
    # des colonnes.
    writer.writerow( ('Humidity' ,'Temperature') )
    # Écriture des quelques données.
    writer.writerow( (humF, tempF) )
    writer.writerow( (humC, tempC) )       

finally:
    # Fermeture du fichier source    
    file.close()    

 # Connexion a la base MySQL
bdd = MySQLdb.connect(host="localhost",user=login,passwd=mdp,db="Terrarium")  
req = bdd.cursor()

# Envoi a la base de donnée
try:
    req.execute("""insert into capteurdata (`dateandtime`,`tempF`,`humF`,`tempC`,`humC`) values (%s,%s,%s,%s,%s)""",(dateandtime,tempF,humF,tempC,humC))
    bdd.commit()
    
except:
    bdd.rollback()
        
bdd.close()  # Fermeture de la connexion

USERNAME = envoyeur      # adresse de l'envoyeur
PASSWORD = mdpenvoyeur                  # mot de passe

# fonction sendmail
def sendMail(to, subject, text, files=[]):         
	assert type(to)==list
	assert type(files)==list

	msg = MIMEMultipart()
	msg['From'] = USERNAME
	msg['To'] = COMMASPACE.join(to)
	msg['Date'] = formatdate(localtime=True)
	msg['Subject'] = subject

	msg.attach( MIMEText(text) )

	for file in files:
		part = MIMEBase('application', "octet-stream")
		part.set_payload( open(file,"rb").read() )
		Encoders.encode_base64(part)
		part.add_header('Content-Disposition', 'attachment; filename="%s"'
					   % os.path.basename(file))
		msg.attach(part)

	server = smtplib.SMTP('smtp.gmail.com:587')
	server.ehlo_or_helo_if_needed()
	server.starttls()
	server.ehlo_or_helo_if_needed()
	server.login(USERNAME,PASSWORD)
	server.sendmail(USERNAME, to, msg.as_string())
	server.quit()
	
	
# On envoi un mail , si la température au point chaud dépasse les limites.
if tempC <= limiteBasse or tempC >= limiteHaute :
        
    sendMail( [receveur],           # adresse ou l'on veut envoyer le mail
            "Alerte terrarium !!!!",              # sujet  
            "limite atteinte, il fait %s °C au point chaud ,connecte toi vite !!!" %tempC,         # le message
            ["/var/www/html/terraspi/img/alerte.jpeg"])             # chemin pièce jointe          

sys.exit(1)
