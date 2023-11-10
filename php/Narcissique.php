<?php
namespace iutnc\touiteur;
require_once '../vendor/autoload.php';
use iutnc\touiteur\bdd\ConnectionFactory;
use iutnc\touiteur\Note;
use \PDO;
use \Exception;
/**
 * This class is used to display the nicknames of the users who follow him, as well as the average score of its touites
 */
class Narcissique{

    static function displayUsers(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['user'])){
            $id=$_SESSION['user']['id'];
            ConnectionFactory::makeConnection();
            $connexion=ConnectionFactory::$bdd;

            $sql="SELECT u.pseudo from user u, suivreuser s where u.idUser = s.idUser and s.idSuivie = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$id);
            $resultset->execute();
            if($resultset->rowCount() === 0){
                echo "Personne ne vous suit";
            } else{
                while ($row = $resultset->fetch(PDO::FETCH_NUM)){
                    echo "<ul class='suiv'>Suivi par <a id='posteur' href='https://fr.wikipedia.org/wiki/Chat#/media/Fichier:Collage_of_Six_Cats-02.jpg'>{$row[0]}</a></ul>";
                }
            }
            $connexion=null;
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    }

    static function displayTouiteNote(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['user'])){
            $id=$_SESSION['user']['id'];
            ConnectionFactory::makeConnection();
            $connexion=ConnectionFactory::$bdd;

            $sql="SELECT idTouite, datePublication from touite where idUser =?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$id);
            $resultset->execute();
            while ($row = $resultset->fetch(PDO::FETCH_NUM)){
                $idtouite=intval($row[0]);
                $date=$row[1];
                echo "Votre touite (id: ".$idtouite.") publié le ".$date." a une moyenne de ".Note::getMoyenne($idtouite)."<br>";
            }
            $connexion=null;
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    }
}
?>