<?php

namespace iutnc\touiteur;

require_once '../vendor/autoload.php';

/**
 * Represent a touite, with its publication date, text, and other things
 */
class Touite {

    private int $id;

    private string $date;
    private string $posteur;
    private string $texte;

    // these two are used for the long version of the touite
    private array $listeTags;
    private int $note;
    private null | Image $image;

    /**
     * @param string $date the date the touite was posted
     * @param string $posteur the creator of the touite
     * @param string $texte the text of the touite
     * @param int $id the id of the touite
     */
    public function __construct(string $date, string $posteur, string $texte, int $id) {
        $this->id = $id;
        $this->date = $date;
        $this->posteur = $posteur;
        $this->texte = $texte;

        $this->listeTags = array();
        $this->note = Note::getMoyenne($this->id);
        $this->image = null;
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
     * Change the default null value of image to a real picture if needed
     * @param $chemin string the path to the picture
     * @param $description string the description of the picture in case it doesn't show up
     * @return void
     */
    public function ajouterImage(string $chemin, string $description) {
        $this->image = new Image($chemin, $description);
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
     * @return null | Image
     */
    public function getImage(): null | Image {
        return $this->image;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }
}