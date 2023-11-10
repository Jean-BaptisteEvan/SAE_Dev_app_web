<?php
require_once '../vendor/autoload.php';

use iutnc\touiteur\bdd\ConnectionFactory;
require_once './gestionBackOffice.php';
use iutnc\touiteur\Compte;


ConnectionFactory::makeConnection();
$bdd = ConnectionFactory::$bdd;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //formulaire de connexion
    echo'<form action="">
            <input type="text" name="pseudo" placeholder="login">
            <input type="password" name="mdp" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>';
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        Compte::connexion($_POST['pseudo'], $_POST['$mdp']);
    } catch (Exception $e) {

    }
}

if(isset($_SESSION['user'])){
    if($_SESSION['user']['admin'] == 1){

        gestionBackOffice::genererBackOffice($bdd);

    }else{
        echo 'access not granted please leave';
    }
}


