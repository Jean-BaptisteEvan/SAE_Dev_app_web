<?php

namespace iutnc\touiteur;

class postageTouite
{
 function postageTouite($bdd){
     if (!isset($_POST['msg']) || $_SERVER['REQUEST_METHOD'] === 'GET') {
         //formulaire de post de touite
         echo '<form action="" method="post" enctype="multipart/form-data">>
      Entrer votre message : <br>
      <textarea name="msg" rows="6" cols="35"></textarea><br>
        <input type="file" name="inputfile">
        <input type="text" name="description">
        <br><button type="submit" name="valider" value="">transférer</button>
    </form>';
     } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         //recupération
         $dateAct = date("Y-m-d H:i:s");
         $texte = trim(stripslashes(htmlspecialchars($_POST['msg'])));
         //traitement des tags
         $tabMes = explode('#', $_POST['msg']);
         //suppresion des # dans les tags
         for ($i = 0; $i < count($tabMes); $i++) {
             $tabMes[$i] = trim($tabMes[$i], " ");
         }
         //suppresion des guillement dans un touite pour éviter les problèmes dans la base de données
         //recuperation de l id du touite
         $repId = $bdd->query("SELECT idTouite FROM touite WHERE idTouite >= ALL(SELECT idTouite FROM touite)");
         $idT = $repId->fetch()['idTouite'];
         //récupération de l'id user
         $idUs = $_SESSION['user']['id'];
         $bdd->exec("INSERT INTO touite (texte,datePublication,idUser) VALUES ('$texte','$dateAct',$idUs)");
         //test si le message contenait des tags
         if (count($tabMes) !== 0) {
             //parcours des tags stocké
             for ($i = 1; $i < count($tabMes); $i++) {
                 $repTag = $bdd->query("SELECT idTag FROM Tag WHERE tagLibelle like '$tabMes[$i]'");
                 //si le tag n existe pas ou il existe
                 if ($repTag->rowCount() === 0) {
                     $bdd->exec("INSERT INTO Tag (tagLibelle,tagDesc) VALUES ('$tabMes[$i]','sera ajouter au moment d une utilisation superieur a 100')");
                     $repIdTag = $bdd->query("SELECT idTag FROM Tag WHERE idTag >= ALL(SELECT idTag FROM Tag)");
                     $idTag = $repIdTag->fetch()['idTag'];
                 }else{
                     $idTag = $repTag->fetch()['idTag'];
                 }
                 $bdd->exec("INSERT INTO TAGJOINT (idTouite,idTag) VALUES ($idT,$idTag)");
             }
         }

     }

     if(isset($_POST['description']) && $_POST['description'] !== "") {
         $repertoire = "../php/Image/Touites/";
         $nomFichier = $_FILES['inputfile']['name'];
         $tmp = $_FILES['inputfile']['tmp_name'];
         if (($_FILES['inputfile']['error'] === UPLOAD_ERR_OK) && $_FILES['inputfile']['type'] !== "" && ($_FILES['inputfile']['type'] === 'image/jpeg' || 'image/png' || 'image/gif')) {
             $dest = $repertoire . $nomFichier;
             if (move_uploaded_file($tmp, $dest)) {
                 $bdd->exec("INSERT INTO Image (imgDesc, chemin) VALUES (" . "'$_POST[description]'" . ", '$dest')");
                 $repImg = $bdd->query("SELECT idImage FROM image WHERE idImage >= ALL(SELECT idImage FROM image)");
                 $idImg = $repImg->fetch()['idImage'];
                 $bdd->exec("INSERT INTO ImageJointe VALUES (".$idImg.",".$idT.")");
                 echo "Image téléchargée<br>";
             } else {
                 echo "Echec du téléchargement<br>";
             }
         } else {
             print "Echec du téléchargement ou type non autorisé<br>";
         }
     }
 }
}