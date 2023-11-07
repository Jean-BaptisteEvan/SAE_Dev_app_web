<?php
public TouiteRenderer{
    function renderCourt($idTouite, $bdd){

        $repTxt = $bdd->query("SELECT Texte FROM touite WHERE idTouite = $idTouite ");
    	$txt = $repTxt->fetch()['texte'];
        $repTag = $bdd->query("SELECT idTag FROM TAGJOINT WHERE idTouite = $idTouite ");
        echo "";
    }
}

