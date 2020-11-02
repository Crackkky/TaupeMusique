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
                        TELEPHONE varchar(10)                     
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
                        ID_CLIENT varchar (255) NOT NULL,
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
                                                 '".password_hash('pass', PASSWORD_DEFAULT)."',
                                                 'ADMIN',
                                                 'admin',
                                                 '01/01/1999',
                                                 'Homme',
                                                 NULL,
                                                 '57000',
                                                 NULL,
                                                 918633099);");

queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (1, 'Alternative');");
queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (2, 'Jazz');");
queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (3, 'Hip-Hop');");
queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (4, 'Pop');");
queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (5, 'Metalcore');");
queryDB($mysqli, "INSERT INTO RUBRIQUES VALUES (6, 'KPop');");

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('1',
                                                     'Momoland (Chiri Chiri)',
                                                     19.99,
                                                     '1 Chiri Chiri | 2 Pinky Love | 3 BBoom BBoom -Japanese Version- | 4 BAAM -Japanese Version-',
                                                     'Chiri Chiri is the first Japanese full-length album by MOMOLAND. It was released on November 9, 2019 with \"Pinky Love\" serving as the albums title track.',
                                                     6);");

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('2',
                                                     'Joss Stone (Water for Your Soul)',
                                                     19.99,
                                                     '1 Love Me | 2 This Aint Love | 3 Stuck on You | 4 Star | 5 Let Me Breathe | 6 Cut the Line | 7 Wake Up | 8 Way Oh | 9 Underworld | 10 Molly Town | 11 Sensimilla | 12 Harrys Symphony | 13 Clean Water | 14 The Answer ',
                                                     'Joss Stone n avait pas sorti de chansons originales depuis son LP1, publié en 2011. Il lui a fallu 4 ans de voyages, de Projets et d enseignements pour arriver à collecter les 14 nouveaux morceaux de Water For Your Soul. De ses sessions d improvisation à Los Angeles avec Damian Marley à l Angleterre, en passant par Hawaï et les routes d Europe où elle a voyagées dans un vieux camping-car en compagnie de son ancien petit ami, la chanteuse a nourri son âme de nouvelles expériences. ',
                                                     1);");

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('3',
                                                     'Gorillaz (Plastic Beach)',
                                                     14.99,
                                                     '1 Stylo | 2 Superfast Jellyfish | 3 Melancholy Hill',
                                                     'Plastic Beach is the third studio album by British virtual band Gorillaz. It was released on 3 March 2010 by Parlophone internationally and by Virgin Records in the United States. Conceived from an unfinished project called Carousel, the album was recorded from June 2008 to November 2009, and was produced primarily by group co-creator Damon Albarn. It features guest appearances by such artists as Snoop Dogg, Gruff Rhys, De La Soul, Bobby Womack, Mos Def, Lou Reed, Mark E. Smith, Bashy, Kano and Little Dragon.',
                                                     1);");

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('4',
                                                     'Bring Me the Horizon (Sempiternal)',
                                                     9.99,
                                                     '1 Can You Feel My Heart | 2 The House Of Wolves | 3 Empire (Let Them Sing) | 4 Sleepwalking | 5 Go to Hell, for Heavens Sake | 6 Shadow Moses',
                                                     'Sempiternal est le quatrième album studio du groupe de metalcore anglais Bring Me the Horizon. Le premier single Shadow Moses est diffusé via la chaîne YouTube de Epitaph Record le 22 janvier 2013.',
                                                     5);");

mysqli_close($mysqli);
?>

Insertion réussie
</body>
</html>