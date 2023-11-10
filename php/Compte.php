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
    */
    static function creationCompte($nom, $prenom, $email, $pseudo, $mdp){
        $nom = self::test_input($nom);
        $prenom = self::test_input($prenom);
        $email = self::test_input($email);
        $pseudo = self::test_input($pseudo);
        $mdp = self::test_input($mdp);
        $truemdp=password_hash($mdp, PASSWORD_DEFAULT,['cost'=> 12]);
        ConnectionFactory::makeConnection();
        $connexion=ConnectionFactory::$bdd;

        $sql="SELECT pseudo from USER;";
        $resultset = $connexion->prepare($sql);
        $resultset->execute();
        while ($row = $resultset->fetch(PDO::FETCH_NUM)) {
            if($row[0] === $pseudo){
                throw new Exception('Pseudo déjà existant!');
            }
        }

        $sql="SELECT MAX(idUser) from USER;";
        $resultset = $connexion->prepare($sql);
        $resultset->execute();
        while ($row = $resultset->fetch(PDO::FETCH_NUM)) {
            $id = $row[0] + 1;
        }

        $sql="INSERT INTO USER (idUser, userNom, userPrenom, userEmail, pseudo, userPass) VALUES (?, ?, ?, ?, ?, ?);";
        
        $resultset = $connexion->prepare($sql);
        $resultset->bindParam(1,$id);
        $resultset->bindParam(2,$nom);
        $resultset->bindParam(3,$prenom);
        $resultset->bindParam(4,$email);
        $resultset->bindParam(5,$pseudo);
        $resultset->bindParam(6,$truemdp);
        $resultset->execute();

        $connexion=null;

        echo "<p>Utilisateur créer avec succès!</p>";
    }

    /**
    * This function (log in) creates a session with the user's informations if he entered the right nickname and password.
    */
    static function connexion($pseudo, $mdp){
        $pseudo = self::test_input($pseudo);
        $mdp = self::test_input($mdp);
        session_start();
        $connecte=isset($_SESSION['user']);
        ConnectionFactory::makeConnection();
        $connexion=ConnectionFactory::$bdd;
        //Selection of the user's informations
        $sql="SELECT idUser, userNom, userPrenom, userEmail, pseudo, userPass, admin from USER where pseudo = ?;";
        $resultset = $connexion->prepare($sql);
        $resultset->bindParam(1,$pseudo);
        $resultset->execute();
        if($resultset->rowCount() === 0){
            throw new Exception('Pseudo inexistant!');
        } else{
            $row = $resultset->fetch(PDO::FETCH_NUM);
            if (password_verify($mdp, $row[5])){
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
                    echo '<p>Connexion réussie!</p>';
                }
            } else{
                throw new Exception('Mot de passe invalide');
            }
        }
        $connexion=null;
    }

    /**
    * This function (log out) disconnects the logged user by deleting the session.
    */
    static function deconnexion(){
        session_start();
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            echo "<p>Déconnexion réussie!</p>";
        } else{
            echo "<p>Aucun utilisateur n'est connecté</p>";
        }
    }
}
?>
