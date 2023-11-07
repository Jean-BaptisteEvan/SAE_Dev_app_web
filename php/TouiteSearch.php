<?php


/**
 * Class used to search touites, e.g : every touite posted by someone
 * or every touite with a specific tag
 */
class TouiteSearch {

    /**
     * Return every touites made by a specific user
     * @param int $idUser the id of the user in question
     * @return array the array containing the touites
     */
    public static function getTouitesPostedBy(int $idUser) : array {
        \iutnc\touiteur\bdd\ConnectionFactory::makeConnection();
        $bdd = \iutnc\touiteur\bdd\ConnectionFactory::$bdd;

        $idUs = 3; //bidon ! à remplacer par la valeur de l'id actuel de l'utilisateur
        $listeTouites = array();

        $requete = "SELECT Touite.texte, Publier.user FROM Touite
                        INNER JOIN Publier ON Publier.idTouite = Touite.idTouite
                        WHERE idUser = ?";
        $rep = $bdd->query($requete);
        $rep->bindParam(1, $idUs);

        while($ligne=$rep->fetch(PDO::FETCH_NUM)) {
            echo "$ligne[0]";
        }
        $rep->closeCursor();

        return $listeTouites;
    }
}