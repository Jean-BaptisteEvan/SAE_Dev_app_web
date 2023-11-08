<?php
echo '<a href="?action=create">Créer compte</a>'."<br>";
echo '<a href="?action=connect">Se connecter</a>'."<br>";
if(isset($_GET['action']) and $_GET['action']==="create"){
    connec::creationCompte();
}
if(isset($_GET['action']) and $_GET['action']==="connect"){
    connec::connexion();
}

?>