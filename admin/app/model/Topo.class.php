<?php
/**
 * Topo Active Record
 * @author  <your-name-here>
 */
class Topo extends TRecord
{
    const TABLENAME = 'topo';
    const PRIMARYKEY= 'topcodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('toptitulo');
        parent::addAttribute('toptexto');
        parent::addAttribute('topimagem');
    }
    
    


}
