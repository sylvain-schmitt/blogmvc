<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

//on fait une requète préparer pour récupérer les articles appartenant à une catégorie
$pdo = Connection::getPDO();
$category =  (new CategoryTable($pdo))->find($id);



//on vérifie que le slug de la catégorie correspond avec celui passer en paramètre sinon on redirige vers la bonne url 
if($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

$title = "Catégorie: {$category->getName()}";
[$posts, $paginatedQuery] = (new PostTable($pdo))->FindPaginatedForCategory($category->getId());
$link = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
?>

<h1><?= e($title) ?></h1>

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
