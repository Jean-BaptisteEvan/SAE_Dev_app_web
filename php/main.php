<head>
    <title>titre</title>
    <link rel="stylesheet" type="text/css" href="../css/affichageTouite.css">
</head>

<?php

use iutnc\touiteur\TouiteRenderer;
use iutnc\touiteur\TouiteSearch;

require_once "../vendor/autoload.php";

$listeTouites = TouiteSearch::getAllTouites();

$touitesRendered = array();
foreach ($listeTouites as $k => $v) {
    array_push($touitesRendered, TouiteRenderer::renderLong($v));
}

function afficherTouites(array $l, int $debut, int $fin) {
    // In case we exceed the length of the array
    if ($fin > count($l)) {
        $fin = count($l);
    }
    for ($i = $debut; $i < $fin; $i++) {
        echo $l[$i];
    }
}

echo '<form id="form-add" method="post" action="ajouterImageBD.php" enctype="multipart/form-data">
        <input type="file" name="inputfile">
        <input type="text" name="description">
        <br><button type="submit" name="valider" value="ajout-image-bd">transférer</button>
    </form>';

// http://localhost/SAE_Dev_app_web/php/main.php?debut=4&&fin=9
if (isset($_GET['debut']) or isset($_GET['fin'])) {
    afficherTouites($touitesRendered, $_GET['debut'], $_GET['fin']);
} else {
    afficherTouites($touitesRendered, 0, 100);
}