<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/styleConnection.css" />

    <meta charset="UTF-8">
    <title>Touiteur</title>
    <link rel="icon" type="image/x-icon" href="Image/Logotouiteur-removebg-preview.png" />
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent">

        <a href="SuivreTag.php"> <h2 class="active"> Suivre un tag </h2></a>
        <a href="SuivreUser.php"><h2 class="active">Suivre un utilisateur </h2></a>


        <div class="Ico">
            <img src="Image/Logotouiteur-removebg-preview.png" id="icon" alt="User Icon" />
        </div>


        <?php
        use iutnc\touiteur\Follow;

        require_once "../vendor/autoload.php";

        session_start();
        $a=0;
        try {
        $a=Follow::followTag();
        } catch(Exception $e){
            echo $e->getMessage()."<br>";
            echo '<a href="SuivreTag.php"><h2 class="active">Réessayer </h2></a>';
            echo '<a href="Dispacheur.php"><h2 class="active">Retourner sur touiteur </h2></a>';
        }
        if($a===1){
            echo "Tag suivi!<br>";
            echo '<a href="DispacheurMurUti.php"><h2 class="active">Retourner sur touiteur </h2></a>';
        }
        ?>



    </div>
</div>
</body>