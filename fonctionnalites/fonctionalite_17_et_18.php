<head>
<link href="bordel.css" rel="stylesheet" />
</head>
<?php
try{
    $bdd = new PDO('mysql:host=localhost; dbname=touiteur; charset=utf8','root', "");
}catch(Exception $e){
    die('erreur: '.$e->getMessage());
}

$res18 = $bdd->query("Select tag.tagLibelle,count(tagjoint.idTag) 
                                from tagjoint INNER JOIN tag ON tagjoint.idTag = tag.idTag 
                                group by tagjoint.idTag order by count(tagjoint.idTag) DESC");

echo "<table><thead><tr><th colspan='2'> tendance tags</th></tr></thead><tbody>";
foreach ($res18 as $s){
    echo "<tr>
      <td>$s[0]</td>
      <td>$s[1]</td>
    </tr>";
}
echo "</tbody></table>";

$res19 = $bdd->query("Select user.pseudo,count(suivreuser.idSuivie) 
                                from suivreuser INNER JOIN user ON suivreuser.idSuivie = user.idUser 
                                group by suivreuser.idSuivie order by count(suivreuser.idSuivie) DESC");

echo "<table><thead><tr><th colspan='2'> utilisateur tendance</th></tr></thead><tbody>";
foreach ($res19 as $s){
    echo "<tr>
      <td>$s[0]</td>
      <td>$s[1]</td>
    </tr>";
}
echo "</tbody></table>";