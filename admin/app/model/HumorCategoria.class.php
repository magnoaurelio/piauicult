<?php
/**
 * HumorCategoria Active Record
 * @author  <your-name-here>
 */
class HumorCategoria extends TRecord
{
    const TABLENAME = 'humor_categoria';
    const PRIMARYKEY= 'codigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('humcatfoto');
    }
}
