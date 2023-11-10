<?php

use iutnc\touiteur\bdd\ConnectionFactory;

require_once "../vendor/autoload.php";

ConnectionFactory::makeConnection();
$bdd = ConnectionFactory::$bdd;

