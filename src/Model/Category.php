<?php
namespace App\Model;

/**
 * modèle pour l'entité category
 */
class Category {

    private $id;

    private $slug;

    private $name;

    /**
     * récupère l'id de la catégorie
     * @return void
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * récupère le slug
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * retourne le nom 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}