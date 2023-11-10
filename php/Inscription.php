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


        <form>
            <input type="text" id="pseudo" class="fadeIn second" name="login" placeholder="pseudo">
            <input type="password" id="password" class="fadeIn third" name="login" placeholder="password">
            <input type="text" id="Prenom" class="fadeIn third" name="login" placeholder="Prenom">
            <input type="text" id="Nom" class="fadeIn third" name="login" placeholder="Nom">
            <input type="text" id="Email" class="fadeIn third" name="login" placeholder="Email">
            <input type="submit" class="fadeIn fourth" value="Register">
        </form>



    </div>
</div>
</body><?php
