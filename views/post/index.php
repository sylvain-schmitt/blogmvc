<?php
use App\Helpers\Text;
use App\URL;
use App\Connection;
use App\Model\Post;
use App\PaginatedQuery;

//variable pour geré le titre par page
$title ='Mon Blog';

//nouvelle instance de connection à la base de donnée
$pdo = Connection::getPDO();

//paramètre pour la pagination de tous les articles
$paginatedQuery = new PaginatedQuery(
    "SELECT * FROM post ORDER BY created_at DESC",
    "SELECT COUNT(id) FROM post",
);
/** @var Post[] */
$posts = $paginatedQuery->getItems(Post::class);
$link = $router->url('home');
?>

<h1>Bienvenue sur mon blog</h1>

<!--début contenu-->
<div class="row">
    <?php foreach($posts as $post):?>
      <div class="col-md-3">
        <?php require 'card.php' ?>
      </div>
    <?php endforeach;?>
</div>
<!--fin contenu-->


<!--début pagination-->
<div class="d-flex justify-content-between my-4">
      <?= $paginatedQuery->previousLink($link);?>
      <?= $paginatedQuery->nextLink($link);?>
</div>
<!--fin pagination-->
