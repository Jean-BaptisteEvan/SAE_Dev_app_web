<?php
require_once '../vendor/autoload.php';

use iutnc\touiteur\bdd\ConnectionFactory;
require_once './gestionBackOffice.php';
require_once '../fonctionnalites/fonctionnalites_6_et_7.php';
use iutnc\fonctionnalites\connexion;
try {
    connexion::connexion();
} catch (Exception $e) {

}
if(isset($_SESSION['user'])){
    if($_SESSION['user']['admin'] === 1){
        ConnectionFactory::makeConnection();
        $bdd = ConnectionFactory::$bdd;
        gestionBackOffice::genererBackOffice($bdd);
    }else{
        echo 'access not granted please leave';
    }
}


