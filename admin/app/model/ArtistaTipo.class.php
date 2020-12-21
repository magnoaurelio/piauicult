<?php
/**
 * ArtistaTipo Active Record
 * @author  <your-name-here>
 */
class ArtistaTipo extends TRecord
{
    const TABLENAME = 'artista_tipo';
    const PRIMARYKEY= 'arttipocodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('arttiponome');
        parent::addAttribute('arttipofoto');
    }


}
