<?php
/**
 * EventoArtista Active Record
 * @author  <your-name-here>
 */
class EventoArtista extends TRecord
{
    const TABLENAME = 'evento_artista';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cod_evento');
        parent::addAttribute('cod_artista');
    }


}
