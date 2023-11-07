<?php

namespace iutnc\touiteur;

require_once '../vendor/autoload.php';

use iutnc\touiteur\bdd;
use iutnc\touiteur;
use PDO;

/**
 * Class used to search touites, e.g : every touite posted by someone
 * or every touite with a specific tag
 */
class TouiteSearch {

    /**
     * Return every touites
     * @return array the array containing the touites
     */
    public static function getAllTouites() : array {
        bdd\ConnectionFactory::makeConnection();
        $bdd = bdd\ConnectionFactory::$bdd;

        $listeTouites = array();

        $requete = "SELECT Publier.datePublication, User.pseudo, Touite.texte FROM Touite
                        INNER JOIN Publier ON Publier.idTouite = Touite.idTouite
                        INNER JOIN User ON User.idUser = Publier.idUser";
        $rep = $bdd->prepare($requete);
        $rep->execute();
        while($ligne=$rep->fetch(PDO::FETCH_NUM)) {
            $touite = new touiteur\Touite($ligne[0], $ligne[1], $ligne[2]);
            array_push($listeTouites, $touite);
            echo "$ligne[0], $ligne[1], $ligne[2]<br>";
        }
        $rep->closeCursor();

        return $listeTouites;
    }

    /**
     * Return every touites made by a specific user
     * @param int $idUser the id of the user in question
     * @return array the array containing the touites
     */
    public static function getTouitesPostedBy(int $idUser) : array {
        bdd\ConnectionFactory::makeConnection();
        $bdd = bdd\ConnectionFactory::$bdd;

        $listeTouites = array();

        $requete = "SELECT Publier.datePublication, User.pseudo, Touite.texte FROM Touite
                        INNER JOIN Publier ON Publier.idTouite = Touite.idTouite
                        INNER JOIN User ON User.idUser = Publier.idUser
                        WHERE Publier.idUser = ? ORDER BY datePublication ASC";
        $rep = $bdd->prepare($requete);
        $rep->bindParam(1, $idUser);
        $rep->execute();
        while($ligne=$rep->fetch(PDO::FETCH_NUM)) {
            $touite = new touiteur\Touite($ligne[0], $ligne[1], $ligne[2]);
            array_push($listeTouites, $touite);
            echo "$ligne[0], $ligne[1], $ligne[2]<br>";
        }
        $rep->closeCursor();
        
        return $listeTouites;
    }

    /**
     * Return every touites with a specific tag
     * @param int $tagLibelle the libelle of the tag in question
     * @return array the array containing the touites
     */
    public static function getTouitesTagedBy(string $tagLibelle) : array {
        bdd\ConnectionFactory::makeConnection();
        $bdd = bdd\ConnectionFactory::$bdd;

        $listeTouites = array();

        $requete = "SELECT Publier.datePublication, User.pseudo, Touite.texte, Tag.tagLibelle FROM Touite
                        INNER JOIN Publier ON Publier.idTouite = Touite.idTouite
                        INNER JOIN User ON User.idUser = Publier.idUser
                        INNER JOIN TagJoint ON TagJoint.idTouite = Touite.idTouite
                        INNER JOIN Tag ON Tag.idTag = TagJoint.idTag 
                        WHERE Tag.tagLibelle = ? ORDER BY datePublication ASC";
        $rep = $bdd->prepare($requete);
        $rep->bindParam(1, $tagLibelle);
        $rep->execute();
        while($ligne=$rep->fetch(PDO::FETCH_NUM)) {
            $touite = new touiteur\Touite($ligne[0], $ligne[1], $ligne[2]);
            array_push($listeTouites, $touite);
            echo "$ligne[0], $ligne[1], $ligne[2]<br>";
        }
        $rep->closeCursor();

        return $listeTouites;
    }
}

//TouiteSearch::getAllTouites();
//TouiteSearch::getTouitesPostedBy(3);
TouiteSearch::getTouitesTagedBy("Chat");