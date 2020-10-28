<?php

use App\Connection;
use App\Model\Post;
use App\Model\Category;

$id = (int)$params['id'];
$slug = $params['slug'];

//on fait une requète préparer pour récupérer un article en fonction de son ID
$pdo = Connection::getPDO();
$query = $pdo->prepare('SELECT * FROM post Where id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
/** @var Post|false */
$post = $query->fetch();

//on vérifie si l'article existe
if($post === false) {
    throw new Exception('Aucun article ne correspond à cet ID');
}

//on vérifie que le slug de l'article correspond avec celui passer en paramètre sinon on redirige vers la bonne url 
if($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

//on fait une requète préparer avec une jointure sur la table category pour récupérer les catégories associé à l'article en fonction de son ID
$query = $pdo->prepare('
SELECT c.id, c.slug, c.name
FROM post_category pc 
JOIN category c ON pc.category_id = c.id
Where pc.post_id = :id');
$query->execute(['id' => $post->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();
?>

<h1 class="card-title"><?= e ($post->getName()) ?></h1>
     <p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d F Y à h:i') ?></p>
     <?php foreach($categories as $k => $category):
                if ($k > 0):
                    echo', ';
                endif;
                $category_url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]) ?>
                <a href="<?= $category_url ?> "><?= e($category->getName()) ?></a><?php
            endforeach
            ?>
     <p><?= $post->getFormattedContent() ?></p>