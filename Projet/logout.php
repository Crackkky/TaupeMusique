<html>
<head>
    <title>LOGOUT</title>
    <meta charset="utf-8" />
</head>

<body>
<?php
session_start();
session_destroy();
//Pour je ne sais quelle raison le cookie user n'est pas supprimé si on utilise la même méthode que pour panier et PHPSESSID (peut-être à cause du PATH ("/") ?)
setcookie('user','',-1);
setcookie('panier', null, time() - 365*24*3600*9999, "/");
setcookie('PHPSESSID', null, time() - 365*24*3600*9999, "/");
header('Location: index.php');
?>
</body>
</html>