<?php

use App\Connection;

/**
 * Fichier permettant de remplir la base de donnée de fausse info avec faker
 */
require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

//connection à la base de donnée
$pdo = Connection::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

for ($i = 0; $i < 50; $i++){
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', slug='{$faker->slug}', created_at='{$faker->iso8601}', content='{$faker->paragraphs(rand(3, 15), true)}'");
    $posts[] = $pdo->lastInsertId();
}

for ($i = 0; $i < 5; $i++){
    $pdo->exec("INSERT INTO category SET name='{$faker->sentence(2)}', slug='{$faker->slug}'");
    $categories[] = $pdo->lastInsertId();
}

foreach($posts as $post){
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach($randomCategories as $category){
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

$password = password_hash('admin', PASSWORD_ARGON2I);
$pdo->exec("INSERT INTO user SET username='admin', password='$password'");
