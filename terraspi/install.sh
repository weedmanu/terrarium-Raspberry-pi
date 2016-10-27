#!/bin/sh

echo ""
echo ""
echo "     ////////////////////////////////////////////////"
echo "     //     Début du programme d'installation      //"
echo "     ////////////////////////////////////////////////"
echo ""
apt-get update && apt-get upgrade -y
echo ""
echo""
echo "Voulez-vous installer build , python , pip et la librairie ephem :"
echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
read ouinon
if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then
    apt-get install apt-transport-https -y && apt-get install build-essential python-dev python-openssl git python-pip -y
    echo ""
	pip install ephem 
elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
    echo "Ok"
else
    echo "Il faut taper Y ou N!! Pas $ouinon"
fi
echo ""
echo  "Voulez-vous installer la librairie Adafruit_Python_DHT pour communiquer avec les sondes :"
echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
read ouinon
if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then
    cd /home/pi
	git clone https://github.com/adafruit/Adafruit_Python_DHT.git
	cd Adafruit_Python_DHT
	python setup.py install
    
elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
    echo "Ok"
else
    echo "Il faut taper Y ou N!! Pas $ouinon"
fi
echo""
echo  "Voulez-vous installer la librairie RPLCD pour communiquer avec l'écran LCD :"
echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
read ouinon
if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then
    cd /home/pi
	git clone https://github.com/dbrgn/RPLCD
	cd RPLCD
	python setup.py install
    
elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
    echo "Ok"
else
    echo "Il faut taper Y ou N!! Pas $ouinon"
fi
echo""
echo "Voulez-vous installer mysql apache php et phpmyadmin :"
echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
read ouinon
if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then
    cd /home/pi
	apt-get install mysql-server python-mysqldb apache2 php5 libapache2-mod-php5 php5-mysql phpmyadmin -y
	   
elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
    echo "Ok"
else
    echo "Il faut taper Y ou N!! Pas $ouinon"
fi
echo ""
dbname="Terrarium"
echo""
echo "Voulez-vous configurer de la base de donnée Terrarium et création de l'utilisateur :"
echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
read ouinon
if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then
	echo ""
	echo "Entrer le mot de passe root mysql , puis touche entrée pour valider"
    read mdproot
	echo ""
	echo "Création de la base de donnée ....."
	mysql -uroot -p${mdproot} -e "CREATE DATABASE ${dbname};"
	echo""
	echo "liste des base de donnée de mysql, la base Terrarium doit être présente"
	mysql -uroot -p${mdproot} -e "show databases;"
	echo ""
	echo "Voulez-vous définir un nom d'utilisateur :"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo "Définir un nom d'utilisateur"
		read loginbdd
		echo ""
		echo "Définir le mot de passe de cet utilisateur"
		read mdpbdd
		echo ""
		echo "Création du nouvel utilisateur et donne les droits sur la base de donnée Terrarium"
		echo ""
		mysql -hlocalhost -uroot -p${mdproot} -e "CREATE USER ${loginbdd}@localhost IDENTIFIED BY '${mdpbdd}';"
		mysql -hlocalhost -uroot -p${mdproot} -e "GRANT ALL PRIVILEGES ON ${dbname}.* TO '${loginbdd}'@'localhost';"
		mysql -hlocalhost -uroot -p${mdproot} -e "FLUSH PRIVILEGES;"
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
		echo "Ok"
	else
		echo "Il faut taper Y ou N!! Pas $ouinon"
	fi			
	echo "Voulez-vous créer la table capteurdata :"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo ""
		mysql -u${loginbdd} -p${mdpbdd} -hlocalhost -D${dbname} -e "CREATE TABLE capteurdata (dateandtime DATETIME, tempF DOUBLE, humF DOUBLE, tempC DOUBLE, humC DOUBLE);"
		echo ""				
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
		echo "Ok"
	else
		echo "Il faut taper Y ou N!! Pas $ouinon"
	fi
	echo "Voulez-vous créer la table config :"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then		   
		echo "on créer la table config"
		echo ""
		mysql -u${loginbdd} -p${mdpbdd} -hlocalhost -D${dbname} -e "CREATE TABLE config (dateetheure DATETIME, loginadmin VARCHAR(32), mdpadmin VARCHAR(32), longitude FLOAT, latitude FLOAT, altitude INT, limitebasse INT, limitehaute INT, jour INT, nuit INT, warmpi INT, envoyeur VARCHAR(32), mdpenvoyeur VARCHAR(32), receveur VARCHAR(32), ip VARCHAR(32));"
		echo ""
		echo "on redémarre mysql "
		echo ""
		/etc/init.d/mysql restart
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
		echo "Ok"
	else
		echo "Il faut taper Y ou N!! Pas $ouinon"
	fi
elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
    echo "Ok"
else
    echo "Il faut taper Y ou N!! Pas $ouinon"
fi
echo""
echo "téléchargement et installation de terraspiV2"
echo ""
cd /var/www/html/
rm index.html
rm -R terraspi
cd /home/pi/
rm -R terra
chown -R www-data:pi /var/www/html/
chmod -R 770 /var/www/html/
echo ""
cd /home/pi
git clone https://github.com/weedmanu/terraspiV2.git
cd /home/pi/terraspiV2
mv terraspi -t /var/www/html/
chown -R www-data:pi /var/www/html/
chmod -R 770 /var/www/html/
cd /var/www/html/terraspi/
cp install.sh -t /var/www/html/terraspi/prog/
cd /var/www/html/terraspi/prog/
echo ""
echo "Voulez-vous régler la config ?"
echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
read ouinon
if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then		
	echo ""
	echo "     ////////////////////////////////////////////////////"
	echo "     //   Réglage des paramètres du fichier bdd.json   //"  
	echo "     //   	dans /var/www/html/terraspi/prog/        //"  
	echo "     ////////////////////////////////////////////////////"
	echo ""
	echo "    **************"
	echo "    *    MySQL   *"
	echo "    **************"
	echo ""
	echo "login mysql"
	echo ""
	read loginbdd
	sed -i "s/loginbdd/${loginbdd}/g" bdd.json
	echo "ok"
	echo ""
	read mdpbdd
	echo "mot de passe "
	echo ""
	sed -i "s/mdpbdd/${mdpbdd}/g" bdd.json
	echo "ok"		
	echo ""
	echo ""
	echo "     ////////////////////////////////////////////////////"
	echo "     //   Réglage des paramètres de la base de donnée  //"  
	echo "     ////////////////////////////////////////////////////"
	echo ""
	echo "Voulez-vous régler la position ?"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo ""
		echo "    *********************"
		echo "    *     position      *"
		echo "    *********************"
		echo ""
		echo "pour connaitre votre position vous pouvez aller ici:"
		echo ""
		echo "        http://www.mapsdirections.info/fr/coordonnees-sur-google-map.html"
		echo ""
		echo "quelle est votre longitude :"
		echo ""
		echo "taper entrée pour valider"
		read longitude
		echo ""
		echo "quelle est votre latitude :"
		echo ""
		echo "taper entrée pour valider"
		read latitude
		echo ""
		echo "quelle est votre altitude :"
		echo ""
		echo "taper entrée pour valider"
		read altitude
		echo ""		
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
		echo "Ok"
	else
		echo "Il faut taper Y ou N!! Pas $ouinon"
	fi
		echo ""
		echo "Voulez-vous régler les consigne de température ?"
		echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
		read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo ""
		echo "    *********************************"
		echo "    *  consigne de température      *"
		echo "    *********************************"
		echo ""
		echo "quelle est votre consigne de température pour le jour :"
		echo ""
		echo "taper entrée pour valider"
		read jour
		echo ""
		echo "quelle est votre consigne de température pour la nuit :"
		echo ""
		echo "taper entrée pour valider"
		read nuit
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
	echo "Ok"
	else
	echo "Il faut taper Y ou N!! Pas $ouinon"
	fi
	echo ""
	echo "Voulez-vous régler les limites de température ?"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo ""
		echo "    ***********************************"
		echo "    *     limite des température      *"
		echo "    ***********************************"
		echo ""
		echo "quelle est votre limite basse de température pour être prévenu :"
		echo ""
		echo "taper entrée pour valider"
		read limitebasse
		echo ""
		echo "quelle est votre limite haute de température pour être prévenu :"
		echo ""
		echo "taper entrée pour valider"
		read limitehaute
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
	echo "Ok"
	else
	echo "Il faut taper Y ou N!! Pas $ouinon"
	fi
	echo ""
	echo "Voulez-vous régler la partie mail ?"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo ""
		echo "    *************************"
		echo "    *     adresse mail      *"
		echo "    *************************"
		echo ""
		echo "quelle est l'adresse mail de l'envoyeur de l'alerte (gmail obligatoire) :"
		echo ""
		echo "taper entrée pour valider"
		read envoyeur
		echo ""
		echo "quelle est son mot de passe :"
		echo ""
		echo "taper entrée pour valider"
		read mdpenvoyeur
		echo ""
		echo "quelle est l'adresse mail à qui on veut envoyer l'alerte (gmail pas obligatoire) :"
		echo ""
		echo "taper entrée pour valider"
		read receveur
		echo ""
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
	echo "Ok"
	else
	echo "Il faut taper Y ou N!! Pas $ouinon"
	fi	
	echo ""
	echo "Voulez-vous régler la partie admin ?"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then			
		echo ""
		echo "    ******************"
		echo "    *     Admin      *"
		echo "    ******************"
		echo ""
		echo "Entrer un nom d'utilisteur pour la page web admin :"
		echo ""
		echo "taper entrée pour valider"
		read loginadmin
		echo ""
		echo "définir un mot de passe pour cet utilisateur :"
		echo ""
		echo "taper entrée pour valider"
		read mdpadmin
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
	echo "Ok"
	else
	echo "Il faut taper Y ou N!! Pas $ouinon"
	fi
	echo ""
	echo "Voulez-vous régler la partie ip ?"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo ""
		echo "    ***************"
		echo "    *     IP      *"
		echo "    ***************"
		echo ""
		echo "quelle est l'ip de votre Raspberry pi :"
		echo ""
		echo "taper entrée pour valider"
		read ip
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
	echo "Ok"
	else
	echo "Il faut taper Y ou N!! Pas $ouinon"
	fi	
	echo ""
	echo "Voulez-vous régler la partie warnig pi ?"
	echo "OUI OBLIGATOIRE POUR UNE PREMIERE INSTALLATION (Y/N)"
	read ouinon
	if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then	
		echo ""
		echo ""
		echo "    ******************"
		echo "    *   Raspberry    *"
		echo "    ******************"
		echo ""
		echo "quelle est la consigne de température max de votre Raspberry pi :"
		echo ""
		echo "taper entrée pour valider"
		read warmpi
		echo ""
	elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
	echo "Ok"
	else
	echo "Il faut taper Y ou N!! Pas $ouinon"
	fi
	echo ""
	dateetheure=$(date +%Y%m%d%H%M%S)
	echo ""
	echo ""
	mysql -uroot -p${mdproot} -hlocalhost -D${dbname} -e "INSERT INTO bdd (dateetheure, loginadmin, mdpadmin, longitude, latitude, altitude, warmpi, limitebasse, limitehaute, jour, nuit, warmpi, receveur, envoyeur, mdpenvoyeur, ip) VALUES ( '$dateetheure', '$loginadmin', '$$mdpadmin', '$longitude', '$latitude', '$altitude', '$limitebasse', '$limitehaute', '$jour', '$nuit', '$warmpi', '$receveur', '$envoyeur', '$mdpenvoyeur', '$ip' )";
	echo ""		
elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
echo "Ok"
else
echo "Il faut taper Y ou N!! Pas $ouinon"
fi
echo ""
echo "     //////////////////////////////////////////////"
echo "     //   Fin du réglage du fichier bdd.json  //"
echo "     //////////////////////////////////////////////"
echo ""
echo "Et je dirais même plus , "
cd /var/www/html/terraspi/
rm install.sh
cd /home/pi/
rm -R terraspiV2
crontab -upi -l > tachecron
echo "* * * * * python /var/www/html//terraspi/prog/terra.py > /dev/null 2>&1" $
echo "*/15 * * * * python /var/www/html/terraspi/prog/bdd.py > /dev/null 2>&1" $
crontab -upi tachecron
rm tachecron
cp /etc/rc.local /home/pi/test
sed -i '$d' test
echo "python /var/www/html//terraspi/prog/bdd.py" >> test
echo "" >> test
echo "exit 0" >> test
mv test /etc/rc.local
rm test
echo ""
echo "           ********************************"
echo "           ********************************"
echo "           **    FIN de l' installation   **"
echo "           ********************************"
echo "           ********************************"
echo ""
echo "taper :"
echo ""
echo "   http://${ip}/terraspi/accueil "
echo ""
echo "dans votre navigateur internet et constater !!!! "
echo ""
echo "powered by weedmanu "
exit




