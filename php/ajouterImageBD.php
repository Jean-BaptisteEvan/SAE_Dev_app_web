<?php

namespace iutnc\touiteur;

require_once '../vendor/autoload.php';

use iutnc\touiteur\bdd\ConnectionFactory;

// Add the picture to the directory
$repertoire = "../php/Image/Touites/";

$nomFichier = $_FILES['inputfile']['name'];
$tmp = $_FILES['inputfile']['tmp_name'] ;
if (($_FILES['inputfile']['error'] === UPLOAD_ERR_OK) &&
    ($_FILES['inputfile']['type'] === 'image/jpeg')) {
    $dest = $repertoire . $nomFichier;
    if (move_uploaded_file($tmp, $dest)) {
        echo "Image téléchargée<br>";
    } else {
        echo "Echec du téléchargement<br>";
    }
} else {
    print "Echec du téléchargement ou type non autorisé<br>";
}

// Add the picture to the database
ConnectionFactory::makeConnection();
$bdd = ConnectionFactory::$bdd;
$requete1 = $bdd->prepare("INSERT INTO Image (imgDesc, chemin) VALUES (?, ?)");
$requete1->bindParam(1, $_POST['description']);
$requete1->bindParam(2, $dest);
$requete1->execute();