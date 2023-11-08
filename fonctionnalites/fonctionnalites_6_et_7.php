<?php
namespace iutnc\fonctionnalites;
use \PDO;
use \Exception;
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
        try{
            $connexion = new PDO('mysql:host=localhost;dbname=touiteur', 'root',''); 
        } catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }

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
        $pseudo = self::test_input($_POST["pseudo"]);
        $mdp = self::test_input($_POST["mdp"]);
        try{
            $connexion = new PDO('mysql:host=localhost;dbname=touiteur', 'root',''); 
        } catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        } 
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
                $admin=$row[5];
                $tabUser = ['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'email' => $mail, 'pseudo' => $pseudo, 'admin' => $admin];
                session_start();
                $_SESSION['user'] = $tabUser;
                if(isset($_SESSION['user'])){
                    echo '<p>Connexion réussie!</p>';
                }
            } else{
                throw new Exception('Mot de passe invalide');
            }
        }
    }
}

/**
 * This function (logs out) disconnects the logged user by deleting the session.
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
