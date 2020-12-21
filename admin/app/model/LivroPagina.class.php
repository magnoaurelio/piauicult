<?php
/**
 * LivroPagina Active Record
 * @author  <your-name-here>
 */
class LivroPagina extends \Adianti\Database\TRecord
{
    const TABLENAME = 'livro_pagina';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('livcodigo');
        parent::addAttribute('descricao');
        parent::addAttribute('arquivo');
        parent::addAttribute('numero');
        
        
    }
    
    
   function get_Livro(){
     return new Livro($this->livcodigo);
   }


}
