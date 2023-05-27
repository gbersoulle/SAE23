#!/bin/bash

# MQTT configuration
mqtt_host="mqtt.iut-blagnac.fr"
mqtt_port="1883"
mqtt_topic="Student/by-room/#"

# MySQL configuration
servername="lhcp3164.webapps.net"
username="ku55c1se_mysqluser"
password="mysqlpassroot"
dbname="ku55c1se_sae23"
mysql_port="3306"


while true; do

    # MQTT subscription and data processing
    data=$(mosquitto_sub -h "$mqtt_host" -p "$mqtt_port" -t "$mqtt_topic" -C 1)
    Time=$(date '+%H:%M:%S')

    # Parse JSON data
    temperature=$(echo "$data" | jq -r '.[0].temperature')
    humidity=$(echo "$data" | jq -r '.[0].humidity')
    activity=$(echo "$data" | jq -r '.[0].activity')
    co2=$(echo "$data" | jq -r '.[0].co2')
    tvoc=$(echo "$data" | jq -r '.[0].tvoc')
    illumination=$(echo "$data" | jq -r '.[0].illumination')
    infrared=$(echo "$data" | jq -r '.[0].infrared')
    infrared_and_visible=$(echo "$data" | jq -r '.[0].infrared_and_visible')
    pressure=$(echo "$data" | jq -r '.[0].pressure')

    # Insert data into MySQL database
    mysql -h "$servername" -P "$mysql_port" -u "$username" -p"$password" -D "$dbname" -e "INSERT INTO mesure (temperature, humidity, activity, co2, tvoc, illumination, infrared, infrared_and_visible, pressure) VALUES ($temperature, $humidity, $activity, $co2, $tvoc, $illumination, $infrared, $infrared_and_visible, $pressure);"
done
