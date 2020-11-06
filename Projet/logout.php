<html>
<head>
    <title>LOGOUT</title>
    <meta charset="utf-8" />
</head>

<body>
<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['panier']);
session_destroy();

header('Location: index.php');
?>
</body>
</html>