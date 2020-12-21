<?php
/**
 * Projeto Active Record
 * @author  <your-name-here>
 */
class Projeto extends TRecord
{
    const TABLENAME = 'projeto';
    const PRIMARYKEY= 'procodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pronome');
        parent::addAttribute('proendereco');
        parent::addAttribute('probairro');
        parent::addAttribute('procep');
        parent::addAttribute('procomplemento');
        parent::addAttribute('proimagem');
        parent::addAttribute('prologo');
        parent::addAttribute('profone');
        parent::addAttribute('procelular');
        parent::addAttribute('proresponsavel');
        parent::addAttribute('profoto');
        parent::addAttribute('procordenadas');
        parent::addAttribute('prosobre');
        parent::addAttribute('procidade');
        parent::addAttribute('proesfera');
        parent::addAttribute('proorgao');
       
    }


}
