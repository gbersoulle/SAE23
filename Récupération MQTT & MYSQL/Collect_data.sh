#!/bin/bash

# MQTT configuration
mqtt_host="mqtt.iut-blagnac.fr"
mqtt_port="1883"
mqtt_topic="Student/by-room/#"

#MySQL configuration
servername="lhcp3164.webapps.net"
username="ku55c1se_mysqluser"
password="mysqlpassroot"
dbname="ku55c1se_sae23"
mysql_port="3306"

#decommenter pour un test en local 
# servername="192.168.80.130"
# username="passroot"
# password="passroot"
# dbname="sae23"
# mysql_port="3306"


while true; do

    # MQTT subscription and data processing
    data=$(mosquitto_sub -h "$mqtt_host" -p "$mqtt_port" -t "$mqtt_topic" -C 1)
    deviceName=$(echo "$data" | jq -r '.[1].room')

    # Insert data into MySQL database based on ID_capteur
    case $deviceName in
        # B001 et E006
        AM107-7 | AM107-29 )
            # Parse JSON data depending on what we need
            co2=$(echo "$data" | jq -r '.[0].co2')
            # Insert data into MySQL database
            echo "$deviceName, $co2"
            mysql -h "$servername" -P "$mysql_port" -u "$username" -p"$password" -D "$dbname" -e "INSERT INTO mesure (valeur_mesure, nom_capteur) VALUES ($co2, $deviceName);"
            ;;
        # B203 et E102
        AM107-6 | AM107-32 )
            # Parse JSON data depending on what we need
            humidity=$(echo "$data" | jq -r '.[0].humidity')
            # Insert data into MySQL database
            echo "$deviceName, $humidity"
            mysql -h "$servername" -P "$mysql_port" -u "$username" -p"$password" -D "$dbname" -e "INSERT INTO mesure (valeur_mesure, nom_capteur) VALUES ($humidity, $deviceName);"
            ;;
    esac
done
