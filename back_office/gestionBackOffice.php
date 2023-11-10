
<?php
class gestionBackOffice{

    static  function genererBackOffice($bdd){
        //mise en place de la tete html pour lier le css
        echo '<head>
                  <title>Back Office</title>
                  <link href="backoffice.css" rel="stylesheet" />
             </head>';
        self::affichBestTag($bdd);//methode d'affichage des tags les plus utilisé
        self::affichUtilTend($bdd);//methode d'affichages des utilisateurs les plus suivi
    }
    static function affichBestTag($bdd){
        $res18 = $bdd->query("Select tag.tagLibelle,count(tagjoint.idTag) 
                                    from tagjoint INNER JOIN tag ON tagjoint.idTag = tag.idTag 
                                    group by tagjoint.idTag order by count(tagjoint.idTag) DESC limit 10");

        echo "<table id='tags'><thead><tr><th colspan='2'> top 10 tendance tags</th></tr></thead><tbody>";
        foreach ($res18 as $s) {
            echo "<tr>
          <td>$s[0]</td>
          <td>$s[1]</td>
        </tr>";
        }
        echo "</tbody></table>";
    }
    static function affichUtilTend($bdd){
        $res19 = $bdd->query("Select user.pseudo,count(suivreuser.idSuivie) 
                                    from suivreuser INNER JOIN user ON suivreuser.idSuivie = user.idUser 
                                    group by suivreuser.idSuivie order by count(suivreuser.idSuivie) DESC limit 10");

        echo "<table id='util'><thead><tr><th colspan='2'>top 10 utilisateur tendance</th></tr></thead><tbody>";
        foreach ($res19 as $s) {
            echo "<tr>
          <td>$s[0]</td>
          <td>$s[1]</td>
        </tr>";
        }
        echo "</tbody></table>";
    }

    static function affichFromConex(){

    }
    static function generateConnexion(){

    }

}
