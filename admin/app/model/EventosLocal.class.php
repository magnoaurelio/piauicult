<?php
/**
 * EventosLocal Active Record
 * @author  <your-name-here>
 */
class EventosLocal extends TRecord
{
    const TABLENAME = 'eventos_local';
    const PRIMARYKEY= 'loccodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('locnome');
        parent::addAttribute('locendereco');
        parent::addAttribute('locbairro');
        parent::addAttribute('loccep');
        parent::addAttribute('loccomplemento');
        parent::addAttribute('locimagem1');
        parent::addAttribute('locimagem2');
        parent::addAttribute('locimagem3');
        parent::addAttribute('locimagem4');
        parent::addAttribute('locimagem5');
        parent::addAttribute('locimagem6');
        parent::addAttribute('locfone');
        parent::addAttribute('loccelular');
        parent::addAttribute('locresponsavel');
        parent::addAttribute('locfoto');
        parent::addAttribute('loccordenadas');
        parent::addAttribute('loccidade');
        parent::addAttribute('locsobre');
        
    }


}
