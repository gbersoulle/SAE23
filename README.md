# SAE23
## Problématique professionnelle

Le professionnel R&T, au cœur du système d'information de l'entreprise, est amené à développer différentes solutions informatiques : ces solutions peuvent faciliter son travail quotidien (outil pour centraliser les données d'administration du réseau) ou être commandées pour les besoins de ses collaborateurs (annuaire des personnels, partage d'informations, ...).

Ces solutions sont plus larges que le simple traitement des données et visent le développement d'un outil informatique complet partant d'un cahier des charges donné : les solutions incluent la gestion de données structurées (base de données, fichiers de données), les traitements et les éléments d'interaction utilisateurs via une interface conviviale et pratique.

Les résultats peuvent être documentés grâce à des pages Web voire mis à disposition des utilisateurs directement dans des navigateurs Web.  

Le professionnel R&T doit donc mobiliser son expertise en développement informatique pour le compte de son entreprise.

## Descriptif et objectifs de la SAÉ
Progression

Volume horaire

    16h encadrées : 1C (1.5h) semaine 20, 3 TP (12h) semaine 19, 20 et 22, 1 TP évaluation en semaine 24
    12h projet en autonomie : 3 TP (12h) de la semaine 21 à 23

Situation professionnelle IoT
Exploiter les données provenant de capteurs répartis dans les bâtiments de l’IUT en proposant une interface dédiée.
Objectif

    Deux bâtiments avec chacun un gestionnaire (compte avec login et mot de passe)
    Deux capteurs (type au choix) par bâtiment
    Dashboard Grafana avec les 4 capteurs
    Conception d’une base de données MySQL
    Site web dynamique hébergé sur un serveur lampp
    Présentation des données et métrique sous forme de tableau

Cahier des charges : tâches principales

    Mettre en place une chaîne de traitement via des conteneurs.
    Créer un dashboard Grafana complet.
    Coder un site web dynamique hébergé sur un serveur lampp.
    Coder un script récupérant les données sur le bus MQTT (langage au choix : bash, php, C, python,…).
    Créer et gérer une base de données MySQL.
    Automatiser la chaîne de traitement (scripts dans crontab)

Contraintes techniques

    Environnement : machine virtuelle
    Système d’exploitation : GNU/Linux (Lubuntu 20.04)
    Langages autorisés : HTML5, CSS3, PHP, Javascript, Bash, C, Python.
    Codes documentés (commentaires pertinents dans le code) en anglais
    Publication sur un serveur web dédié (xampp)
    Gestion de version via Git et Github
