<?php

namespace iutnc\touiteur;

/**
 * Represent a touite, with its publication date, text, and other things
 */
class Touite {

    private string $date;
    private string $texte;
    private string $posteur;

    /**
     * @param string $posteur the user who created the touite
     * @param string $texte the text of the touite
     * @param string $date the publication date of the touite
     */
    public function __construct(string $date, string $posteur, string $texte) {
        $this->date = $date;
        $this->posteur = $posteur;
        $this->texte = $texte;
    }

    /**
     * @return string
     */
    public function getDate(): string {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getTexte(): string {
        return $this->texte;
    }

    /**
     * @return string
     */
    public function getPosteur(): string {
        return $this->posteur;
    }
}