<?php

namespace iutnc\touiteur;

require_once '../vendor/autoload.php';

/**
 * Represent a touite, with its publication date, text, and other things
 */
class Touite {

    private string $date;
    private string $posteur;
    private string $texte;

    // these two are used for the long version of the touite
    private array $listeTags;
    private int $note;
    private Image $image;

    /**
     * @param string $posteur the user who created the touite
     * @param string $texte the text of the touite
     * @param string $date the publication date of the touite
     */
    public function __construct(string $date, string $posteur, string $texte/*, int $note*/) {
        $this->date = $date;
        $this->posteur = $posteur;
        $this->texte = $texte;

        $this->listeTags = array();
        $this->note = -1;
        $this->image = new Image("https://chat.png", "miaou");
    }

    /**
     * Add a tag to the tag list
     * @param Tag $tag the tag
     * @return void
     */
    public function ajouterTag(Tag $tag) {
        array_push($this->listeTags, $tag);
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

    /**
     * @return array
     */
    public function getListeTags(): array {
        return $this->listeTags;
    }

    /**
     * @return int
     */
    public function getNote(): int {
        return $this->note;
    }

    /**
     * @return Image
     */
    public function getImage(): Image {
        return $this->image;
    }
}