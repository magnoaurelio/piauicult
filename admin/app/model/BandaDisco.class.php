<?php
/**
 * BandaDisco Active Record
 * @author  Marcelo Alves
 */
class BandaDisco extends \Adianti\Database\TRecord
{
    const TABLENAME = 'banda_disco';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('discodigo');
        parent::addAttribute('bancodigo');
    }


}
