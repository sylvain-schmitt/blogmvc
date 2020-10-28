<?php
use App\Helpers\Text;
use App\URL;
use App\Connection;
use App\Model\Post;

//variable pour geré le titre par page
$title ='Mon Blog';

//nouvelle instance de connection à la base de donnée
$pdo = Connection::getPDO();

$currentPage = URL::getPositiveInt('page', 1);

/**
 * requète sur la table 'post' pour récupérer les articles et les positionné 12 par page
 */
$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
$perPage = 12;
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
  throw new Exception('Cette page n\'existe pas');
}
$offset = $perPage * ($currentPage - 1);
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT  $perPage OFFSET $offset");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
?>

<h1>Bienvenu sur mon blog</h1>

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
      <?php if($currentPage > 1): ?>
        <?php
        $link = $router->url('home');
        if($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $link ?>"class ="btn btn-primary" > &laquo; Page précédente</a>
      <?php endif ?>
      <?php if($currentPage < $pages): ?>
        <a href="<?= $router->url('home')?>?page=<?=$currentPage + 1 ?>"class ="btn btn-primary ml-auto" >  Page suivante &raquo;</a>
      <?php endif ?>
</div>
<!--fin pagination-->
