<?php
require_once "./fonctionnalites_6_et_7.php";
require_once "./fonctionnalite_10.php";
require_once "./fonctionnalite_13_et_14.php";
use iutnc\fonctionnalites\connexion;
use iutnc\fonctionnalites\supression;
use iutnc\fonctionnalites\follow;

echo '<a href="?action=create">Créer compte</a>'."<br>";
echo '<a href="?action=connect">Se connecter</a>'."<br>";
echo '<a href="?action=deconnect">Se déconnecter</a>'."<br>";
echo '<a href="?action=delete">Suprimer touite</a>'."<br>";
echo '<a href="?action=followuser">Suivre un utilisateur</a>'."<br>";
echo '<a href="?action=followtag">Suivre un tag</a>'."<br>";

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
if(isset($_GET['action']) and $_GET['action']==="followuser"){
    follow::followUser();
}
if(isset($_GET['action']) and $_GET['action']==="followtag"){
    follow::followTag();
}

?>