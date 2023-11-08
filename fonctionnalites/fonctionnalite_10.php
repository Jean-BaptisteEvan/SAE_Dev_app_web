<?php
namespace iutnc\fonctionnalites;
use \PDO;
class supression{

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

static function delete(){
    if(!isset($_SESSION['user'])){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $content = '<form action="" method="post">
                <label for="idtouite">Id du touite</label>
                <input type="number" name="idtouite" id="idtouite" value="0">
                <input type="submit" value="Ajouter">
                </form>';
            echo $content;
        }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idtouite = supression::test_input($_POST["idtouite"]);
            try{
                $connexion = new PDO('mysql:host=localhost;dbname=touiteur', 'root',''); 
            } catch(Exception $e){
                die('Erreur : '.$e->getMessage());
            }
            $sql="DELETE from tagjoint where idTouite = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$idtouite);
            $resultset->execute();
            
            $sql="DELETE from touite where idTouite = ?;";
            $resultset = $connexion->prepare($sql);
            $resultset->bindParam(1,$idtouite);
            $resultset->execute();
            echo "Touite suprimé";
        }
    } else{
        echo "Veuillez vous connecter!";
    }
}


}
?>