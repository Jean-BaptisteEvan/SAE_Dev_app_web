<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/style.css" />

    <meta charset="UTF-8">
    <title>Touiteur</title>
    <link rel="icon" type="image/x-icon" href="Image/Logotouiteur-removebg-preview.png" />


</head>
<body>
<header>

    <nav class="menuHaut">
        <ul>
            <div class="hdr"><a href="DispacheurMurUti.php"><h1>ForYou</h1></a> </div>
            <div class="hdr"><a href="Dispacheur.php"> <h1>All</h1></a></div>
        </ul>
</header>

    <nav class="menuGauche">
        <ul>



            <li><a href="Dispacheur.php"><img src="Image/Logotouiteur-removebg-preview.png" class="imgheader"></a></li>
            <li><div class="container"><a href="Dispacheur.php"><img src="Image/house-solid-removebg-preview.png" class="imgheaderhome"></a> <h3>Home</h3></div></li>
            <li><div class="container"><a href="Recherche.asp"><img src="Image/glass-removebg-preview.png" class="imgheaderhome"></a> <h3>Search</h3></div></li>
            <li><div class="container"><a href="DispacheurProf.php"><img src="Image/user-removebg-preview.png " class="imgheaderhome"></a><h3>Profile</h3></div></li>
            <li><div class="contain"><a href="contact.asp" class="imgPost"><h4>Post</h4></a></div> </li>
        </ul>
    </nav>



<?php
use iutnc\touiteur\MurUtilisateur;

require_once "../vendor/autoload.php";

    MurUtilisateur::renderMur(1);

?>

<div class="PartieDroite" > <img src="Image/Logotouiteur-removebg-preview.png"></div>
</body>
</html>