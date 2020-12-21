<?php
/**
 * MusicoInstrumento Active Record
 * @author  <your-name-here>
 */
class MusicoInstrumento extends TRecord
{
    const TABLENAME = 'musico_instrumento';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cod_musica');
        parent::addAttribute('cod_musico');
        parent::addAttribute('cod_instrumento');
    }


}
