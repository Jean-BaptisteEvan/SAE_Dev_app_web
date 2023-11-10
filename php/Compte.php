<?php
namespace iutnc\touiteur;
require_once '../vendor/autoload.php';
use iutnc\touiteur\bdd\ConnectionFactory;
use \PDO;
use \Exception;
/**
 * This class is used to create an account, log in and log out.
 */
class Compte{

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
    * This function (create account) creates a user in the database if the nickname entered in the form is unique.
    * @return int 1 for succes and 0 for error
    */
    static function creationCompte():int{
        $a=0;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $content = '<form action="" method="post">
            <input type="text" id="pseudo" class="fadeIn second" name="pseudo" placeholder="pseudo">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            <input type="text" id="Prenom" class="fadeIn third" name="Prenom" placeholder="Prenom">
            <input type="text" id="Nom" class="fadeIn third" name="Nom" placeholder="Nom">
            <input type="text" id="Email" class="fadeIn third" name="Email" placeholder="Email">
            <input type="submit" class="fadeIn fourth" value="Register">
        </form>';
            echo $content;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = self::test_input($_POST['Nom']);
        $prenom = self::test_input($_POST['Prenom']);
        $email = self::test_input($_POST['Email']);
        $pseudo = self::test_input($_POST['pseudo']);
        $mdp = self::test_input($_POST['password']);
        $truemdp=password_hash($mdp, PASSWORD_DEFAULT,['cost'=> 12]);
        ConnectionFactory::makeConnection();
        $connexion=ConnectionFactory::$bdd;

        $sql="SELECT pseudo from user;";
        $resultset = $connexion->prepare($sql);
        $resultset->execute();
        while ($row = $resultset->fetch(PDO::FETCH_NUM)) {
            if($row[0] === $pseudo){
                throw new Exception('Pseudo déjà existant!');
            }
        }

        $sql="SELECT MAX(idUser) from user;";
        $resultset = $connexion->prepare($sql);
        $resultset->execute();
        while ($row = $resultset->fetch(PDO::FETCH_NUM)) {
            $id = $row[0] + 1;
        }

        $sql="INSERT INTO user (idUser, userNom, userPrenom, userEmail, pseudo, userPass) VALUES (?, ?, ?, ?, ?, ?);";
        
        $resultset = $connexion->prepare($sql);
        $resultset->bindParam(1,$id);
        $resultset->bindParam(2,$nom);
        $resultset->bindParam(3,$prenom);
        $resultset->bindParam(4,$email);
        $resultset->bindParam(5,$pseudo);
        $resultset->bindParam(6,$truemdp);
        $resultset->execute();

        $connexion=null;

        $a=1;
    }
    return $a;
    }

    /**
    * This function (log in) creates a session with the user's informations if he entered the right nickname and password.
    * @return int 1 for succes and 0 for error
    */
    static function connexion():int{
        $a=0;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $content = 
                '<form action="" method="post">
            <input type="text" id="login" class="fadeIn second" name="login" placeholder="login">
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>';
            echo $content;
        }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!isset($_SESSION)){
                session_start();
            }
            $connecte=isset($_SESSION['user']);
            $pseudo = self::test_input($_POST["login"]);
            $mdp = self::test_input($_POST["password"]);
            ConnectionFactory::makeConnection();
            $connexion=ConnectionFactory::$bdd;
            //Selection of the user's informations
            $sql="SELECT idUser, userNom, userPrenom, userEmail, pseudo, userPass, admin from user where pseudo = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$pseudo);
            $resultset->execute();
            if($resultset->rowCount() === 0){
                throw new Exception('Pseudo inexistant!');
            } else{
                $row = $resultset->fetch(PDO::FETCH_NUM);
                if (!password_verify($mdp, $row[5])){
                    throw new Exception('Mot de passe invalide');
                } else{
                    $id = $row[0];
                    $nom = $row[1];
                    $prenom = $row[2];
                    $mail = $row[3];
                    $admin=$row[6];
                    //Adding the user's informations to the session
                    $tabUser = ['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'email' => $mail, 'pseudo' => $pseudo, 'admin' => $admin];                
                    $_SESSION['user'] = $tabUser;
                    //To be sure that the $_SESSION is really created
                    $connecte=isset($_SESSION['user']);
                    if($connecte){
                        $a=1;
                    }
                }
            }
            $connexion=null;
        }
        return $a;
    }

    /**
    * This function (log out) disconnects the logged user by deleting the session.
    * @return int 1 for succes and 0 for error
    */
    static function deconnexion():int{
        $a=0;
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            $a=1;
        }
        return $a;
    }
}
?>
