<?php
/**
 * MusicaDisco Active Record
 * @author  <your-name-here>
 */
class MusicaDisco extends TRecord
{
    const TABLENAME = 'musica_disco';
    const PRIMARYKEY= 'mdcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('discodigo');
        parent::addAttribute('muscodigo');
    }


}
