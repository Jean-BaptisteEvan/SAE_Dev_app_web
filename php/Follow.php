<?php
namespace iutnc\touiteur;
require_once '../vendor/autoload.php';
use \PDO;
use iutnc\touiteur\bdd\ConnectionFactory;
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
    static function followUser():int{
        $a=0;
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['user'])){
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $content = 
                    '<form action="" method="post">
                <input type="text" id="pseudo" class="fadeIn second" name="pseudo" placeholder="Pseudo de l utilisateur">
                <input type="submit" class="fadeIn fourth" value="Suivre">
            </form>';
                echo $content;
            }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pseudo = self::test_input($_POST['pseudo']);
            if($pseudo === $_SESSION['user']['pseudo']){
                throw new Exception('Impossible de se suivre');
            }else{
            ConnectionFactory::makeConnection();
            $connexion=ConnectionFactory::$bdd;
            $sql="SELECT idUser from user where pseudo = ?;";
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
                $a=1;
            }
            $connexion=null;
        }
        }
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
        return $a;
    }

    /**
     * This function allow you to follow a tag using his name
     */
    static function followTag():int{
        $a=0;
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['user'])){
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $content = 
                    '<form action="" method="post">
                <input type="text" id="tag" class="fadeIn second" name="tag" placeholder="Libelle du tag">
                <input type="submit" class="fadeIn fourth" value="Suivre">
            </form>';
                echo $content;
            }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tag = self::test_input($_POST['tag']);
            ConnectionFactory::makeConnection();
            $connexion=ConnectionFactory::$bdd;
            $sql="SELECT idTag from tag where tagLibelle = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$tag);
            $resultset->execute();
            if($resultset->rowCount() === 0){
                throw new Exception('Tag inexistant!');
            } else{
                $row = $resultset->fetch(PDO::FETCH_NUM);
                $idtag=$row[0];
                $sql="INSERT into suivretag values (?, ?);";
                $resultset = $connexion->prepare($sql);
                $idus=$_SESSION['user']['id'];
                $resultset->bindParam(1,$idus);
                $resultset->bindParam(2,$idtag);
                $resultset->execute();
                $a=1;
            }
            $connexion=null;
        }
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
        return $a;
    }
}
?>