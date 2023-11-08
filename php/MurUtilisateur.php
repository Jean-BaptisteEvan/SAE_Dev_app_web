<?php
namespace iutnc\touiteur;
require_once '../vendor/autoload.php';

class MurUtilisateur{

    public static function renderMur($idUser){
        bdd\ConnectionFactory::makeConnection();
        $bdd = bdd\ConnectionFactory::$bdd;

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




                foreach($listeSuivie as $suivie){
                    if($ligne['idUser'] == $suivie){
                        echo "<div class='touite'><div class='touite-header'><div class='touite-date'>".$ligne['datePublication']."</div></div><div class='touite-text'>".$ligne['texte']."</div></div>";
                    }
                }
                foreach($listeTouiteTag as $touiteTag){
                    if($ligne['idTouite'] == $touiteTag){
                        echo "<div class='touite'><div class='touite-header'><div class='touite-date'>".$ligne['datePublication']."</div></div><div class='touite-text'>".$ligne['texte']."</div></div>";
                    }
                }
            }










        }



}
MurUtilisateur::renderMur(4);