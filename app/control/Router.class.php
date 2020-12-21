<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descrição Router classe utilizada para direcionar para a pagina adequada 
 *
 * @author MAGNUSOFT-PC
 */
class Router {
    private static $pastas  =  [
      'templates/',
      'buscas/'
    ];
    
    private static $ispage = false;
    private static $filename = null;
    
    
    public static function setPage($pagina) {
        foreach (self::$pastas as $value) {
            self::$filename = $value.$pagina.'.php';
            if(file_exists(self::$filename)):
                include_once self::$filename;
                self::$ispage  = true;
                continue;
            endif;
        }  
        
        if(!self::$ispage):
            echo " <div style='margin-left:12%'><p class='alert alert-warning'><small><i>Não foi possível incluir o arquivo ".self::$filename."</i></small></p></div>";
            die('');
        endif;
    }
}
