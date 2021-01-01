<?php
/**
 * Genero Active Record
 * @author  <your-name-here>
 */
class Genero extends TRecord
{
    const TABLENAME = 'genero';
    const PRIMARYKEY= 'gencodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('gennome');
        parent::addAttribute('genorigem');
        parent::addAttribute('genano');          
        parent::addAttribute('geninstrumento');          
        parent::addAttribute('genimagem');          
        parent::addAttribute('inscodigo');          
        parent::addAttribute('artcodigo');          
    }
     
   
}
