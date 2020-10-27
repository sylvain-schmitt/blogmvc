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

    /**
     * récupère le contenu couper à 60 caractère
     * @return string|null
     */
    public function getExcerpt (): ?string 
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities((Text::excerpt($this->content, 60))));
    }

    /**
     * récupère la date de l'article
     * @return DateTime
     */
    public function getCreatedAt (): DateTime 
    {
        return new DateTime($this->created_at);
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


}