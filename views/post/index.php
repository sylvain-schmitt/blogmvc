<?php
use App\Connection;
use App\Table\PostTable;

//variable pour geré le titre par page
$title ='Mon Blog';

//nouvelle instance de connection à la base de donnée
$pdo = Connection::getPDO();

//recupère la liste des articles de façon paginé
$table = new PostTable($pdo);
[$posts, $pagination] = $table->FindPaginated();

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
      <?= $pagination->previousLink($link);?>
      <?= $pagination->nextLink($link);?>
</div>
<!--fin pagination-->
