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
    ID_capteur=$(echo "$data" | jq -r '.[1].devEUI')

    # Insert data into MySQL database based on ID_capteur
    case $ID_capteur in
        24e124128c012259 | 24e124128c016509)
            # Parse JSON data depending on what we need
            co2=$(echo "$data" | jq -r '.[0].co2')
            # Insert data into MySQL database
            echo "$ID_capteur, $co2"
            mysql -h "$servername" -P "$mysql_port" -u "$username" -p"$password" -D "$dbname" -e "INSERT INTO mesure (id_capteur, date_mesure, valeur_mesure) VALUES ('$ID_capteur', DATE_FORMAT(NOW(), '%d %b %H:%i:%s'), $co2);"
            ;;
        24e124128c011778 | 24e124128c016122)
            # Parse JSON data depending on what we need
            humidity=$(echo "$data" | jq -r '.[0].humidity')
            # Insert data into MySQL database
            echo "$ID_capteur, $humidity"
            mysql -h "$servername" -P "$mysql_port" -u "$username" -p"$password" -D "$dbname" -e "INSERT INTO mesure (id_capteur, date_mesure, valeur_mesure) VALUES ('$ID_capteur', DATE_FORMAT(NOW(), '%d %b %H:%i:%s'), $humidity);"
            ;;
    esac
done

