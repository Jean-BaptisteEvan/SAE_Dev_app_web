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
        return "<ul>par <a id='posteur' href='https://fr.wikipedia.org/wiki/Chat#/media/Fichier:Collage_of_Six_Cats-02.jpg'>{$touite->getPosteur()}</a>
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

        return "<ul>par <a id='posteur' href='https://fr.wikipedia.org/wiki/Chat#/media/Fichier:Collage_of_Six_Cats-02.jpg'>{$touite->getPosteur()}</a>
                <dd><a id='tag' href='https://fr.wikipedia.org/wiki/Chat#/media/Fichier:Collage_of_Six_Cats-02.jpg'>$repTags</a> {$touite->getTexte()}</dd>
                <dd>{$touite->getImage()->getChemin()}</dd>
                <br>
                <dd>{$touite->getDate()} note : {$touite->getNote()}
                </ul>";
    }
}