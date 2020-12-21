<?php
/**
 * FestivalArtista Active Record
 * @author  <your-name-here>
 */
class FestivalArtista extends TRecord
{
    const TABLENAME = 'festival_artista';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id_festival');
        parent::addAttribute('id_artista');
    }


}
