<?php
$categories = [];
foreach($post->getCategories() as $k => $category) {
    $url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
    //syntaxe heredoc pour générer les liens html
    $categories[] = <<<HTML
    <a href="{$url}">{$category->getName()}</a>
HTML;
}
?>
<!--card pour un article-->
 <div class="card mb-3">
 <div class="card-body">
     <h5 class="card-title"><?= e ($post->getName()) ?></h5>
     <p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d F Y ') ?>
     <?php if (!empty($post->getCategories())): ?>
     ::
     <?= implode(', ', $categories) ?>
     <?php endif ?>
     </p>
     <p><?= $post->getExcerpt() ?></p>
     <p><a href="<?= $router->url('post', ['id' => $post->getID(), 'slug'=> $post->getSlug()]) ?>" class="btn btn-primary">Lire la suite</a></p>
 </div>
</div>