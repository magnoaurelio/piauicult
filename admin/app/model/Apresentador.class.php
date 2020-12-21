<?php
/**
 * Apresentador Active Record
 * @author  <your-name-here>
 */
class Apresentador extends TRecord
{
    const TABLENAME = 'apresentador';
    const PRIMARYKEY= 'aprcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('aprnome');
        parent::addAttribute('aprfoto');
        parent::addAttribute('apremissora');
        parent::addAttribute('aprcontato');
        parent::addAttribute('apremail');
        parent::addAttribute('aprfuncao');
    }
    
    
    function get_Emissora(){
      return new Emissora($this->apremissora);
    }

}
