<?php
/**
 * LiteraturaCategoria Active Record
 * @author  <your-name-here>
 */
class LiteraturaCategoria extends TRecord
{
    const TABLENAME = 'literatura_categoria';
    const PRIMARYKEY= 'litcatcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('litcatnome');
        parent::addAttribute('litcatfoto');
    }


}
