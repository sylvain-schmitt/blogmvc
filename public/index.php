<?php
/**
 * point d'entré de l'application (routeur)
 */
require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


//si numéro de page = 1 on redirige sur 'home'
if (isset($_GET['page']) && $_GET['page'] === '1') {
    //reécrire l'url sans le param '?page'
    $url = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($_GET);
    $url = $url . (empty($query) ? '' : '?' . $query);
    header('Location: ' . $url);
    http_response_code(301);
    exit();
}

//instance de la classe router pour redirigé l'utilisateur vers la bonne vue
$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/admin', 'admin/post/index', 'admin_posts')
    ->match('/admin/post/[i:id]', 'admin/post/edit', 'admin_post')
    ->post('/admin/post/[i:id]/delete', 'admin/post/delete', 'admin_post_delete')
    ->get('/admin/post/new', 'admin/post/new', 'admin_post-new')
    ->run();

