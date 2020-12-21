<?php
/**
 * CinemaGenero Active Record
 * @author  <your-name-here>
 */
class CinemaGenero extends TRecord
{
    const TABLENAME = 'cinema_genero';
    const PRIMARYKEY= 'codigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('cingenfoto');
    }


}
