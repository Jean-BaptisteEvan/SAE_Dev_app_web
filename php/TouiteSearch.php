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
                                            INNER JOIN User ON User.idUser = Touite.idUser
                                            ORDER BY datePublication DESC");
        $requete1->execute();
        while($ligne1=$requete1->fetch()) {
            $format = "l j F Y h:i:s";
            $dateBrute = explode("-", $ligne1[0]);
            $heureComplete = explode(":", explode(" ", $dateBrute[2])[1]);

            $date = mktime($heureComplete[0], $heureComplete[0], $heureComplete[0],
                           $dateBrute[1], explode(" ", $dateBrute[2])[0], $dateBrute[0]);

            $date = date($format, $date);

            $touite = new touiteur\Touite($date, $ligne1[1], $ligne1[2]);

            // Add the tags related to this touite
            $requete2 = $bdd->prepare("SELECT Tag.tagLibelle, Tag.tagDesc, Image.chemin, Image.imgDesc FROM Tag
	                                            INNER JOIN TagJoint ON TagJoint.idTag = Tag.idTag
                                                INNER JOIN imagejointe ON imagejointe.idTouite = tagjoint.idTouite
	                                            INNER JOIN Image ON image.idImage = imagejointe.idimage
  	                                            WHERE TagJoint.idTouite = ?");
            $requete2->bindParam(1, $ligne1[3]);
            $requete2->execute();
            while($ligne2=$requete2->fetch()) {
                $touite->ajouterTag(new Tag($ligne2[0], $ligne2[1]));
                $touite->ajouterImage($ligne2[2], $ligne2[3]);
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
                                            WHERE Touite.idUser = ? ORDER BY datePublication DESC");
        $requete1->bindParam(1, $idUser);
        $requete1->execute();
        while($ligne1=$requete1->fetch()) {
            $format = "l j F Y h:i:s";
            $dateBrute = explode("-", $ligne1[0]);
            $heureComplete = explode(":", explode(" ", $dateBrute[2])[1]);

            $date = mktime($heureComplete[0], $heureComplete[0], $heureComplete[0],
                $dateBrute[1], explode(" ", $dateBrute[2])[0], $dateBrute[0]);

            $date = date($format, $date);

            $touite = new touiteur\Touite($date, $ligne1[1], $ligne1[2]);

            // Add the tags related to this touite
            $requete2 = $bdd->prepare("SELECT Tag.tagLibelle, Tag.tagDesc, Image.chemin, Image.imgDesc FROM Tag
	                                            INNER JOIN TagJoint ON TagJoint.idTag = Tag.idTag
                                                INNER JOIN imagejointe ON imagejointe.idTouite = tagjoint.idTouite
	                                            INNER JOIN Image ON image.idImage = imagejointe.idimage
  	                                            WHERE TagJoint.idTouite = ?");
            $requete2->bindParam(1, $ligne1[3]);
            $requete2->execute();
            while($ligne2=$requete2->fetch()) {
                $touite->ajouterTag(new Tag($ligne2[0], $ligne2[1]));
                $touite->ajouterImage($ligne2[2], $ligne2[3]);
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
                                            WHERE Tag.tagLibelle = ? ORDER BY datePublication DESC");
        $requete1->bindParam(1, $tagLibelle);
        $requete1->execute();
        while($ligne1=$requete1->fetch()) {
            $format = "l j F Y h:i:s";
            $dateBrute = explode("-", $ligne1[0]);
            $heureComplete = explode(":", explode(" ", $dateBrute[2])[1]);

            $date = mktime($heureComplete[0], $heureComplete[0], $heureComplete[0],
                $dateBrute[1], explode(" ", $dateBrute[2])[0], $dateBrute[0]);

            $date = date($format, $date);

            $touite = new touiteur\Touite($date, $ligne1[1], $ligne1[2]);

            // Add the tags related to this touite
            $requete2 = $bdd->prepare("SELECT Tag.tagLibelle, Tag.tagDesc, Image.chemin, Image.imgDesc FROM Tag
	                                            INNER JOIN TagJoint ON TagJoint.idTag = Tag.idTag
                                                INNER JOIN imagejointe ON imagejointe.idTouite = tagjoint.idTouite
	                                            INNER JOIN Image ON image.idImage = imagejointe.idimage
  	                                            WHERE TagJoint.idTouite = ?");
            $requete2->bindParam(1, $ligne1[3]);
            $requete2->execute();
            while($ligne2=$requete2->fetch()) {
                $touite->ajouterTag(new Tag($ligne2[0], $ligne2[1]));
                $touite->ajouterImage($ligne2[2], $ligne2[3]);
            }
            $requete2->closeCursor();

            array_push($listeTouites, $touite);
        }
        $requete1->closeCursor();

        return $listeTouites;
    }
}