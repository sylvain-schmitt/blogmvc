<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

//on fait une requète préparer pour récupérer un article en fonction de son ID
$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

//on vérifie que le slug de l'article correspond avec celui passer en paramètre sinon on redirige vers la bonne url 
if($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}
$title = $post->getName();
?>

<h1 class="card-title"><?= e ($post->getName()) ?></h1>
     <p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d F Y à h:i') ?></p>
<?php foreach($post->getCategories() as $k => $category):
                if ($k > 0):
                    echo', ';
                endif;
                $category_url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]) ?>
                <a href="<?= $category_url ?> "><?= e($category->getName()) ?></a><?php
endforeach?>     
     <p><?= $post->getFormattedContent() ?></p>