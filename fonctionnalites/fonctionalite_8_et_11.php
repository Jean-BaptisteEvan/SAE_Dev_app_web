<?php
//fonctionalite sur le post de touite
require_once '../vendor/autoload.php';

use iutnc\fonctionnalites\connexion;
use iutnc\touiteur\bdd\ConnectionFactory;
require_once '../fonctionnalites/fonctionnalites_6_et_7.php';

ConnectionFactory::makeConnection();
$bdd = ConnectionFactory::$bdd;
try {
    if(isset($_GET['action']) and $_GET['action']==="connect"){
        connexion::connexion();
    }
    unset($_GET['action']);
} catch (Exception $e) {}
if(isset($_SESSION['user'])) {
    if (!isset($_POST['msg']) || $_SERVER['REQUEST_METHOD'] === 'GET') {
        //formulaire de post de touite
        echo '<form action="" method="post">
      Message <textarea name="comment" rows="12" cols="35"></textarea><br>
      <input type="submit" name="submitInfo" value="Submit">
    </form></br>';
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //correction d'un problème dû à la fragmentation du code
        $_POST['mdp'] = $_SESSION['user']['pseudo'];
        $_POST['pseudo'] = $_SESSION['user']['pseudo'];
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
        $idUs = $_SESSION['user']['id'];
        $bdd->exec("INSERT INTO touite (texte,datePublication,idUser) VALUES ('$texte','$dateAct',$idUs)");
        //test si le message contenait des tags
        if (count($tabMes) !== 0) {
            //parcours des tags stocké
            for ($i = 1; $i < count($tabMes); $i++) {
                $repTag = $bdd->query("SELECT idTag FROM Tag WHERE tagLibelle like '$tabMes[$i]'");
                $idTag = $repTag->fetch()['idTag'];
                //si le tag n existe pas
                if (is_null($idTag)) {
                    $bdd->exec("INSERT INTO Tag (tagLibelle,tagDesc) VALUES ('$tabMes[$i]',' ')");
                    $repIdTag = $bdd->query("SELECT idTag FROM Tag WHERE idTag >= ALL(SELECT idTag FROM Tag)");
                    $idTag = $repIdTag->fetch()['idTag'];
                }
                $bdd->exec("INSERT INTO TAGJOINT (idTouite,idTag) VALUES ($idT,$idTag)");
            }
        }
        //debug a supr
        var_dump($_POST);
        echo'<br>';
        var_dump($GLOBALS['_POST']);
        //réintilisation du message
        unset($GLOBALS['_POST']);
    }
}