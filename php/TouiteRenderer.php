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
    public static function renderCourt(Touite $touite) : string {
        return "<ul class='search'>par <a id='posteur'>{$touite->getPosteur()}</a>
                <dd>{$touite->getTexte()}</dd>
                <br>
                <dd>{$touite->getDate()}</dd>
                </ul>";
    }

    /**
     * Display a touite in long version
     * @param Touite $touite the touite we want to display
     * @return string the string displaying the touite
     */
    public static function renderLong(Touite $touite) : string {
        // Add the tags
        $repTags = "";
        foreach ($touite->getListeTags() as $k => $v) {
            $repTags .= "#{$v->getLibelle()} ";
        }

        $res = "<ul class='search'>par <a id='posteur'>{$touite->getPosteur()}</a>
                <dd><a id='tag'>$repTags</a> {$touite->getTexte()}</dd>";

        // If there is a piture associated with the touite
        if (!is_null($touite->getImage())) {
            $res .= "<dd><img src='{$touite->getImage()->getChemin()}' alt='{$touite->getImage()->getDescription()}'></dd>";
        }

        $res .= "<br><dd>{$touite->getDate()} note : {$touite->getNote()}</ul>";
        return $res;
    }
}