<?php
/**
 * EventosTipo Active Record
 * @author  <your-name-here>
 */
class EventosTipo extends TRecord
{
    const TABLENAME = 'eventos_tipo';
    const PRIMARYKEY= 'evetipocodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('evetiponome');
    }


}
