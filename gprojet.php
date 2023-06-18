<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de projet</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

    <?php require_once 'header.php'?>

    <h1><span id="typed-text"></span> ~ </h1>

    <section> 
        <h2 class="t_center h2-acc">Diagrammes de GANTT </h2>
            <p class="parag"> L'établissement d'un diagramme de Gantt initial en début de projet a été essentiel pour une gestion efficace du projet. Cela nous a permis de planifier les différentes tâches et étapes du projet de manière visuelle. De plus, cet outil nous a aidé à anticiper les retards par rapport au planning initial et à prévoir une marge de manœuvre pour compenser ces derniers. </p>
            <div class="blockgest">   
                <figure class="right"> 
                    <img id="gantt-initial" src="./images/gantt-initial.png"  alt="Diagramme de GANTT initial">
                </figure> 
                <figure class="left"> 
                <img id="gantt-final" src="./images/gantt-final.png" alt="Diagramme de GANTT final">
                </figure> 
            </div>
            <p class="parag"> En ce qui concerne le diagramme de Gantt final, il joue un rôle crucial dans l'évaluation du projet une fois terminé. Il nous permet de comparer la planification initiale avec les réalisations finales. Cela nous donne une vision claire des tâches qui ont été effectuées et de la réussite globale du projet. En analysant les écarts entre le diagramme initial et le diagramme final, nous pouvons tirer des enseignements pour l’organisation des futurs projets. </p>    
    </section>
    
    <section> 
        <h2 class="t_center h2-acc"> Visualisation des données via la solution de conteneurisation Docker   </h2>
        <p class="parag"> Docker est une solution de conteneurisation qui permet de créer, distribuer et exécuter des applications de manière portable et isolée. Les conteneurs Docker encapsulent les applications et leurs dépendances. Docker utilise une technologie de virtualisation légère qui partage le noyau du système d'exploitation hôte, offrant ainsi une meilleure efficacité des ressources. Les conteneurs Docker sont rapides à démarrer et à arrêter, ce qui facilite le déploiement des applications. </p>
        <p class="parag"> Nous avons cherché au cours cette partie du projet à utiliser les dockers pour proposer aux différents utilisateurs une expérience de visualisation des données fluides et agréables. Pour ce faire, nous avons utilisé deux technologies majeures : Node-Red et Grafana Dashboard. </p>
        <p class="parag"> Node-RED est un environnement de développement visuel utilisé pour créer des applications d'automatisation, très souvent utilisé en IoT car fournissant une architecture de travail basé sur des nœuds qui peuvent être connectés et configurés pour créer des scénarios complexes. <br>
                        Grafana, quant à lui, est une plateforme open-source d'analyse et de visualisation des données en temps réel. Elle permet de créer des tableaux de bord interactifs et  personnalisables pour surveiller et analyser des données provenant de différentes sources.</p>
        <p class="parag"> Vous pouvez observer ci-dessous les différents dashboards crée au cours de cet exercice. Pour plus d’informations sur cet exercice, veuillez vous rapporter au fichier de configuration de la solution docker disponible en téléchargement plus loin dans cette page. </p>
            <figure class="blockgest">
                <div class="right">
                    <img id="node-red" src="./images/Node-Red.jpg" alt="Flow Node-Red" title="Flow Node-Red">
                </div>
                <div class="left">
                    <img id="node-pres" src="./images/Node-Red-Pres.jpg" alt="Capture d'écran 1" title="Node-Red Dashboard">
                </div>
            </figure>
            <img id="grafana" src="./images/Grafana.jpg" alt="Capture d'écran 2" title="Solution de visualisation Grafana">
    </section> 
    
    <section> 
        <h2 class="t_center h2-acc">Outils collaboratifs utilisés</h2>
            <p class="parag"> Dans le cadre de notre projet, nous avons utilisé plusieurs outils pour faciliter notre travail collaboratif. </p>
            <p class="parag"> GitHub, une plateforme de développement, nous a permis de suivre les modifications, de gérer les versions et de collaborer efficacement au sein de notre équipe de développement sur le site web dynamique. Trello, quant à lui, nous a aidés à organiser nos tâches et à suivre l'avancement de nos projets grâce à ses tableaux visuels intuitifs. Enfin, Google Drive a été notre principal service de stockage en ligne, nous permettant de sauvegarder, synchroniser et partager nos fichiers, ainsi que de collaborer en temps réel sur des documents. </p> 
            <p class="parag"> Grâce à ces outils, notre travail a été optimisé et notre collaboration a été plus fluide et productive. </p>
            <p class="p_center"> Git - Github </p>
                <figure>
                    <img id="github" src="./images/github.png" alt="Repository Git-Hub de la SAE23" class="img_gprojet">
                </figure>
                
            <p class="p_center"> Google Drive </p>
                <figure>
                    <img src="./images/google-drive.png" alt="Espace de partage de fichiers" class="img_gprojet">
                </figure> 
            
            <p class="p_center"> Trello </p>
                <figure>
                    <img src="./images/trello.png" alt="Capture d'écran 1" class="img_gprojet">
                </figure>    
    </section>
    
    
    <h2 class="t_center h2-acc">Bilan personnel, implication, problèmes et solutions apportées</h2>

    <section>
    
    <ul>

        <li> <h4 class="h4-acc" onclick="toggleDetails('member1')">Gaspard Bersoullé</h4> <!-- Allowing the part to be hidden by double-clicking on the name -->
        <section id="member1-details" class="member-details">
            
        <h3 class="h3-acc"> Synthèse personnelle : </h3>
                <p class="parag"> La SAÉ 23 a été une expérience enrichissante, tant sur le plan des sujets abordés que de leur application concrète, notamment avec la récupération de capteurs réels à l'IUT. Après avoir réparti les tâches lors de nos premières réunions, il a été convenu que je me concentrerais principalement sur le développement de scripts PHP et sur le développement de la base de donnée, tels que la création de la page d'administration de la base de données et la gestion des capteurs.  <br>
                    Ayant des facilités en programmation PHP, j’ai grandement apprécié de pouvoir développer dans ce langage et de pouvoir faire avancer le projet par ce biais-là. Par ailleurs, j'ai facilité le processus de développement en mettant à disposition un hébergeur pour la base de données, permettant ainsi à tous les membres de l'équipe d'y accéder plus facilement et de collaborer de manière simplifiée. </p>
                <p class="parag"> D’autre part, la répartition du travail ayant été équitable, j’ai particulièrement apprécié cette nouvelle expérience de travail en groupe. Notre équipe étant soudé et dynamique, j’ai pris plaisir à travailler avec mes camarades. Leur efficacité ainsi que leur régularité ont été très appréciable. </p>
            
            <h3 class="h3-acc"> Problèmes rencontrés et solutions proposées : </h3>
                <p class="parag"> Je m’étais déjà exercé à la manipulation d’une base de donnée par des formulaires HTML, je me suis donc appuyé sur ce que j’avais déjà fait tout en l’adaptant à notre base de donnée. Ce qui m’a donné le plus de fil à retordre fût le filtrage pour l’affichage des mesures de chaque capteur pour la page de gestion.
                <p class="parag"> Il m’a fallu procéder par étapes :
                <ol class="parag"   > 
                    <li> Afficher l’entièreté de tous les capteurs du bâtiment géré par l’utilisateur connecté : Il faut pour ça récupérer l’utilisateur enregistré dans la session et trouver son bâtiment pour ensuite récupérer tout les capteurs associés. </li>
                    <li> Afficher l’unité des mesures du capteur :  Pour ça il faut récupérer le type de capteur et on utilise la fonction “switch” pour définir l’unité ce qui permet d’éviter l'enchainement de si/sinon. </li> 
                    <li> Trier les capteurs par nom : On crée une requête SQL qui récupère tous les capteurs de base, à laquelle, (si on soumet le formulaire de filtre avec une valeur pour le nom du capteur sélectionné) on concatène “AND type_capteur = '$typeCapteurSelectionne'” Pour limiter la sélection du capteur. Pour les autres filtres, qui limite le choix de capteur, il suffit de se baser sur cette méthode. </li> 
                    <li> Trier les mesures par date : 
                        On crée une requête qui récupère toutes les mesures des capteurs précédemment filtrés, à laquelle on concatène " AND DATE(date_mesure) = '$jourChoisi'" pour choisir la date de valeur à afficher.
                        On peut aussi choisir de trier les valeurs en concaténant un ORDER BY pour afficher les valeurs plus récentes ou les valeurs les plus grandes d’abord. </li>
                </ol>
        </section> </li>

        <li> <h4 class="h4-acc" onclick="toggleDetails('member2')">Ange Giuntini</h4>
        <section id="member2-details" class="member-details">
            <h3 class="h3-acc"> Synthèse personnelle : </h3>
                <p class="parag"> J’ai trouvé cette SAE particulièrement intéressante et enrichissante d’un point de vue technique comme organisationnel. En effet, celle-ci m’a permis de mettre en œuvre mes compétences en PHP et JavaScript acquises lors des cours et TPs de la ressource R209 et d'approfondir ces dernières. J'ai également beaucoup appris sur le sujet de l'organisation d'un projet informatique en groupe, notamment via l’utilisation d’outils tels que Trello, gant et bien sur GitHub. </p>
                <p class="parag"> Suite à nos différentes concertations et échanges, il a été convenu que je me charge tout d’abord de la création d’une page connexion. J’ai su répondre à ces attentes en mettant en place une page HTML contenant des formulaires renvoyant les données saisie vers un script PHP. Celui-ci récupère les données envoyées, les stokes et vérifie leur concordance vis-à-vis des tables dans notre base de donnée. J’ai aussi fait en sorte que le header de notre site soit dynamique et qu’il change en fonction de l’utilisateur connecté, lui permettant entre autre de se déconnecter par le biais d’un menu déroulant, rendu possible via un script JavaScript. J’ai finalement proposé un premier fichier de style pour cette page. La réalisation de ces codes s’est passée sans accrocs. </p>
                <p class="parag"> J’ai également dans le cadre de réalisation des test de notre base de donnée modifiée la structure de celle-ci pour correspondre aux attentes du sujet, mais également mis en place un script bash récupérant des données sur le bus MQTT. Les noms des capteurs dont on devait récupérer les valeurs étant écrits en dur dans le code, cela ne permettait aucune évolutivité automatique de la récolte des données vis-avis de la modification de la BDD. Pour permettre cette fonctionnalité, nous avons fait le choix de la simplicité et décidé de réaliser un nouveau script en PHP, c’est Gaspard qui s’en est occupé.</p>
                <p class="parag"> J’ai par la suite entamé la partie la plus complexe du travail que j’aurai à effectuer durant ce projet. Je me suis en effet porté volontaire pour m’occuper de l’affichage dynamique des données sur la page de consultation. L’affichage se fait via un tri par bâtiment puis par salle et finalement par type de donnée en agençant le tout via l’utilisation de menus déroulants. Ainsi, au chargement de la page, le script PHP créé la page web dynamiquement en fonction du contenu de la base de donnée. Chaque donnée est présentée sous forme de jauge changeant de couleur en fonction de la valeur affichée, ceci est rendu possible via l’implémentation de la librairie “justgage.js”. </p>
                <p class="parag"> L’utilisation de fonctions m’a permis de rendre mon code plus optimal et de permettre sa réutilisation. Ainsi, après quelques adaptations de celui-ci, j’ai pu mettre en œuvre le même type génération automatique sur la page de gestion. Les données des bâtiments respectifs de chaque gestionnaire s’affichent donc en fonction des filtres mis en places, classés par salle dans des menus déroulants. Via l’utilisation de la librairie “Chart.js”, j’ai mis en place des graphiques relatifs aux valeurs affichées.</p>
                
            <h3 class="h3-acc"> Problèmes rencontrés et solutions proposées : </h3>
                <p class="parag"> Ayant déjà durant mon temps libre la réalisée des sites web via l’utilisation de PHP, je n’ai tout d’abord pas rencontré de problèmes majeurs. C'est en revanche lorsque j'ai commencé à réaliser des pages web dynamiques que les choses se sont compliquées. </p>
                <p class="parag"> En effet, par exemple, pour l’affichage de données sur la page de consultation, il a été complexe de trier les différentes données par bâtiment, salle puis type, le tout en fonction de la base de données. Voici le fonctionnement final dans les grandes lignes :  </p>
                <ol class="parag"   > 
                    <li> La page de consultation fait appel à la fonction display_all_buildings() </li>
                    <li> Cette fonction récupère la liste des bâtiments présents dans la table bâtiment via la fonction préexistante mysqli_query() </li> 
                    <li> Pour chaque bâtiment, elle créé un menu déroulant (JavaScript) et récupère chaque salle qu’il possède (requête SQL) puis les affiche également sous forme de menus déroulants. </li> 
                    <li> Récupérer chaque type de donnée collectée dans ces salles via la fonction search_type() </li>
                    <li> Finalement, afficher la dernière valeur sous forme de jauge via l’utilisation de la fonction display_data() et de JavaScript. </li>
                </ol>
                <p class="parag"> Le second obstacle auquel j’ai fait face fut l’adaptation de ces fonctions pour la mise en place du même type d’affichage sur la page gestion :   </p>
                <ol class="parag"   > 
                    <li> Il m’a tout d’abord fallu faire passer en paramètres de la fonction display_all_buildings() tous les paramètre du filtre d’affichage et le batiment du gestionnaire. </li>
                    <li> Dans la fonction, si un bâtiment est spécifié, ne pas chercher à lister tous les bâtiment existants et ne pas faire du bâtiment un menu déroulant </li> 
                    <li> Créer en fonction des filtres une requête SQL appropriée pour récupérer la liste des salles et les afficher sous forme de menus déroulants. </li> 
                    <li> Pour chaque salle, chercher les types de données puis les capteurs présents avant de vérifier leur concordance avec les résultats de la requête SQL prenant en compte les filtres. </li>
                    <li> Appeler la fonction display_data() avec de nouveaux arguments, entre autre $numberOfValues permettant de spécifier le nombre de valeurs à afficher. Si cette valeur dépasse 1, nous n’affichons logiquement pas la page de consultation et de ce fait créons des tableaux contenant l’historique des données ainsi que des graphiques grâce à la librairie Chart.js. </li>
                </ol>
                <p class="parag"> Même si ces défis techniques m'ont parfois semblé difficiles à relever, je suis fière d'y être parvenue et d'avoir acquis, dans les langages pratiqués, un éventail de compétences que je saurais réutiliser dans ma vie d'étudiante comme professionnelle.   </p>
            </section> </li>   

        <li> <h4 class="h4-acc" onclick="toggleDetails('member3')">Pierre Chaveroux</h4>
        <section id="member3-details" class="member-details">
            <h3 class="h3-acc"> Synthèse personnelle : </h3>
                <p class="parag"> La SAE23 est un projet de fin de deuxième semestre qui m’aura paru passionnant à mener. Après avoir réparti les tâches au cours des premières réunions, il a été décidé que mon implication dans le projet serait appréciable au niveau de la solution de visualisation des données publiées via le broquer MQTT en utilisant la conteneurisation docker, mais aussi au niveau du site dynamique PHP pour la création de la page de gestion de projet. <br> </p>
                <p class="parag">Tout d’abord, mon rôle dans cette SAE aura été de proposer dans son intégralité une solution fonctionnelle pour visualiser simplement les diverses données de l’IUT de Blagnac. En utilisant la machine virtuelle fournie en début de projet, il m’a été possible de développer à l’aide d’outils graphiques les logiques de récupération, traitement et visualisation des données. Pour ce faire, il aura fallu adopter deux approches : <br>
                    La première, et la plus simple, consistait à faire apparaitre dans Node-Red Dashboard les données dans des représentations graphiques (jauges par exemple) sans stocker les données. <br>
                    La deuxième, plus complexe puisque intégrant une base de donnée, consistait à récupérer les données du broker via Node-Red avant de les injecter dans une base de données InfluxDB. Ensuite, il m’a été imposé d’utiliser l’outil graphique Graphana pour créer de beaux graphiques à partir des données contenues dans la base de donnée. <br>
                    Le noyau dur de cette première mission aura été l’utilisation de Node-Red, autant pour récupérer les données avec ou sans base de donnée, que pour les trier en utilisant des fonctions JavaScript. <br>
                    Finalement, si vous voulez en savoir plus sur la mise en place de cette solution docker, il vous est possible de télécharger le tutoriel d’installation via le bouton ci-joint : <br> </p>
                    <a class="download-button a-download-button" href="./fichiers/SAE23-Solution-Docker.pdf" download>
                        <span>Télécharger le tutoriel</span>
                    </a>
                <p class="parag">Ensuite, ma deuxième mission au sein de ce projet aura été faite en fin de projet, au cours de la dernière semaine en autonomie. En effet, étant presque terminé à ce stade, le site ne manquait pour répondre aux attentes du cahier des charges plus que des pages d’accueil et de gestion de projet. Il a donc été de mon ressort de proposer une page  ayant pour but de mettre en valeur le travail effectué par chaque membre du groupe, expliquer les différentes stratégies de communications et outils collaboratifs mis en place pour mener à bien ce projet. <br> </p>
                <p class="parag">En conclusion, ce projet m’aura permis de monter en compétences sur la gestion et l’administration des dockers, et de me familiariser avec des outils de visualisation de données comme Grafana. Je suis heureux d’avoir pu travailler sur cette partie du projet, car la récupération de données de capteurs via des chaines d’automatisation comme Node-Red fera partie intégrante de mes missions lors de mon contrat d’apprentissage chez Alsatis Réseaux pour les deux prochaines années. <br> </p>

            <h3 class="h3-acc"> Problèmes rencontrés et solutions proposées : </h3>
                <p class="parag"> Tout au long de mon évolution dans ce projet, il ne m’est pas apparu de vrais problèmes notoires à citer. Cependant, certains éléments ont pu temporairement mettre le frein sur l’avancement de mes missions sur ce projet. <br> </p>
                <p class="parag">Tout d’abord, le fait de commencer ce projet en même temps que 2 autres (SAE21 et SAE22) m'aura obligé à diviser mon temps de travail sur ces derniers. Bien que ce soit un bon exercice pour se former entre autre à la gestion des projets dans un cadre professionnel, il m’arrive de me demander si mon travail et plus généralement le travail du groupe en général n’aurait pas été de meilleure qualité si la SAE23 aurait été condensée en une semaine, semaine lui étant entièrement dédiée. Une bonne communication dans le groupe et une bonne gestion de projet aura cependant permis de fractionner le projet efficacement, pour arriver au terme de ce dernier dans les temps. <br> </p>
                <p class="parag">Ensuite, le broker MQTT de l’IUT ne publiant que sur les horaires d’ouverture de l’IUT (7h - 19h) a parfois été assez contraignant, surtout au cours des sessions de travail en autonomie chez soi le soir. C’est entre autre pour cette raison qu’il aura été essentiel de mettre en place un broker MQTT local sur la machine virtuelle Lubuntu et de créer un petit script de publication de donnée pour simuler celui de l’IUT et ainsi permettre de faire des tests sur le bon fonctionnement de la solution docker. <br> </p>
                <p class="parag">En conclusion, mes missions ne m’auront posé que peu de problèmes et des solutions ont pu être misent en place pour répondre à ceux existants. <br> </p>
        </section> </li>

        <li> <h4 class="h4-acc" onclick="toggleDetails('member4')">Sylvio Gasparotto</h4>
        <section id="member4-details" class="member-details">
            <h3 class="h3-acc"> Synthèse personnelle : </h3>
                <p class="parag"> Pour ma part, la SAE23 a été aussi constructrice au niveau travail en groupe qu’au niveau apprentissage personnel. En effet, j’ai dû m’adapter à mes camarades alors que, d’habitude, j’aime bien aller à mon rythme. Cela a, donc, bousculé mes habitudes et ma manière de faire. J’ai aussi dû élever mon niveau pour combler les attentes de mes camarades qui veulent tout le temps aller au bout des choses en cherchant la perfection et parfois même plus loin. Sur cette SAE, ils m’ont montré une autre façon de travailler. <br> </p>
                <p class="parag"> Suite à une réunion, il a été décidé que je m’occuperai du Gantt de début de projet, cette tâche que j’ai menée à bien avec soin n’a pas été la plus complexe, il suffisait de suivre la consigne et d’en déduire les différentes tâches à réaliser. Ensuite, d’ajouter les dates clés comme les rendus des différentes livrables. <br> </p>
                <p class="parag"> Pour ma deuxième mission, j'ai calculé les métriques comme la moyenne, le minimum ou encore le maximum. Pour ce faire, il m’a fallu rassembler mes connaissances en PHP, Bash et SQL. Dans un premier lieu, j’ai utilisé des requêtes SQL afin de récupérer les métriques des capteurs dans chaque salle, puis j’ai affiché à l’aide du Bash et du PHP les valeurs dans un tableau. Ensuite, j’ai réutilisé les moyennes de chaque salle dans le but de calculer une moyenne par type de donnée, un minimum et un maximum. On peut donc savoir, par exemple, dans quelle salle il a fait le plus humide. <br> </p>
                <p class="parag"> Enfin, je me suis occupé du CSS du site. C’est la partie qui fut la plus complexe de mon point de vue, car je n’ai pas une âme très artistique. J’ai donc eu un peu de mal à avoir l’inspiration. Après une courte concertation avec mon groupe, nous avons choisi que le thème du site serait monochrome. <br> </p>
                <p class="parag"> Pour conclure, je dirai que cette SAE a été bénéfique, j’ai fait certaines erreurs que je ne ferai plus, mais j’ai aussi beaucoup appris autant d’un point de vue technique que personnel. Je peux dire que le travail de groupe a changé ma façon de travailler. Je suis content d’avoir eu à faire ces parties, car j’ai pu développer des compétences qui me tiennent à cœur. <br> </p>
        
            <h3 class="h3-acc"> Problèmes rencontrés et solutions proposées : </h3>
                <p class="parag"> Sur la première partie du projet, la réalisation du Gantt, je n’ai pas rencontré de problèmes particuliers, si ce n’est la gestion des ressources qui se sont retrouvées surmenées par moment. J’ai vite résolu le problème en modifiant la répartition et l’implication des ressources. <br> </p>
                <p class="parag"> Pour le calcul des métriques, il a fallu faire des requêtes SQL. Le premier problème fut de prendre seulement les dix dernières valeurs. En effet, les mettre dans l’ordre des dernières valeurs aux premières, ne marchait pas directement. Afin de régler le problème, j’ai dû commencer par faire une sous-requête dans laquelle je sélectionne les valeurs triées, ensuite, je peux faire ma requête demandant la moyenne. <br> </p>
                <p class="parag"> Il faut faire attention, car le résultat de la requête est un type de variable à part. Il fallait, donc, transformé cette valeur en un nombre réel afin de pouvoir le manipuler.  Pour ce faire, on utilise une fonction déjà existante qui se nomme mysqli_fetch_assoc(). Une fois cela fait, on peut manipuler le nombre comme on le souhaite, par exemple en l’arrondissant deux chiffres après la virgule avec la fonction number_format(). <br> </p>
        </section> </li>

    </ul>

    </section>

    
    <section>
        <h2 class="t_center h2-acc"> Degré de satisfaction du cahier des charges : </h2>
            <p class="parag"> La SAE23 a été un projet mené à bien et pour lequel tous les objectifs du cahier des charges ont été respectés. Le déploiement du projet s'est fait sur une machine virtuelle avec le système d'exploitation Lubuntu et la gestion de version a été réalisée à l'aide de Git et GitHub. </p>
            <p class="parag"> La première solution de visualisation des données repose sur la solution de conteneurisation docker et en particulier sur les outils Node-Red, InfluxDB et Grafana. Node-Red permet de collecter et de traiter les données provenant du bus MQTT, tandis que Grafana offre un tableau de bord complet pour visualiser ces données de manière claire et intuitive. InfluxDB a été utilisé comme base de données pour stocker et interroger les données de manière efficace. </p>
            <p class="parag"> La seconde solution de visualisation des données aura pris la forme d’un site web dynamique et aura été développé en utilisant le langage PHP.
                            Via un navigateur web, les utilisateurs peuvent accéder à une interface utilisateur conviviale, offrant différentes fonctionnalités telles qu'une page d'accueil décrivant l'objectif du site et affichant les bâtiments gérés, une page d'administration réservée à l'administrateur pour la gestion des bâtiments et des capteurs, une page de gestion réservée aux gestionnaires pour consulter les mesures des capteurs de leur bâtiment, et une page de consultation accessible à tous pour afficher la dernière mesure des salles. Un script PHP a été développé pour récupérer les données à partir du broker MQTT de l’IUT de Blagnac. Ce script assure la collecte régulière des données et leur stockage dans la base de données MySQL.
                            Le respect des contraintes conceptuelles a été pris en compte dans la conception du système. Chaque bâtiment est identifié de manière unique et est associé à un gestionnaire ayant un compte avec un login et un mot de passe. Chaque capteur dispose également d'un identifiant unique, d'un nom et d'un type, et est implémenté dans un bâtiment spécifique. 
</p>
       
    </section>

    <!-- Typewriter effect for the title --> 
    <script>
        var text = "SAE23 - Gestion de projet";
        var index = 0;
        function type() {
            if (index < text.length) {
                document.getElementById("typed-text").innerHTML += text.charAt(index);
                index++;
                setTimeout(type, 100);
            }
        }
        type();
    </script>

    <!-- "Personalized synthesis menu." -->
    <script>
        function toggleDetails(memberId) {
            var details = document.getElementById(memberId + '-details');
            details.style.display = details.style.display === 'block' ? 'none' : 'block';
        }
    </script>

    <div class="blockgest">
        <figure class="right"> 
           <img id="vhtml" src="./images/vhtml.png" alt="PHP" class="img_gprojet">
        </figure>
        <figure class="left"> 
            <img id="vcss" src="./images/vcss.gif" alt="JavaScript" class="img_gprojet">
        </figure>
    </div>

</body>
</html>