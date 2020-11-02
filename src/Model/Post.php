<?php
namespace App\Model;

use App\Helpers\Text;
use DateTime;

/**
 * Model pour l'entité post
 */
class Post{

    private $id;

    private $name;

    private $content;
    
    private $slug;

    private $created_at;

    private $categories = [];

    /**
     * récupère le titre de l'article
     * @return string|null
     */
    public function getName (): ?string 
    {
        return $this->name;
    }

    public function setName (string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getContent (): ?string 
    {
        return $this->content;
    }


    public function setContent (string $content): self
    {
        $this->content = $content;
        return $this;
    }

     public function getFormattedContent(): ?string
    {
        return nl2br(e( $this->content));
    }

    /**
     * permet d'afficher un extrait du contenu de l'article couper à 60 caractère
     * @return string|null
     */
    public function getExcerpt (): ?string 
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities((Text::excerpt($this->content, 60))));
    }

    public function setCreatedAt (string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * récupère la date de l'article
     * @return DateTime
     */
    public function getCreatedAt (): DateTime 
    {
        return new DateTime($this->created_at);
    }

    public function setSlug (string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * récupère le slug
     * @return string|null
     */
    public function getSlug (): ?string 
    {
        return $this->slug;
    }

    /**
     * récupère l'id
     * @return integer|null
     */
    public function getId (): ?int 
    {
        return $this->id;
    }

    /**
     * retourne un tableau de catégories
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * ajoute ue catégorie au tableau de catégories d'un article
     * @param Category $category
     * @return void
     */
    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }
}