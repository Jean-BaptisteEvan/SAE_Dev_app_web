<?php

namespace iutnc\touiteur;
require_once '../vendor/autoload.php';

class TouitePublier
{
    static function publier($bdd)
    {
        if (!isset($_POST['msg']) || $_SERVER['REQUEST_METHOD'] === 'GET') {
            //formulaire de post de touite
            self::ecrireFormPubl();
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
            $message = str_replace(["'", '"'], ' ', $tabMes[0]);
            //recuperation de l id du touite
            $repId = $bdd->query("SELECT idTouite FROM touite WHERE idTouite >= ALL(SELECT idTouite FROM touite)");
            $idT = $repId->fetch()['idTouite'];
            //récupération de l'id user
            $idUs = 2;//$_SESSION['user']['id'];
            $bdd->exec("INSERT INTO touite (texte,datePublication,idUser) VALUES ('$texte','$dateAct',$idUs)");
            //test si le message contenait des tags
            if (count($tabMes) !== 0) {
                //parcours des tags stocké
                for ($i = 1; $i < count($tabMes); $i++) {
                    $repTag = $bdd->query("SELECT idTag FROM tag WHERE tagLibelle like '$tabMes[$i]'");
                    $idTag = $repTag->fetch()['idTag'];
                    //si le tag n existe pas
                    if (is_null($idTag)) {
                        $bdd->exec("INSERT INTO tag (tagLibelle,tagDesc) VALUES ('$tabMes[$i]',' ')");
                        $repIdTag = $bdd->query("SELECT idTag FROM tag WHERE idTag >= ALL(SELECT idTag FROM tag)");
                        $idTag = $repIdTag->fetch()['idTag'];
                    }
                    $bdd->exec("INSERT INTO tagjoint (idTouite,idTag) VALUES ($idT,$idTag)");
                }
            }
        }
    }

    function ecrireFormPubl(){
        echo '<form action="" method="post">
      Entrer votre message : <br>
      <textarea name="msg" rows="12" cols="35"></textarea><br>
      <input type="submit" name="submitInfo" value="Submit">
    </form></br>';
    }
}