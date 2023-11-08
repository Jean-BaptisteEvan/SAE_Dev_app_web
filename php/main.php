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

for ($i = 4; $i < 9; $i++) {
    echo $touitesRendered[$i];
}

//TouiteSearch::getAllTouites();
//TouiteSearch::getTouitesPostedBy(3);
//TouiteSearch::getTouitesTagedBy("Chat");

/*
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['action'] == '') {

    }
} elseif($_SERVER['REQUEST_METHOD'] == 'POST') {

}
*/