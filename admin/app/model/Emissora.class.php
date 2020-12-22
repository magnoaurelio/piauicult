<?php
/**
 * Emissora Active Record
 * @author  <your-name-here>
 */
class Emissora extends TRecord
{
    const TABLENAME = 'emissora';
    const PRIMARYKEY= 'emicodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('eminome');
        parent::addAttribute('emifoto');
        parent::addAttribute('emiendereco');
        parent::addAttribute('emibairro');
        parent::addAttribute('emicep');
        parent::addAttribute('emicontato');
        parent::addAttribute('emiemail');
        parent::addAttribute('emicidade');
        parent::addAttribute('emiestado');
        parent::addAttribute('emioperador');
        parent::addAttribute('emisobre');
        parent::addAttribute('emisite');
        parent::addAttribute('emilocal');
        parent::addAttribute('emiimagem');
        parent::addAttribute('emifacebook');
        parent::addAttribute('emiwhatsapp');
        parent::addAttribute('emitwitter');
        parent::addAttribute('emiyuotube');
        parent::addAttribute('emiinstagram');
        parent::addAttribute('emivivo');
    }
    
    
    
    function get_Cidade(){
      return getPrefeituras($this->emicidade);    
    }


}
