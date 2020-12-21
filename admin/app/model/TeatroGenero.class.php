<?php
/**
 * TeatroGenero Active Record
 * @author  <your-name-here>
 */
class TeatroGenero extends TRecord
{
    const TABLENAME = 'teatro_genero';
    const PRIMARYKEY= 'teagencodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('teagennome');
        parent::addAttribute('teagenfoto');
    }


}
