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

queryDB($mysqli,"CREATE TABLE IF NOT EXISTS `commande` (
                        ID_COM bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        ID_PROD int(11) NOT NULL,
                        ETAT int(1) NOT NULL,
                        ID_CLIENT int(11) NOT NULL,
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

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('1',
                                                     'Joss Stone (Water for Your Soul)',
                                                     19.99,
                                                     '1 Love Me |2 This Aint Love |3 Stuck on You |4 Star | 5 Let Me Breathe | 6 Cut the Line | 7 Wake Up | 8 Way Oh | 9 Underworld | 10 Molly Town | 11 Sensimilla | 12 Harrys Symphony | 13 Clean Water | 14 The Answer ',
                                                     'Joss Stone n avait pas sorti de chansons originales depuis son LP1, publié en 2011. Il lui a fallu 4 ans de voyages, de Projets et d enseignements pour arriver à collecter les 14 nouveaux morceaux de Water For Your Soul. De ses sessions d improvisation à Los Angeles avec Damian Marley à l Angleterre, en passant par Hawaï et les routes d Europe où elle a voyagées dans un vieux camping-car en compagnie de son ancien petit ami, la chanteuse a nourri son âme de nouvelles expériences. ',
                                                     1);");

queryDB($mysqli,"INSERT INTO PRODUITS VALUES ('2',
                                                     'Album Test',
                                                     99.99,
                                                     '1 Hello there | 2 General Kenobi | 3 Youre a bold one',
                                                     'TIN TINTINTIN TINTINTIN TINTIN TINTINTINTINTIN TINTINTINTIN TIN TINTINTINTIN TIN TINTINTINTIN TIN TINTINTINTIN ',
                                                     4);");

mysqli_close($mysqli);
?>

Insertion réussie
</body>
</html>