<?php
/**
 * Customer Active Record
 * @author  <your-name-here>
 */
class Festival_tipo extends TRecord
{
    const TABLENAME = 'festival_tipo';
    const PRIMARYKEY= 'festipocodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
     public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id);
        parent::addAttribute('festipocodigo');
        parent::addAttribute('festiponome');
        parent::addAttribute('festipofoto');
       
    }
}
