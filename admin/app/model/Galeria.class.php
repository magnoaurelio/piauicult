<?php
/**
 * Galeria Active Record
 * @author  <your-name-here>
 */
class Galeria extends TRecord
{
    const TABLENAME = 'galeria';
    const PRIMARYKEY= 'galcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('galcaption');
        parent::addAttribute('galdata');
        parent::addAttribute('galartista');
        parent::addAttribute('galdisco');
        parent::addAttribute('galarquivo');
        
    }
    
   function get_Artista(){
        return new Artista($this->galartista);
    }
    
   function get_Disco(){
        return new Disco($this->galdisco);
    }

}
