<?php
namespace iutnc\touiteur;
require_once '../vendor/autoload.php';
use iutnc\touiteur\TouiteRenderer;
use iutnc\touiteur\TouiteSearch;



class MurUtilisateur{

    public static function renderMur($idUser){
        bdd\ConnectionFactory::makeConnection();
        $bdd = bdd\ConnectionFactory::$bdd;

        if(isset($_GET['action']) and $_GET['action']==="narc"){
            Narcissique::displayUsers();
            Narcissique::displayTouiteNote();
        }
        /*
        * On récupère la liste des utilisateurs suivis par l'utilisateur courant
        */
        $suivie = $bdd->prepare("SELECT idSuivie FROM suivreuser WHERE idUser = ?");
        $suivie->bindParam(1, $idUser);
        $suivie->execute();
        $listeSuivie = array();
        while($ligne=$suivie->fetch()){
            array_push($listeSuivie, $ligne['idSuivie']);
        }
        $suivie->closeCursor();
        /*
         * On recupère la liste des tags suivi pas l'utilisateur
         *
         */
        $suivieTag = $bdd->prepare("SELECT idTag FROM suivretag WHERE idUser = ?");
        $suivieTag->bindParam(1, $idUser);
        $suivieTag->execute();
        $listeSuivieTag = array();
        while($ligne=$suivieTag->fetch()){
            array_push($listeSuivieTag, $ligne['idTag']);
        }
        /*
         * on recupere la liste des touites qui contiennent les tags suivis par l'utilisateur
         */
        $listeTouiteTag = array();
        foreach($listeSuivieTag as $tag){
            $touiteTag = $bdd->prepare("SELECT idTouite FROM tagjoint WHERE idTag = ?");
            $touiteTag->bindParam(1, $tag);
            $touiteTag->execute();
            while($ligne=$touiteTag->fetch()){
                array_push($listeTouiteTag, $ligne['idTouite']);
            }
        }


        /*
         * On récupère la liste des touites
         */
        $listeTouite = $bdd->query("SELECT * FROM touite  ORDER BY datePublication DESC");
        while($ligne=$listeTouite->fetch()){



            bdd\ConnectionFactory::makeConnection();
            $bdd = bdd\ConnectionFactory::$bdd;

                foreach($listeSuivie as $suivie){

                    if($ligne['idUser'] == $suivie){

                        $requete1 = $bdd->prepare("SELECT  user.pseudo FROM touite
                                            INNER JOIN user ON user.idUser = touite.idUser Where user.idUser = ?");
                        $requete1->bindParam(1, $ligne['idUser']);
                        $requete1->execute();
                        $ligne1=$requete1->fetch();
                        $touite =new Touite($ligne['datePublication'], $ligne1['pseudo'], $ligne['texte'], $ligne['idTouite'], $ligne['idUser']);
                        echo TouiteRenderer::renderCourt($touite);
                    }
                }
                foreach($listeTouiteTag as $touiteTag){

                    if($ligne['idTouite'] == $touiteTag){
                        $requete1 = $bdd->prepare("SELECT  user.pseudo FROM touite
                                            INNER JOIN user ON user.idUser = touite.idUser Where user.idUser = ?");
                        $requete1->bindParam(1, $ligne['idUser']);
                        $requete1->execute();
                        $ligne1=$requete1->fetch();

                            $touite =new Touite($ligne['datePublication'],$ligne1['pseudo'], $ligne['texte'], $ligne['idTouite'], $ligne['idUser']);
                            echo TouiteRenderer::renderCourt($touite);
                    }
                }
            }










        }



}
MurUtilisateur::renderMur(4);
