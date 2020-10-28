<?php
//fichier foure tous pour fonction utilitaire 

/**
 * fonction qui Convertit tous les caractères éligibles en entités HTML
 * @param string $string
 * @return void
 */
 function e (string $string) {
    return htmlentities($string);
}