<?php
/**
 * PrefeituraDados Active Record
 * @author  <your-name-here>
 */
class PrefeituraDados extends TRecord
{
    const TABLENAME = 'prefeitura_dados';
    const PRIMARYKEY= 'codigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('prehistoria');
        parent::addAttribute('preperfil');
        parent::addAttribute('prehino');
        parent::addAttribute('previsaogeral');
        parent::addAttribute('unidadeGestora');
    }



}
