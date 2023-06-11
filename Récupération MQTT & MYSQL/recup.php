<?php
require_once("../connexion_bdd.php");

// Execution of the PowerShell command to retrieve MQTT messages
//$command = 'mosquitto_sub -h mqtt.iut-blagnac.fr -t "Student/by-room/#" -C 2';
$output = array('[{"temperature":25.6,"humidity":57.5,"activity":0,"co2":434,"tvoc":212,"illumination":1,"infrared":1,"infrared_and_visible":1,"pressure":990.4,"Latitude":43.6488366,"Langitude":1.3741088},{"deviceName":"AM107-3","devEUI":"24e124128c011586","room":"B111","floor":1,"Building":"B"}]');
// Execute the command and store the output
//exec($command, $output, $returnCode);

// Array to store each sensor's data
$capteurData = array();
if ($returnCode ===0 ){
// Iterate over the output lines
foreach ($output as $line) {
    // Convert the JSON line to an associative array
    $data = json_decode($line, true);
    
    // Check if the conversion was successful
    if ($data !== null) {
        if (isset($data[1]['deviceName'])) {
            $capteurName = $data[1]['deviceName'];
            $salle = $data[1]['room'];

            // Retrieve sensor measurement data
            $mesures = array();
            foreach ($data[0] as $key => $value) {
                if (isset($value)) {
                    $nomCapteur = $salle . $key;
                    $valeurMesure = $value;

                    // Add measurement data to the associative array
                    $mesures[$nomCapteur] = $valeurMesure;
                }
            }

            // Add sensor data to the main array
            $capteurData[$capteurName] = $mesures;
        }
    }
}

// Insert the extracted data into the database
foreach ($capteurData as $capteurName => $mesures) {
    foreach ($mesures as $nomCapteur => $valeurMesure) {
        $sql = "INSERT INTO mesure (valeur_mesure, nom_capteur) VALUES ('$valeurMesure', '$nomCapteur')";
        mysqli_query($connexion, $sql); //if succed > data added, if failed, there is no existing sensor related to the data
    }
}
}
?>
<!-- 
'[{"temperature":25.4,"humidity":57.5,"activity":0,"co2":419,"tvoc":222,"illumination":1,"infrared":1,"infrared_and_visible":1,"pressure":989.9},{"deviceName":"AM107-4","devEUI":"24e124128c017412","room":"B201","floor":2,"Building":"B"}]',
    '[{"temperature":25.6,"humidity":55.5,"activity":0,"co2":443,"tvoc":527,"illumination":0,"infrared":1,"infrared_and_visible":2,"pressure":990.5,"Latitude":43.6487051,"Langitude":1.374548},{"deviceName":"AM107-14","devEUI":"24e124128c0166","room":"B106","floor":1,"Building":"B"}]',
    '[{"temperature":26.1,"humidity":55,"activity":0,"co2":419,"tvoc":194,"illumination":1,"infrared":1,"infrared_and_visible":1,"pressure":990.6},{"deviceName":"AM107-9","devEUI":"24e124128c014516","room":"B003","floor":0,"Building":"B"}]',
    '[{"temperature":24.8,"humidity":60,"activity":0,"co2":410,"tvoc":2017,"illumination":1,"infrared":2,"infrared_and_visible":4,"pressure":990.4,"Latitude":43.6492597,"Langitude":1.3748561},{"deviceName":"AM107-50","devEUI":"24e1241c016491","room":" hall-amphi","floor":0,"Building":"A"}]',
    '[{"temperature":25.6,"humidity":57.5,"activity":0,"co2":434,"tvoc":212,"illumination":1,"infrared":1,"infrared_and_visible":1,"pressure":990.4,"Latitude":43.6488366,"Langitude":1.3741088},{"deviceName":"AM107-3","devEUI":"24e124128c0115","room":"B111","floor":1,"Building":"B"}]',
    '[{"temperature":27.7,"humidity":51,"activity":0,"co2":426,"tvoc":324,"illumination":1,"infrared":1,"infrared_and_visible":1,"pressure":989.9},{"deviceName":"AM107-22","devEUI":"24e124128c016872","room":"B234","floor":2,"Building":"C"}]',
    '[{"temperature":25.5,"humidity":57.5,"activity":0,"co2":417,"tvoc":2871,"illumination":13,"infrared":5,"infrared_and_visible":16,"pressure":990.2},{"deviceName":"AM107-19","devEUI":"24e124128c014695","room":"B212","floor":2,"Building":"}]',
    '[{"temperature":25.7,"humidity":56.5,"activity":0,"co2":406,"tvoc":718,"illumination":1,"infrared":1,"infrared_and_visible":1,"pressure":989.9},{"deviceName":"AM107-20","devEUI":"24e124128c014727","room":"B217","floor":2,"Building":"B"}]',
    '[{"temperature":25.6,"humidity":57.5,"activity":0,"co2":413,"tvoc":1897,"illumination":4,"infrared":1,"infrared_and_visible":4,"pressure":990},{"deviceName":"AM107-17","devEUI":"24e124128c012135","room":"B112","floor":1,"Building":"B"}]', -->