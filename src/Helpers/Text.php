<?php
namespace App\Helpers;


/**
 * classe permettant de formater du text 
 */
class Text {

    /**
     * fonction qui coupe un paragraphe avec une limite de 60 caractère
     * @param string $content
     * @param integer $limit
     * @return void
     */
    public static function excerpt(string $content, int $limit = 60)
    {
        if(mb_strlen($content) <= $limit){
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . ' ...';
    }
}