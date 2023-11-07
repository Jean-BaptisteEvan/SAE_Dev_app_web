<?php
try{
    $bdd = new PDO('mysql:host=localhost; dbname=touiteur; charset=utf8','root', "");
}catch(Exception $e){
    die('erreur: '.$e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo '<form action="" method="post">
        Message <input type="test" name="msg"><br>
        <input type="submit">
    <form/></br>';
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$dateAct = date("Y-m-d H:i:s");
	$message = $_POST['msg'];
	$bdd->exec("INSERT INTO TOUITE (texte) VALUES ('$message')");//$bdd->exec(
	$rep = $bdd->query("SELECT idTouite FROM touite WHERE idTouite >= ALL(SELECT idTouite FROM touite)");
	$idT = $rep->fetch()['idTouite'];
	$idUs = 3; //bidon ! à remplacer par la valeur de l'id actuel de l'utilisateur
	$bdd->exec("INSERT INTO PUBLIER VALUES ('$dateAct','$idUs','$idT.')");
}

?>