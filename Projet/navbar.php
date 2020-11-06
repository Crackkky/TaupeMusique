<!-- BARRE DE NAVIGATION -->
<?php
    //session_start();
    
    //Debug
    //print_r($_SESSION);
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Accueil</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
				<?php 
                    if(isset($_SESSION["user"]) && isset($_SESSION['admin'])){
                        if($_SESSION["admin"] === true){
    						echo '<a href="administration.php">Profil</a>';
    					}
					else{
						echo '<a href="profil.php">Profil</a>';
					   }
                    }
				?>
                    
                </li>
                <li id="conn">
                    <?php
                    if(isset($_SESSION["user"])){
                        echo "<a href='logout.php'>Log Out</a>";
                    }
                    else{
                        echo "<a href='#Login' data-toggle='modal'>Log In</a>";
                    }

                    ?>
                </li>
            </ul >
			<ul class="nav navbar-nav" style="margin-left:75%">
			<li><a href="panier.php"><img src="./images/icone_panier.png" style="height:30px;"/></a></li>
			</ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<?php include 'bstrap.php';?>