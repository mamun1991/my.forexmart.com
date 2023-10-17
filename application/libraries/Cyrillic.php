<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Cyrillic {
    /*do commit not change this library */
    function __construct(){

    }

    public static function register_page(){
          return '/[^a-zA-Z 0123456789 аБбвГгДдЕеЁёЖжЗзИиЙйКкЛлмнПптУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя !"#$%&()*+,\ :;?{}~@`
        ÇüéâäàåçêëèïîìæÆôöòûùÿ¢£¥ƒáíóúñÑ¿¬½¼¡«»¦ßµ±°•·²€„…†‡ˆ‰Š‹Œ‘’“”–—˜™š›œŸ¨©®¯³´¸¹¾ÀÁÂÃÄÅÈÉÊËÌÍÎÏÐÒÓÔÕÖ×ØÙÚÛÜÝÞãðõ÷øüýþ.-_\-\_]/i';
    }
    
     public static function onlyNunberAllow(){
          return '/[0123456789]/i';
    }
     public static function excetlenghtAllow($data,$max_equ=1){
          if(strlen($data)==$max_equ)
          {
              return true;
          }else{
              return false;
          }    
    }

}