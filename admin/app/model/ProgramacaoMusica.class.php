<?php
/**
 * ProgramacaoMusica Active Record
 * @author  <your-name-here>
 */
class ProgramacaoMusica extends TRecord
{
    const TABLENAME = 'programacao_musica';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('muscodigo');
        parent::addAttribute('procodigo');
    }


}
