<!--card pour un article-->
 <div class="card mb-3">
 <div class="card-body">
     <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
     <p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d F Y ') ?></p>
     <p><?= $post->getExcerpt() ?></p>
     <p><a href="<?= $router->url('post', ['id' => $post->getID(), 'slug'=> $post->getSlug()]) ?>" class="btn btn-primary">Lire la suite</a></p>
 </div>
</div>