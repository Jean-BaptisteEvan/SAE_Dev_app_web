<?php

namespace iutnc\touiteur;

/**
 * Represents a tag
 */
class Tag {

    private string $libelle;
    private string $description;

    /**
     * @param string $libelle the libelle of the tag
     * @param string $description its description
     */
    public function __construct(string $libelle, string $description) {
        $this->libelle = $libelle;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLibelle(): string {
        return $this->libelle;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }
}