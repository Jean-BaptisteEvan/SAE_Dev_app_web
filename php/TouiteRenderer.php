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
        // Add the tags
        $repTags = "";
        foreach ($touite->getListeTags() as $k => $v) {
            $repTags .= "<a id='tag' href='http://localhost/SAE_Dev_app_web/php/Dispacheur.php?touitesTagedBy={$v->getLibelle()}'>#{$v->getLibelle()}</a> ";
        }

        return "<ul class='search'>par <a id='posteur' href='http://localhost/SAE_Dev_app_web/php/Dispacheur.php?touitesPostedBy={$touite->getIdPosteur()}'>{$touite->getPosteur()}</a>
                <dd>$repTags {$touite->getTexte()}</dd>
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
            $repTags .= "<a id='tag' href='http://localhost/SAE_Dev_app_web/php/Dispacheur.php?touitesTagedBy={$v->getLibelle()}'>#{$v->getLibelle()}</a> ";
        }

        $res = "<ul class='search'>par <a id='posteur' href='http://localhost/SAE_Dev_app_web/php/Dispacheur.php?touitesPostedBy={$touite->getIdPosteur()}'>{$touite->getPosteur()}</a>
                <dd><a id='tag'>$repTags</a> {$touite->getTexte()}</dd>";

        // If there is a picture associated with the touite
        if (!is_null($touite->getImage())) {
            $res .= "<dd><img src='{$touite->getImage()->getChemin()}' alt='{$touite->getImage()->getDescription()}'></dd>";
        }

        $res .= "<br><dd>{$touite->getDate()} note : {$touite->getNote()}
                <br><dd>
                <form id='ajout-noter' method='post' action='Dispacheur.php'>
                    <label>Choisir note</label>
                        <select name='note' id='note'>
                            <option value=1>1</option>
                            <option value=-1>-1</option>
                        </select>
                        <select name='idTouite' id='idTouite'>
                            <option value={$touite->getId()}>{$touite->getId()}</option>
                        </select>
                    <button type='submit' name='valider' value='ajout-noter'>valider</button>
                </form>
                </dd></ul>";
        return $res;
    }
}