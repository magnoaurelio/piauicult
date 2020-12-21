<?php
/**
 * Sobre Active Record
 * @author  <your-name-here>
 */
class Sobre extends TRecord
{
    const TABLENAME = 'sobre';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
    }


}
