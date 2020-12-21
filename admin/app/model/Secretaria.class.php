<?php

//<fileHeader>
  
//</fileHeader>

class Secretaria extends TRecord
{
    const TABLENAME  = 'secretaria';
    const PRIMARYKEY = 'seccodigo';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    private $prefeitura;
    
    //<classProperties>
  
    //</classProperties>
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('precodigo');
        parent::addAttribute('secnome');
        parent::addAttribute('secsecretario');
        parent::addAttribute('secusual');
        parent::addAttribute('secimagem');
        parent::addAttribute('secfoto');
        parent::addAttribute('secfotor');
        parent::addAttribute('sechorario');
        parent::addAttribute('secsexo');
        parent::addAttribute('secendereco');
        parent::addAttribute('secbairro');
        parent::addAttribute('secfone');
        parent::addAttribute('seccelular');
        parent::addAttribute('secemail');
        parent::addAttribute('secsobre');
        //<onAfterConstruct>
  
        //</onAfterConstruct>
    }

    /**
     * Method set_prefeitura
     * Sample of usage: $var->prefeitura = $object;
     * @param $object Instance of Prefeitura
     */
    public function set_prefeitura(Prefeitura $object)
    {
        $this->prefeitura = $object;
        $this->precodigo = $object->precodigo;
    }
    
    /**
     * Method get_prefeitura
     * Sample of usage: $var->prefeitura->attribute;
     * @returns Prefeitura instance
     */
    public function get_prefeitura()
    {
        
        // loads the associated object
        if (empty($this->prefeitura))
            $this->prefeitura = new Prefeitura($this->precodigo);
        
        // returns the associated object
        return $this->prefeitura;
    }
    

    /**
     * Method addUnidade
     * Add a Unidade to the Secretaria
     * @param $object Instance of Unidade
     

     
    function getFoto()
    {
        $file = $this->getDiretorio() . $this->secfotor;
        if (is_file($file)) {
            return $file;
        }
        return 'files/prefeituras/user.png';
    }
    
     function getImagem()
    {
        $file = $this->getDiretorio() . $this->secfoto;
        if (is_file($file)) {
            return $file;
        }
        return 'files/imagem/galeria.png';
    }

   


    /**
     * Reset aggregates
     */
   

    /**
   
    /**
     * Delete the object and its aggregates
     * @param $id object ID
   

    function toArray()
    {
        $dados =  parent::toArray();
        $dados["secfotor"] = $this->getFoto();
        $dados["secfoto"] = $this->getImagem();
        return $dados;
    }
//     public function getSecretariaTipo()
//    {
//        $repo = new \Adianti\Database\TRepository('SecretariaTipo');
//        $criteria = new \Adianti\Database\TCriteria();
//        $criteria->add(new \Adianti\Database\TFilter("sectipocodigo", '=', $this->sectipocodigo));
//        return $repo->load($criteria);
//    }*/
}
