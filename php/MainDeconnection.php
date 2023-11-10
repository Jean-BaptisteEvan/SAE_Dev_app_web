<link rel="stylesheet" href="../css/stylePost.css" />
<?php

use iutnc\touiteur\bdd\ConnectionFactory;
use iutnc\touiteur\Compte;
use iutnc\touiteur\postageTouite;

require_once "../vendor/autoload.php";

ConnectionFactory::makeConnection();
$bdd = ConnectionFactory::$bdd;
$a =Compte::deconnexion();
 if ($a ===1){
        echo "Déconnexion réussie!<br>";
        echo '<a href="Dispacheur.php"><h2 class="active">Accéder à touiteur </h2></a>';
 }
 else{
     echo "Déconnexion échouée!<br>";
     echo '<a href="Dispacheur.php"><h2 class="active">Accéder à touiteur </h2></a>';
 }

