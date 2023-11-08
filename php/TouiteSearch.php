<?php

namespace iutnc\touiteur;

require_once '../vendor/autoload.php';

use iutnc\touiteur\bdd;
use iutnc\touiteur;

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

        $requete1 = $bdd->prepare("SELECT Touite.datePublication, User.pseudo, Touite.texte, Touite.idTouite FROM Touite
                                            INNER JOIN User ON User.idUser = Touite.idUser");
        $requete1->execute();
        while($ligne1=$requete1->fetch()) {
            $touite = new touiteur\Touite($ligne1[0], $ligne1[1], $ligne1[2]);

            // Add the tags related to this touite
            $requete2 = $bdd->prepare("SELECT Tag.tagLibelle, Tag.tagDesc FROM Tag
                                                INNER JOIN TagJoint ON TagJoint.idTag = Tag.idTag
                                                WHERE TagJoint.idTouite = ?");
            $requete2->bindParam(1, $ligne1[3]);
            $requete2->execute();
            while($ligne2=$requete2->fetch()) {
                $touite->ajouterTag(new Tag($ligne2[0], $ligne2[1]));
            }
            $requete2->closeCursor();

            array_push($listeTouites, $touite);
        }
        $requete1->closeCursor();

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

        $requete1 = $bdd->prepare("SELECT Touite.datePublication, User.pseudo, Touite.texte, Touite.idTouite FROM Touite
                                            INNER JOIN User ON User.idUser = Touite.idUser
                                            WHERE Touite.idUser = ? ORDER BY datePublication ASC");
        $requete1->bindParam(1, $idUser);
        $requete1->execute();
        while($ligne1=$requete1->fetch()) {
            $touite = new touiteur\Touite($ligne1[0], $ligne1[1], $ligne1[2]);

            // Add the tags related to this touite
            $requete2 = $bdd->prepare("SELECT Tag.tagLibelle, Tag.tagDesc FROM Tag
                                                INNER JOIN TagJoint ON TagJoint.idTag = Tag.idTag
                                                WHERE TagJoint.idTouite = ?");
            $requete2->bindParam(1, $ligne1[3]);
            $requete2->execute();
            while($ligne2=$requete2->fetch()) {
                $touite->ajouterTag(new Tag($ligne2[0], $ligne2[1]));
            }
            $requete2->closeCursor();

            array_push($listeTouites, $touite);
        }
        $requete1->closeCursor();
        
        return $listeTouites;
    }

    /**
     * Return every touites with a specific tag
     * @param string $tagLibelle the libelle of the tag in question (e.g chat)
     * @return array the array containing the touites
     */
    public static function getTouitesTagedBy(string $tagLibelle) : array {
        bdd\ConnectionFactory::makeConnection();
        $bdd = bdd\ConnectionFactory::$bdd;

        $listeTouites = array();

        $requete1 = $bdd->prepare("SELECT Touite.datePublication, User.pseudo, Touite.texte, Touite.idTouite FROM Touite
                                            INNER JOIN User ON User.idUser = Touite.idUser
                                            INNER JOIN TagJoint ON TagJoint.idTouite = Touite.idTouite
                                            INNER JOIN Tag ON Tag.idTag = TagJoint.idTag
                                            WHERE Tag.tagLibelle = ? ORDER BY datePublication ASC");
        $requete1->bindParam(1, $tagLibelle);
        $requete1->execute();
        while($ligne1=$requete1->fetch()) {
            $touite = new touiteur\Touite($ligne1[0], $ligne1[1], $ligne1[2]);

            // Add the tags related to this touite
            $requete2 = $bdd->prepare("SELECT Tag.tagLibelle, Tag.tagDesc FROM Tag
                                                INNER JOIN TagJoint ON TagJoint.idTag = Tag.idTag
                                                WHERE TagJoint.idTouite = ?");
            $requete2->bindParam(1, $ligne1[3]);
            $requete2->execute();
            while($ligne2=$requete2->fetch()) {
                $touite->ajouterTag(new Tag($ligne2[0], $ligne2[1]));
            }
            $requete2->closeCursor();

            array_push($listeTouites, $touite);
        }
        $requete1->closeCursor();

        return $listeTouites;
    }
}