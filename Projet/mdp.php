<?php
session_start();

include ("API.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include("imports.html"); ?>

    <title>Taupe Musique</title>

    <!-- Bootstrap Core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/heart.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/datepicker.min.css" />
    <link rel="stylesheet" href="./css/datepicker3.min.css" />

    <!--
    [if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]
    -->

    <script type="text/javascript">
        $(document).ready(function() {
            $("#valider").click(function(){
                $.ajax({
                    url: "fonctions/fonctionsMdp.php",
                    method: "POST",
                    data: {email : $("#email").val()},
                    success: function(data)
                    {
                        alert(data);
                        history.back();
                    }
                });
            });
        });

    </script>

</head>

<body>

<!-- Navigation -->
<?php include("./navbar.php");?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-9">

            <div class="row" id="albumList">

                <div class="col-sm-6 col-lg-6 col-md-6">
                    <h2>Mot de passe oublié</h2><br/>
                    <label>Entrez l'adresse email avec laquelle vous vous êtes inscrit pour réinitialiser votre mot de passe.</label><br/><br/>
                    <input type="text" size="55" id="email" placeholder="votre email"></input><br/><br/>
                    <button id="valider">Valider</button>
                </div>

            </div>

        </div>

    </div>

</div>
<!-- /.container -->

<div class="container">

    <hr>

    <!-- Footer -->
    <?php include("./footer.php");?>

</div>
<!-- /.container -->


<!-- jQuery -->
<script src="./js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="./js/jq.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="./js/heart.js"></script>
<script src="./js/jq.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/daterangepicker.js"></script>
<script type="text/javascript" src="./js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="./js/moment.min.js"></script>

</body>

</html>
