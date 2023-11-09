<?php
namespace iutnc\touiteur;
require_once '../vendor/autoload.php';
use iutnc\touiteur\bdd\ConnectionFactory;
use \PDO;
use \Exception;
/**
 * This class is used to delete a touite.
 */
class Supression{

    /**
    * This function transforms the data passed into a parameter so that it does not present any security risks.
    * @param mixed $data Data recieved from a form
    * @return mixed $data Data with no security risk
    */
    static function test_input(mixed $data) : mixed{
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
    * This function delete a touite from the database and all the links between the tags and the touite
    */
    static function delete(){
        session_start();
        if(!isset($_SESSION['user'])){
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $content = '<form action="" method="post">
                    <label for="idtouite">Id du touite</label>
                    <input type="number" name="idtouite" id="idtouite" value="0">
                    <input type="submit" value="Ajouter">
                    </form>';
                echo $content;
            }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idtouite = self::test_input($_POST["idtouite"]);
                ConnectionFactory::makeConnection();
                $connexion=ConnectionFactory::$bdd;
                //Removal of tags attached to the touite
                $sql="DELETE from tagjoint where idTouite = ?;";
                $resultset = $connexion->prepare($sql);
                $resultset->bindParam(1,$idtouite);
                $resultset->execute();

                //Removal of the touite
                $sql="DELETE from touite where idTouite = ?;";
                $resultset = $connexion->prepare($sql);
                $resultset->bindParam(1,$idtouite);
                $resultset->execute();
                echo "<p>Touite suprimé</p>";
                $connexion=null;
            }
        } else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    }
}
?>