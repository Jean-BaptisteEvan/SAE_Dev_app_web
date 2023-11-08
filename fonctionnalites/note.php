<?php
namespace iutnc\fonctionnalites;
use \PDO;
use \Exception;
class note{

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
    static function noter(){
        session_start();
        if(isset($_SESSION['user'])){
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $content = '<form action="" method="post">
                    <label for="idtouite">Id du touite</label>
                    <input type="number" name="idtouite" id="idtouite" value="0">
                    <select name="note" id="note">
                        <option value="-1">-1</option>
                        <option value="1">1</option>
                    </select>
                    <input type="submit" value="Valider">
                    </form>';
                echo $content;
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idtouite=self::test_input($_POST["idtouite"]);
                $note=self::test_input($_POST["note"]);
                $iduser=$_SESSION['user']['id'];
                try{
                    $connexion = new PDO('mysql:host=localhost;dbname=touiteur', 'root',''); 
                } catch(Exception $e){
                    die('Erreur : '.$e->getMessage());
                } 

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
            }
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
    }

    static function getMoyenne(): ?float{
        session_start();
        $note=null;
        if(isset($_SESSION['user'])){
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $content = '<form action="" method="post">
                    <label for="idtouite">Id du touite</label>
                    <input type="number" name="idtouite" id="idtouite" value="0">
                    <input type="submit" value="Valider">
                    </form>';
                echo $content;
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try{
                    $connexion = new PDO('mysql:host=localhost;dbname=touiteur', 'root',''); 
                } catch(Exception $e){
                    die('Erreur : '.$e->getMessage());
                } 
                $idtouite=self::test_input($_POST["idtouite"]);
                $sql="SELECT note from note where idTouite = ?;";
                $resultset = $connexion->prepare($sql);
                $resultset->bindParam(1,$idtouite);
                $resultset->execute();
                $nb=$resultset->rowCount();
                $note=0;
                while ($row = $resultset->fetch(PDO::FETCH_NUM)){
                    $note+=$row[0];
                }
                $note=round($note/$nb, 2);
            }
        }else{
            echo "<p>Veuillez vous connecter!</p>";
        }
        return $note;
    }
}
?>