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
    $texte = $_POST['msg'];
    //traitement des tags
	$tabMes = explode('#',$_POST['msg']);
    //suppresion des # dans les tags
    for ($i=0;$i<count($tabMes);$i++){
        $tabMes[$i] = trim($tabMes[$i]," ");
    }
    //suppresion des guillement dans un touite pour éviter les problèmes dans la base de données
    $message = str_replace(["'",'"'], ' ', $tabMes[0]);
    //recuperation de l id du touite
	$repId = $bdd->query("SELECT idTouite FROM touite WHERE idTouite >= ALL(SELECT idTouite FROM touite)");
	$idT = $repId->fetch()['idTouite'];
	$idUs = 3; //bidon ! à remplacer par la valeur de l'id actuel de l'utilisateur
    $bdd->exec("INSERT INTO touite (texte,datePublication,idUser) VALUES ('$texte','$dateAct',$idUs)");
    if (count($tabMes) !== 0){
        var_dump($tabMes);
        for ($i=1;$i<count($tabMes);$i++){
            var_dump("SELECT idTag FROM Tag WHERE tagLibelle like '$tabMes[$i]'");
            echo '<br>';
            $repTag = $bdd->query("SELECT idTag FROM Tag WHERE tagLibelle like '$tabMes[$i]'");
            $idTag = $repTag->fetch()['idTag'];
            echo "<br>";
            var_dump($idTag);
            echo "<br>";
            if(is_null($idTag)){
                $bdd->exec("INSERT INTO Tag (tagLibelle,tagDesc) VALUES ('$tabMes[$i]',' ')");
                $repIdTag = $bdd->query("SELECT idTag FROM Tag WHERE idTag >= ALL(SELECT idTag FROM Tag)");
                $idTag = $repIdTag->fetch()['idTag'];
            }
            var_dump($idTag);
            $bdd->exec("INSERT INTO TAGJOINT (idTouite,idTag) VALUES ($idT,$idTag)");
        }
    }
}

?>