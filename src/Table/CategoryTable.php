<?php
namespace App\Table;

use PDO;
use App\Model\Category;

final class CategoryTable extends Table {

    protected $table = "category";
    protected $class = Category::class;

    /**
     * @param App\Model\Post[] $posts
     */
    public function hydratePosts(array $posts): void{

        //on recupère les catégories associer à un article
        $postByID = [];
        foreach($posts as $post){
            $postByID[$post->getId()] = $post;
        }
        $categories = $this->pdo
            ->query('SELECT c.*, pc.post_id
                    FROM post_category pc
                    JOIN category c on c.id = pc.category_id
                    WHERE pc.post_id in (' .  implode(',', array_keys($postByID)) . ')'
            )->fetchAll(PDO::FETCH_CLASS, $this->class);

            foreach($categories as $category){
                $postByID[$category->getPostID()]->addCategory($category);
            }

    }



}