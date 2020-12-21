<?php
/**
 * Instrumento Active Record
 * @author  <your-name-here>
 */
class Instrumento extends TRecord
{
    const TABLENAME = 'instrumento';
    const PRIMARYKEY= 'inscodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    


    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('insnome');
        parent::addAttribute('insassessorio1');
        parent::addAttribute('insassessorio2');
        parent::addAttribute('insassessorio3');
        parent::addAttribute('insquant');
        parent::addAttribute('insfoto');
        parent::addAttribute('inshistorico');
    }


}
