<?php
/**
 * CinemaElenco Active Record
 * @author  <your-name-here>
 */
class CinemaElenco extends TRecord
{
    const TABLENAME = 'cinema_elenco';
    const PRIMARYKEY= 'codigo';
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
    }

    function get_artista(){
        return new Artista($this->artcodigo);
    }


    function get_tipo(){
        return new ArtistaTipo($this->tipocodigo);
    }

    function get_cinema(){
        return new Cinema($this->cincodigo);
    }

}
