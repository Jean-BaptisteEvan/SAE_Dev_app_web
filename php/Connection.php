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

        <a href="Connection.php"> <h2 class="active"> Sign In </h2></a>
        <a href="Inscription.php"><h2 class="active">Sign Up </h2></a>


        <div class="Ico">
            <img src="Image/Logotouiteur-removebg-preview.png" id="icon" alt="User Icon" />
        </div>


        <?php
        use iutnc\touiteur\Compte;

        require_once "../vendor/autoload.php";

        session_start();
        $a=0;
        try {
        $a=Compte::connexion();
        } catch(Exception $e){
            echo '<a href="Connection.php"><h2 class="active">Réessayer </h2></a>';
        }
        if($a===1){
            echo '<a href="DispacheurMurUti.php"><h2 class="active">Accéder à touiteur </h2></a>';
        }
        ?>



    </div>
</div>
</body>

