<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include("imports.html"); ?>

    <title>404 Not found</title>

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

        $().ready(function() {
            $("input[name=selection]").each(function(i, selected){
                selected.addEventListener('click', requestAlbumList, false);
            });
            document.getElementById("favOnly").addEventListener('click', requestAlbumList, false);

            $("#addPan").click(function(e){
                this.preventDefault();
            });

            $('#toolt').tooltip();

            setTimeout(requestAlbumList, 50);
        });

        var ingrList;
        function requestAlbumList() {
            ingrList = new Array();
            $("input[name=selection]:checked").each(function(i, selected){
                ingrList.push(selected.value);
            });
            $.ajax({
                method: "POST",
                url: "getAlbumList.php",
                data: {ingr: ingrList, favOnly: document.getElementById("favOnly").checked, mot: $("#search").val()}
            })
                .done(function(msg) {
                    $("#albumList").html(msg);
                    addEvents();
                });
        };

        function addFav(e){
            $.ajax({
                method: "POST",
                url: "enregFav.php",
                data: {id_produit: e},
                success: function(data){
                },
            });

        };

        function addPanier(e){
            $.ajax({
                type: 'POST',
                url: 'fonctions/fonctionsPanier.php',
                data: {item : e},
                success: function(data){
                    alert(data);
                },
            });
        };

    </script>
</head>
<body>
	<?php include("./navbar.php");?>
	<img src="images/taupe.jpg" alt="texte alternatif" />

	<div class="container">

    <hr>

    <!-- Footer -->
    <?php include("./footer.php");?>

</div>
</body>
</html>