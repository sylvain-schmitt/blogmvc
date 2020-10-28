<?php
namespace App;

use PDO;


/**
 * classe static renvoyant une nouvelle instance de la connection à la base de donnée 
 */
class Connection {

    public static function getPDO (): PDO 
    {

        return new PDO('mysql:dbname=blogmvc;host=127.0.0.1', 'root', '',[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
    }
}