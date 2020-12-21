<?php

//<fileHeader>
  
//</fileHeader>

class SecretariaTipo extends TRecord
{
    const TABLENAME  = 'secretaria_tipo';
    const PRIMARYKEY = 'sectipocodigo';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    
    //<classProperties>
  
    //</classProperties>
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('sectiponome');
        parent::addAttribute('sectiposigla');
        parent::addAttribute('sectipousual');
        parent::addAttribute('sectipofoto');
        parent::addAttribute('sectipodescricao');
		parent::addAttribute('unidadeGestora');
        //<onAfterConstruct>
  
        //</onAfterConstruct>
    }
     public function getSecretariaTipo()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('secretaria_tipo', '=', $this->secretaria_tipo));
        return SecretariaTipo::getObjects( $criteria );
    }
    
    
    //<userCustomFunctions>
  
    //</userCustomFunctions>
}


