<?php

namespace iutnc\touiteur;

require_once '../vendor/autoload.php';

/**
 * Display a touite, short or long version
 */
class TouiteRenderer {

    /**
     * Display a touite in short version
     * @param Touite $touite the touite we want to display
     * @return string the string displaying the touite
     */
    public static  function renderCourt(Touite $touite) : string {
        return "par {$touite->getPosteur()} le {$touite->getDate()}<br>
                <dd>{$touite->getTexte()}</dd><br>";
    }

    /**
     * Display a touite in long version
     * @param Touite $touite the touite we want to display
     * @return string the string displaying the touite
     */
    public static  function renderLong(Touite $touite) : string {
        // Add the tags
        $repTags = "";
        foreach ($touite->getListeTags() as $k => $v) {
            $repTags .= "#{$v->getLibelle()} ";
        }

        $rep = "par {$touite->getPosteur()} le {$touite->getDate()}<br>
                <dd>$repTags<br>{$touite->getTexte()}</dd>
                <dd>{$touite->getImage()->getChemin()}</dd>
                <dd>{$touite->getNote()}</dd>
                <br>";
        return $rep;
    }
}