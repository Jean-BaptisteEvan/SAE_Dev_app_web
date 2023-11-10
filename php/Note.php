<?php
namespace iutnc\touiteur;
require_once '../vendor/autoload.php';
use iutnc\touiteur\bdd\ConnectionFactory;
use \PDO;
use \Exception;
/**
 * This class is used to rate a touite and to know the average rating of a touite.
 */
class Note{

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
     * This function allow you to rate a touite
     */
    static function noter(int $idtouite, int $note){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['user'])){
            $iduser=$_SESSION['user']['id'];
            ConnectionFactory::makeConnection();
            $connexion=ConnectionFactory::$bdd;

            $sql="SELECT idUser from touite where idTouite = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$idtouite);
            $resultset->execute();
            $proprietaire="false";
            while ($row = $resultset->fetch(PDO::FETCH_NUM)){
                if($row[0] === $iduser){
                    $proprietaire="true";
                }
            }

            $sql="SELECT note from note where idUser = ? and idTouite = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$iduser);
            $resultset->bindParam(2,$idtouite);
            $resultset->execute();

            if($resultset->rowCount() === 0 and $proprietaire === "false"){
                $sql="INSERT into note values (?, ?, ?);";
                $resultset = $connexion->prepare($sql);
                $resultset->bindParam(1,$iduser);
                $resultset->bindParam(2,$idtouite);
                $resultset->bindParam(3,$note);
                $resultset->execute();
                echo "<p>Touite noté</p>";
            }else{
                echo "<p>Impossible de noter le touite</p>";
            }
            $connexion=null;
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    }

    /**
     * This function return the average rating of a touite using his id
     * @return ?float either the average rating of the selected touite or nothing if the user isn't logged in
     */
    static function getMoyenne(int $idtouite): ?float{
        if(!isset($_SESSION)){
            session_start();
        }
        $note=null;
        if(isset($_SESSION['user'])){
            ConnectionFactory::makeConnection();
            $connexion=ConnectionFactory::$bdd;

            $sql="SELECT texte from touite where idTouite = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$idtouite);
            $resultset->execute();
            if($resultset->rowCount() > 0){
                $sql="SELECT note from note where idTouite = ?;";
                $resultset = $connexion->prepare($sql);
                $resultset->bindParam(1,$idtouite);
                $resultset->execute();
                $nb=$resultset->rowCount();
                $note=0;
                while ($row = $resultset->fetch(PDO::FETCH_NUM)){
                    $note+=$row[0];
                }
                if($nb!==0){
                    $note=round($note/$nb, 2);
                }
            }else{
                echo "<p>Aucun touite avec cette id n'existe</p>";
            }
            $connexion=null;
            
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    return $note;
    }
}
?>