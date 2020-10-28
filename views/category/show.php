<?php

use App\URL;
use App\Connection;
use App\Model\Post;
use App\Model\Category;

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

/**
 * requète sur la table 'post' pour récupérer les articles de la catégorie concèrnée et les positionné 12 par page
 */
$currentPage = URL::getPositiveInt('page', 1);
$count = (int)$pdo
    ->query('SELECT COUNT(category_id) FROM post_category WHERE category_id = ' . $category->getId())
    ->fetch(PDO::FETCH_NUM)[0];
$perPage = 12;
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
  throw new Exception('Cette page n\'existe pas');
}
$offset = $perPage * ($currentPage - 1);
$query = $pdo->query("
SELECT p.* 
FROM post p
JOIN post_category pc ON pc.post_id = p.id
WHERE pc.category_id = {$category->getId()}
ORDER BY created_at DESC 
LIMIT  $perPage OFFSET $offset
");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
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
      <?php if($currentPage > 1): ?>
        <?php
        $l = $link;
        if($currentPage > 2) $l = $link .  '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $l ?>"class ="btn btn-primary" > &laquo; Page précédente</a>
      <?php endif ?>
      <?php if($currentPage < $pages): ?>
        <a href="<?= $link ?>?page=<?=$currentPage + 1 ?>"class ="btn btn-primary ml-auto" >  Page suivante &raquo;</a>
      <?php endif ?>
</div>
<!--fin pagination-->
