<?php
/**
 * FestivalMusica Active Record
 * @author  <your-name-here>
 */
class FestivalMusica extends TRecord
{
    const TABLENAME = 'festival_musica';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id_festival');
        parent::addAttribute('id_musica');
    }


}
