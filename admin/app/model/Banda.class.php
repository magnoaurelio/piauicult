<?php
/**
 * Banda Active Record
 * @author  <your-name-here>
 */
class Banda extends TRecord
{
    const TABLENAME = 'banda';
    const PRIMARYKEY= 'bancodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('bannome');
        parent::addAttribute('bancep');
        parent::addAttribute('banendereco');
        parent::addAttribute('banbairro');
        parent::addAttribute('bannumero');
        parent::addAttribute('bancontato');
        parent::addAttribute('banemail');
        parent::addAttribute('banresponsavel');
        parent::addAttribute('banmusicos');
        parent::addAttribute('banfoto1');
        parent::addAttribute('banfoto2');
        parent::addAttribute('banfoto3');
        parent::addAttribute('banfoto4');
        parent::addAttribute('banfoto5');
        parent::addAttribute('bandetalhe');
        parent::addAttribute('bancidade');
        parent::addAttribute('banuf');
        parent::addAttribute('bantipocodigo');
    }
     function get_artista(){
        return new Artista($this->artcodigo);
    }

    function get_tipo(){
        return new BandaTipo($this->bantipocodigo);
    }

}
