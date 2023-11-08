<?php

use iutnc\touiteur\TouiteRenderer;
use iutnc\touiteur\TouiteSearch;

require_once "../vendor/autoload.php";

$listeTouites = TouiteSearch::getAllTouites();

foreach ($listeTouites as $k => $v) {
    echo TouiteRenderer::renderLong($v);
}

//TouiteSearch::getAllTouites();
//TouiteSearch::getTouitesPostedBy(3);
//TouiteSearch::getTouitesTagedBy("Chat");