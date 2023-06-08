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

while true; do

    # MQTT subscription and data processing
    data=$(mosquitto_sub -h "$mqtt_host" -p "$mqtt_port" -t "$mqtt_topic" -C 1)

    # Iterate over each object in the JSON array
    for object in $(echo "$data" | jq -c '.[0]'); do
        #store the room name
        room=$(echo "$data" | jq -r '.[1].room')

        # Extract key=>value combination from the object
        while read -r dataType value; do
            # Check if the value is a number : "=~" means check strings; "^" marks the start of the regular expression to match;
            #"[0-9]" match numbers; "+([.][0-9]+)?" matches an optional decimal part; "$" marks the end
            if  [[ $value =~ ^[0-9]+([.][0-9]+)?$ ]]; then
                #sets the device name as a concatenation of the room name and the type of data
                deviceName=$room$dataType
                echo "$dataType is $value"
                #send the value and the device name in the sql DB
                mysql -h "$servername" -P "$mysql_port" -u "$username" -p"$password" -D "$dbname" -e "INSERT INTO mesure (valeur_mesure, nom_capteur) VALUES ('$value', '$deviceName');"

            fi
        done < <(echo "$object" | jq -r 'to_entries[] | [.dataType, .value] | @tsv')
    done

done