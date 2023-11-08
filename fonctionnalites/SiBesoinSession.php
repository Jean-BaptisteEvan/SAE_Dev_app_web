<?php
require_once "./fonctionnalites_6_et_7.php";
require_once "./fonctionnalite_10.php";
use iutnc\fonctionnalites\connexion;
use iutnc\fonctionnalites\supression;

echo '<a href="?action=create">Créer compte</a>'."<br>";
echo '<a href="?action=connect">Se connecter</a>'."<br>";
echo '<a href="?action=deconnect">Se déconnecter</a>'."<br>";
echo '<a href="?action=delete">Suprimer touite</a>'."<br>";

if(isset($_GET['action']) and $_GET['action']==="create"){
    connexion::creationCompte();
}
if(isset($_GET['action']) and $_GET['action']==="connect"){
    connexion::connexion();
}
if(isset($_GET['action']) and $_GET['action']==="deconnect"){
    connexion::deconnexion();
}
if(isset($_GET['action']) and $_GET['action']==="delete"){
    supression::delete();
}

?>