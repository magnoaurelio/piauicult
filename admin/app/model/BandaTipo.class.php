<?php
/**
 * BandaTipo Active Record
 * @author  <your-name-here>
 */
class BandaTipo extends TRecord
{
    const TABLENAME = 'banda_tipo';
    const PRIMARYKEY= 'bantipocodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('bantiponome');
        parent::addAttribute('bantipofoto');
    }


}
