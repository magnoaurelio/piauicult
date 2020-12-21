<?php
/**
 * Customer Active Record
 * @author  <your-name-here>
 */
class Festival_Premio extends TRecord
{
    const TABLENAME = 'festival_premio';
    const PRIMARYKEY= 'fesprecodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
     public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id);
        parent::addAttribute('fesprecodigo');
        parent::addAttribute('fesprenome');
        parent::addAttribute('fesprefoto');
       
    }
}
