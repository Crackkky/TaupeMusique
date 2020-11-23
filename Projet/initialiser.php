<html>
<head>
    <title>Initialisation de la base de données</title>
    <meta charset="utf-8" />
</head>

<body>
<?php


include("Fonctions.inc.php");
include("Donnees.inc.php");

// Connexion au serveur MySQL
$mysqli = first_connect();

// Suppression / Création / Sélection de la base de données : $base
$base = getBase();
queryDB($mysqli,'DROP DATABASE IF EXISTS '.$base);
queryDB($mysqli,'CREATE DATABASE '.$base);
select_database($mysqli);

queryDB($mysqli,"CREATE TABLE IF NOT EXISTS USERS (
                        LOGIN varchar(50)  PRIMARY KEY,
                        EMAIL varchar(100),
                        PASS varchar(100),
                        NOM varchar(50),
                        PRENOM varchar(50),
                        DATE varchar(10),
                        SEXE varchar(10),
                        ADRESSE varchar(300),
                        CODEP varchar(5),
                        VILLE varchar(50),
                        TELEPHONE varchar(10),
                        ADMIN tinyint(1)                     
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

queryDB($mysqli,"CREATE TABLE IF NOT EXISTS  RUBRIQUES (
                        ID_RUB int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        LIBELLE_RUB varchar(80) NOT NULL
                        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;");

queryDB($mysqli,"CREATE TABLE IF NOT EXISTS PRODUITS (
                        ID_PROD int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        LIBELLE VARCHAR(50) NOT NULL,
                        PRIX float,
                        CHANSONS VARCHAR(500),
                        DESCRIPTIF VARCHAR(2000),
                        GENRE int(11),
                        FOREIGN KEY (GENRE) references RUBRIQUES(ID_RUB)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
//Ouais ba les photos en SQL c'est mort ptdr

queryDB($mysqli,"CREATE TABLE IF NOT EXISTS FAVS (
                        LOGIN varchar(200),
                        ID_PROD int(10),
                        FOREIGN KEY (LOGIN) REFERENCES USERS(LOGIN),
                        PRIMARY KEY(LOGIN,ID_PROD)
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

queryDB($mysqli,"CREATE TABLE IF NOT EXISTS `COMMANDE` (
                        ID_COM bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        ID_PROD int(11) NOT NULL,
                        ETAT int(1) NOT NULL,
                        ID_CLIENT varchar (250) NOT NULL,
                        DATE varchar(40) NOT NULL,
                        CIVILITE varchar(4) NOT NULL,
                        NOM varchar(40) NOT NULL,
                        PRENOM varchar(40) NOT NULL,
                        ADRESSE varchar(160) NOT NULL,
                        CP int(11) NOT NULL,
                        VILLE varchar(80) NOT NULL,
                        TELEPHONE varchar(10) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

echo 'Initialisation réussie <br />';

// Insertion
queryDB($mysqli,"INSERT INTO USERS VALUES ('admin',
                                                 'admin@admin.com',
                                                 '".password_hash('Wonderful', PASSWORD_DEFAULT)."',
                                                 'ADMIN',
                                                 'admin',
                                                 '01/01/1999',
                                                 'Homme',
                                                 NULL,
                                                 '57000',
                                                 NULL,
                                                 918633099,
                                                 true);");

queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (1, 'Alternative');");

queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (2, 'Jazz');");

queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (3, 'Hip-Hop');");

queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (4, 'Pop');");

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('1',
                                                     'Joss Stone - Water for Your Soul',
                                                     19.99,
                                                     '1 Love Me |2 This Aint Love |3 Stuck on You |4 Star | 5 Let Me Breathe | 6 Cut the Line | 7 Wake Up | 8 Way Oh | 9 Underworld | 10 Molly Town | 11 Sensimilla | 12 Harrys Symphony | 13 Clean Water | 14 The Answer ',
                                                     'Joss Stone n avait pas sorti de chansons originales depuis son LP1, publié en 2011. Il lui a fallu 4 ans de voyages, de Projets et d enseignements pour arriver à collecter les 14 nouveaux morceaux de Water For Your Soul. De ses sessions d improvisation à Los Angeles avec Damian Marley à l Angleterre, en passant par Hawaï et les routes d Europe où elle a voyagées dans un vieux camping-car en compagnie de son ancien petit ami, la chanteuse a nourri son âme de nouvelles expériences. ',
                                                     1);");

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('2',
                                                     'Israel Kamakawiwo\'ole - Facing Future',
                                                     14.99,
                                                     '1 Hawai\'i Introduction | 2 Ka Huila Wai | 3 \'Ama\'ama\' 
                                                     | 4 Panini Pua Kea | 5  Take Me Home Country Road | 6 Kuhio Bay | 7 Ku Pua | 8 White Sandy Beach of Hawai\'i | 9 Henehene Kou \'Aka | 10 La \'Elima | 11 Pili Me Ka\'u Manu | 12 Maui Hawaiian Sup\'pa Man | 13 Kaulana Kawaihae | 14 Over the Rainbow / What a Wonderful World | 15 Hawai\'i \'78' ,
                                                     'Etant l\'administrateur de ce site, j\'ai ajouté cet album avec beaucoup d\'entousiasme, car c\'est vraiment mon album de coeur. Je l\'écoute depuis des années et il me suit vraiment partout. Parfois j\'ai vraiment l\'impression qu\'il arrive à m\'aider à garder mes secrets. Ce doit être une forme de méditation peut être ? Ou peut être pas... Il faut vraiment écouter chaque mot de chaque chanson pour apprécier au plus juste ce bijoux musical.',
                                                     1);");

mysqli_close($mysqli);
?>

Insertion réussie
</body>
</html>