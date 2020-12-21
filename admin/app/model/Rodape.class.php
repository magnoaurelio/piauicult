<?php
/**
 * Rodape Active Record
 * @author  <your-name-here>
 */
class Rodape extends TRecord
{
    const TABLENAME = 'rodape';
    const PRIMARYKEY= 'rodcodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('rodtitulo');
        parent::addAttribute('rodtexto');
        parent::addAttribute('rodimagem');
    }


}
