<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of API
 *
 * @author MAGNUSOFT-PC
 */
class API extends Conexao {
   
    /**
     *
     * @var PDO
     */
   private $Conn;
  
   public static function setCidade($precodigo){
       Sessao::setValue('setcidade', $precodigo);   
   }
}
