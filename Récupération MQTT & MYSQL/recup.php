<?php

// Inclure le fichier de connexion à la base de données
require_once '../connexion_bdd.php';


// $command = 'mosquitto_sub -h mqtt.iut-blagnac.fr -t "Student/by-room/#" -C 1';
$json = '[{"temperature":25.6,"humidity":57.5,"activity":0,"co2":434,"tvoc":212,"illumination":1,"infrared":1,"infrared_and_visible":1,"pressure":990.4,"Latitude":43.6488366,"Longitude":1.3741088},{"deviceName":"AM107-3","devEUI":"24e124128c011586","room":"B111","floor":1,"Building":"B"}]';
// exec($command, $json, $ReturnCode);
// Convertir le tableau en chaîne JSON
$jsonString = json_encode($json);

// Convertir le JSON en tableau associatif
$output = json_decode($jsonString, true);

// Récupérer les informations sur les capteurs existants depuis la table "capteur"
$query = "SELECT nom_capteur FROM capteur";
$result = mysqli_query($connexion, $query);
$capteurs_existants = [];
while ($row = mysqli_fetch_assoc($result)) {
    $capteurs_existants[] = $row['nom_capteur'];
}
echo "aaaa";
print_r($output);
// Parcourir le tableau de output et insérer les données des capteurs existants dans la base de données
    $room = $output['room'];
    foreach ($output as $capteur => $valeur) {
        // Construire le nom_capteur
        $nom_capteur = $room . $capteur;
        echo "$nom_capteur";
        // Vérifier si le capteur existe dans la table "capteur"
        if (in_array($nom_capteur, $capteurs_existants)) {
            // Insérer les données dans la table "mesure"
            $query = "INSERT INTO mesure (valeur_mesure, nom_capteur) VALUES ('$valeur', '$nom_capteur')";
            echo "$query";
            mysqli_query($connexion, $query);
            echo "$query executed <br>";
        }
    }


echo "fin d'ajout capteur";
// Fermer la connexion à la base de données
mysqli_close($connexion);
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
    '[{"temperature":25.6,"humidity":57.5,"activity":0,"co2":413,"tvoc":1897,"illumination":4,"infrared":1,"infrared_and_visible":4,"pressure":990},{"deviceName":"AM107-17","devEUI":"24e124128c012135","room":"B112","floor":1,"Building":"B"}]', 
    
    [{"temperature":23.8,"humidity":64,"activity":0,"co2":446,"tvoc":2251,"illumination":2,"infrared":3,"infrared_and_visible":7,"pressure":991.1},{"deviceName":"AM107-26","devEUI":"24e124128c017035","room":"E003","floor":0,"Building":"E"}]
    [{"temperature":22.6,"humidity":45,"activity":0,"co2":484,"tvoc":53,"illumination":25,"infrared":9,"infrared_and_visible":29,"pressure":990.6},{"deviceName":"AM107-37","devEUI":"24e124128c019569","room":"E100","floor":1,"Building":"E"}]
    [{"temperature":25.7,"humidity":54.5,"activity":19,"co2":709,"tvoc":187,"illumination":9,"infrared":5,"infrared_and_visible":14,"pressure":990.6,"Latitude":43.6497237,"Langitude":1.3745503},{"deviceName":"AM107-34","devEUI":"24e124128c012114","room":"E104","floor":1,"Building":"E"}]
    [{"temperature":25.8,"humidity":57,"activity":0,"co2":488,"tvoc":154,"illumination":16,"infrared":7,"infrared_and_visible":21,"pressure":989.8},{"deviceName":"AM107-6","devEUI":"24e124128c011778","room":"B203","floor":2,"Building":"B"}]
    [{"temperature":24.8,"humidity":59.5,"activity":2,"co2":540,"tvoc":1721,"illumination":15,"infrared":3,"infrared_and_visible":13,"pressure":990.2,"Latitude":43.6487502,"Langitude":1.3741942},{"deviceName":"AM107-16","devEUI":"24e124128c144603","room":"B109","floor":1,"Building":"B"}]
    [{"temperature":24.4,"humidity":52.5,"activity":15,"co2":689,"tvoc":212,"illumination":26,"infrared":5,"infrared_and_visible":22,"pressure":990.2,"Latitude":43.6496578,"Langitude":1.3745842},{"deviceName":"AM107-35","devEUI":"24e124128c010317","room":"E105","floor":1,"Building":"E"}]
    [{"temperature":22.4,"humidity":69.5,"activity":0,"co2":449,"tvoc":983,"illumination":1,"infrared":2,"infrared_and_visible":4,"pressure":991.1,"Latitude":43.6486599,"Langitude":1.374326},{"deviceName":"AM107-10","devEUI":"24e124128c013816","room":"B101","floor":1,"Building":"B"}]
    [{"temperature":26.4,"humidity":54.5,"activity":0,"co2":453,"tvoc":612,"illumination":72,"infrared":24,"infrared_and_visible":80,"pressure":990.7,"Latitude":43.6496903,"Langitude":1.3744175},{"deviceName":"AM107-33","devEUI":"24e124128c019417","room":"E103","floor":1,"Building":"E"}]
    [{"temperature":24.6,"humidity":59.5,"activity":0,"co2":469,"tvoc":870,"illumination":57,"infrared":14,"infrared_and_visible":54,"pressure":990.8},{"deviceName":"AM107-49","devEUI":"24e124128c017200","room":"hall-entr├®e-principale","floor":0,"Building":"A"}]

-->