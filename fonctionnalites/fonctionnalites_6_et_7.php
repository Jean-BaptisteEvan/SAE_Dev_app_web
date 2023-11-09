<?php
namespace iutnc\fonctionnalites;
require_once '../vendor/autoload.php';
use iutnc\touiteur\bdd\ConnectionFactory;
use \PDO;
use \Exception;
/**
 * This class is used to create an account, log in and log out.
 */
class connexion{

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
    static function creationCompte(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $content = '<form action="" method="post">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom">
                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp">
                <input type="submit" value="Ajouter">
                </form>';
            echo $content;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = self::test_input($_POST["nom"]);
            $prenom = self::test_input($_POST["prenom"]);
            $email = self::test_input($_POST["email"]);
            $pseudo = self::test_input($_POST["pseudo"]);
            $mdp = self::test_input($_POST["mdp"]);
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

            $conexion=null;

            echo "<p>Utilisateur créer avec succès!</p>";
        }
    }

    /**
    * This function (log in) creates a session with the user's informations if he entered the right nickname and password.
    */
    static function connexion(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $content = '<form action="" method="post">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp">
                <input type="submit" value="Ajouter">
                </form>';
            echo $content;
        }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $connecte=isset($_SESSION['user']);
            $pseudo = self::test_input($_POST["pseudo"]);
            $mdp = self::test_input($_POST["mdp"]);
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
        }
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
