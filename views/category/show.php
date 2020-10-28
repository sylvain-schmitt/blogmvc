<?php

use App\Connection;
use App\Model\Post;
use App\Model\Category;
use App\PaginatedQuery;

$id = (int)$params['id'];
$slug = $params['slug'];

//on fait une requète préparer pour récupérer les articles appartenant à une catégorie
$pdo = Connection::getPDO();
$query = $pdo->prepare('SELECT * FROM category Where id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category|false */
$category = $query->fetch();

//on vérifie si la catégorie existe
if($category === false) {
    throw new Exception('Aucune catégorie ne correspond à cet ID');
}

//on vérifie que le slug de la catégorie correspond avec celui passer en paramètre sinon on redirige vers la bonne url 
if($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

$title = "Catégorie {$category->getName()}";

//paramètre pour la pagination pour les articles par catégorie
$paginatedQuery = new PaginatedQuery(
  "SELECT p.* 
      FROM post p
      JOIN post_category pc ON pc.post_id = p.id
      WHERE pc.category_id = {$category->getId()}
      ORDER BY created_at DESC",
    "SELECT COUNT(category_id) FROM post_category WHERE category_id =  {$category->getId()}",
);
/** @var Post[] */
$posts = $paginatedQuery->getItems(Post::class);
$link = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
?>

<h1>Catégorie <?= e($title) ?></h1>

<!--début contenu-->
<div class="row">
    <?php foreach($posts as $post):?>
      <div class="col-md-3">
        <?php require dirname(__DIR__) . '/post/card.php' ?>
      </div>
    <?php endforeach;?>
</div>
<!--fin contenu-->


<!--début pagination-->
<div class="d-flex justify-content-between my-4">
      <?= $paginatedQuery->previousLink($link) ?>
      <?= $paginatedQuery->nextLink($link) ?>
</div>
<!--fin pagination-->
