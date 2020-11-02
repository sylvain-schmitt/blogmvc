<?php

use App\Connection;
use App\Table\PostTable;
use App\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;
$errors = [];

if(!empty($_POST)){
    Validator::lang('fr');
    $v = new PostValidator($_POST);

    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setSlug($_POST['slug'])
        ->setCreatedAt($_POST['created_at']);

    if($v->validate()){
        $postTable->update($post);
        $success = true;
    }else{
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
?>

<?php if($success): ?>
    <div class="alert alert-success">
        L'article à bien été modifié
    </div>
<?php endif ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'à pas pu être modifié, merci de corriger vos érreurs
    </div>
<?php endif ?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<form action="" method="POST">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    <button type="submit" class="btn btn-primary">Modifier</button>
</form>