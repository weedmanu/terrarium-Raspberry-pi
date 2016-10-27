#!/usr/bin/python
#-*- coding: utf-8 -*-

# import des librairies
import json
import Adafruit_DHT
import time
import MySQLdb
import os
import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEBase import MIMEBase
from email.MIMEText import MIMEText
from email.Utils import COMMASPACE, formatdate
from email import Encoders

# on ouvre le fichier config .json
with open('/var/www/html/terraspi/config.json') as config:    
    data = json.load(config)

# On défini la limite basse et haute pour l'envoi d'un mail si la limite est dépassée
limiteBasse = int(data["warning"]["limite_basse"])
limiteHaute = int(data["warning"]["limite_haute"])

# Récupérer la date et l'heure
dateandtime = time.strftime('%Y-%m-%d %H:%M',time.localtime())      

#  On lit les sondes
humF, tempF = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, int(data["gpio"]["sonde"]["pointfroid"]))   #   point froid    
humC, tempC = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, int(data["gpio"]["sonde"]["pointchaud"]))   #  point chaud

 # On arrondi a 2 chiffres 
humF = round(humF,2)                  
tempF = round(tempF,2)

humC = round(humC,2)
tempC = round(tempC,2)

# Connexion a la base MySQL
bdd = MySQLdb.connect(host="localhost",user=data["mysql"]["login_mysql"],passwd=data["mysql"]["mdp_mysql"],db="Terrarium")  
req = bdd.cursor()

# Envoi a la base de donnée

try:
    req.execute("""insert into capteurdata (`dateandtime`,`tempF`,`humF`,`tempC`,`humC`) values (%s,%s,%s,%s,%s)""",(dateandtime,tempF,humF,tempC,humC))
    bdd.commit()
    
except:
    bdd.rollback()
    
    # Fermeture de la connexion
    
bdd.close()

# fonction sendmail
USERNAME = data["mail"]["envoyeur"]       # adresse de l'envoyeur
PASSWORD = data["mail"]["mdp_envoyeur"]                  # mot de passe

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
        
    sendMail( [data["mail"]["receveur"]],           # adresse ou l'on veut envoyer le mail
            "Alerte terrarium !!!!",              # sujet  
            "limite atteinte, il fait %s °C au point chaud ,connecte toi vite !!!" %tempC,         # le message
            ["/var/www/html/terraspi/img/alerte.jpeg"])             # chemin pièce jointe          
             
