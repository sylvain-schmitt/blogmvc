<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();
$title = 'Administration';
$pdo = Connection::getPDO();
[$posts, $pagination] = (new PostTable($pdo))->FindPaginated();
$link = $router->url('admin_posts');
?>

<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enregistrement à bien été supprimé
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>

<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>Actions</th>
    </thead>
    <tbody>
       <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= $post->getId() ?></td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>">
                    <?= e($post->getName()) ?>
                </a>
            </td>
            <td>
                <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>" class= "btn btn-primary" >
                    Editer
                </a>
                <form action="<?= $router->url('admin_post_delete', ['id' => $post->getId()]) ?>" method="POST" style="display: inline;"
                    onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')">
                    <button class="btn btn-danger" type="submit" >supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<!--début pagination-->
<div class="d-flex justify-content-between my-4">
      <?= $pagination->previousLink($link);?>
      <?= $pagination->nextLink($link);?>
</div>
<!--fin pagination-->
<script>
    $('.alert').alert()
</script>