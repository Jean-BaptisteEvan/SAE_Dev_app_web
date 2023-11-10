<link rel="stylesheet" href="../css/stylePost.css" />
<?php

use iutnc\touiteur\bdd\ConnectionFactory;
use iutnc\touiteur\postageTouite;

require_once "../vendor/autoload.php";

ConnectionFactory::makeConnection();
$bdd = ConnectionFactory::$bdd;

(new iutnc\touiteur\postageTouite)->postageTouite($bdd);


