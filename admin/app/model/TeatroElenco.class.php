<?php
/**
 * TeatroElenco Active Record
 * @author  <your-name-here>
 */
class TeatroElenco extends TRecord
{
    const TABLENAME = 'teatro_elenco';
    const PRIMARYKEY= 'teaelecodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('artcodigo');
        parent::addAttribute('tipocodigo');
        parent::addAttribute('cincodigo');
        parent::addAttribute('teaelefoto');
    }


}
