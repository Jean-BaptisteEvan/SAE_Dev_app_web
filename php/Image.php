<?php

namespace iutnc\touiteur;

/**
 * Represents a picture
 */
class Image {

    private string $chemin;
    private string $description;

    /**
     * @param string $chemin the URL path of the picture
     * @param string $description its description
     */
    public function __construct(string $chemin, string $description) {
        $this->chemin = $chemin;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getChemin(): string {
        return $this->chemin;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }
}