



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
                <div class="hdr"><a href="Dispacheur.php"><h1>All</h1></a> </div>
            </ul>
</header>


    <nav class="menuGauche">
        <ul>



            <li><a href="Dispacheur.php"><img src="Image/Logotouiteur-removebg-preview.png" class="imgheader"></a></li>
            <li><div class="container"><a href="Dispacheur.php"><img src="Image/house-solid-removebg-preview.png" class="imgheaderhome"></a> <h3>Home</h3></div></li>
            <li><div class="container"><a href="SuivreTag.php"><img src="Image/glass-removebg-preview.png" class="imgheaderhome"></a> <h3>Follow</h3></div></li>
            <li><div class="container"><a href="DispacheurProf.php"><img src="Image/user-removebg-preview.png " class="imgheaderhome"></a><h3>Profile</h3></div></li>
            <li><div class="contain"><a href="Post.php" class="imgPost"><h4>Post</h4></a></div> </li>
            <li><div class="container"><a href="Connection.php" ><img src="Image/door-green.png"></a><h3>SignIn</h3></div> </li>
            <li><div class="container"><a href="MainDeconnection.php" ><img src="Image/door-Red.png"></a><h3>Disconnect</h3></div> </li>
        </ul>
    </nav>




<?php

use iutnc\touiteur\TouiteRenderer;
use iutnc\touiteur\TouiteSearch;

require_once "../vendor/autoload.php";

/**
 * Display a specific amount of touites from an array
 * @param array $l the array of touites in HTML format
 * @param int $debut the first touite displayed in the array
 * @param int $fin the last touite displayed in the array
 * @return void
 */
function afficherTouites(array $l, int $debut, int $fin) {
    // In case we exceed the length of the array
    if ($fin > count($l)) {
        $fin = count($l);
    }
    for ($i = $debut; $i < $fin; $i++) {
        echo $l[$i];
    }
}

// Display all touites, all touites taged by something or made by someone
// used when the user click on a username or a tag
if (isset($_GET['touitesPostedBy'])) {
    $listeTouites = TouiteSearch::getTouitesPostedBy($_GET['touitesPostedBy']);
} elseif (isset($_GET['touitesTagedBy'])) {
    $listeTouites = TouiteSearch::getTouitesTagedBy($_GET['touitesTagedBy']);
} else {
    // Default
    $listeTouites = TouiteSearch::getAllTouites();
}

$touitesRendered = array();
foreach ($listeTouites as $k => $v) {
    array_push($touitesRendered, TouiteRenderer::renderLong($v));
    TouiteRenderer::renderLong($v);
}

// If we want to display a specific amount of touites if there are too many
// example : http://localhost/SAE_Dev_app_web/php/Dispacheur.php?debut=4&&fin=9
if (isset($_GET['debut']) or isset($_GET['fin'])) {
    afficherTouites($touitesRendered, $_GET['debut'], $_GET['fin']);
} else {
    // print every touite, code not clean, should find max and min methods
    afficherTouites($touitesRendered, 0, 1000);
}

?>

<div class="PartieDroite" > <img src="Image/Logotouiteur-removebg-preview.png"></div>

</body>
</html>








