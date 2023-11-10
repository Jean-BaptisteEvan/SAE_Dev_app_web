<?php
namespace iutnc\touiteur;
use \PDO;
use \Exception;
class Follow{

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
     * This function allow you to follow a user using his nikname
     */
    static function followUser($pseudo){
        session_start();
        if(isset($_SESSION['user'])){
            if($pseudo === $_SESSION['user']['pseudo']){
                throw new Exception('Impossible de se suivre');
            }
            try{
                $connexion = new PDO('mysql:host=localhost;dbname=touiteur', 'root',''); 
            } catch(Exception $e){
                die('Erreur : '.$e->getMessage());
            } 
            $sql="SELECT idUser from USER where pseudo = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$pseudo);
            $resultset->execute();
            if($resultset->rowCount() === 0){
                throw new Exception('Pseudo inexistant!');
            } else{
                $row = $resultset->fetch(PDO::FETCH_NUM);
                $idsuiv=$row[0];
                $sql="INSERT into suivreuser values (?, ?);";
                $resultset = $connexion->prepare($sql);
                $idus=$_SESSION['user']['id'];
                $resultset->bindParam(1,$idus);
                $resultset->bindParam(2,$idsuiv);
                $resultset->execute();
                echo "<p>Utilisateur suivi avec succès!</p>";
            }
            $connexion=null;
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    }

    /**
     * This function allow you to follow a tag using his name
     */
    static function followTag($tag){
        session_start();
        if(isset($_SESSION['user'])){
            $tag = self::test_input($_POST["tag"]);
            try{
                $connexion = new PDO('mysql:host=localhost;dbname=touiteur', 'root',''); 
            } catch(Exception $e){
                die('Erreur : '.$e->getMessage());
            } 
            $sql="SELECT idTag from TAG where tagLibelle = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$tag);
            $resultset->execute();
            if($resultset->rowCount() === 0){
                throw new Exception('Tag inexistant!');
            } else{
                $row = $resultset->fetch(PDO::FETCH_NUM);
                $idtag=$row[0];
                $sql="INSERT into suivreTag values (?, ?);";
                $resultset = $connexion->prepare($sql);
                $idus=$_SESSION['user']['id'];
                $resultset->bindParam(1,$idus);
                $resultset->bindParam(2,$idtag);
                $resultset->execute();
                echo "<p>Tag suivi avec succès!</p>";
            }
            $connexion=null;
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    }
}
?>