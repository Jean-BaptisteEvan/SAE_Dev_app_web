<?php
require_once "./fonctionalites_6_et_7.php";
require_once "./fonctionnalite_10.php";
use iutnc\fonctionnalites\connec;
use iutnc\fonctionnalites\supression;

echo '<a href="?action=create">Créer compte</a>'."<br>";
echo '<a href="?action=connect">Se connecter</a>'."<br>";
echo '<a href="?action=delete">Suprimer touite</a>'."<br>";

if(isset($_GET['action']) and $_GET['action']==="create"){
    connec::creationCompte();
}
if(isset($_GET['action']) and $_GET['action']==="connect"){
    connec::connexion();
}
if(isset($_GET['action']) and $_GET['action']==="delete"){
    supression::delete();
}

?>