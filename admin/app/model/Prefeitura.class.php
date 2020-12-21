<?php

//<fileHeader>
 /** @author  <Marcelo Alves - PC >*/
//</fileHeader>

class Prefeitura extends TRecord
{
    const TABLENAME  = 'prefeitura';
    const PRIMARYKEY = 'precodigo';
    const IDPOLICY   =  'max'; // {max, serial}
    
    
    
    //<classProperties>
  
    //</classProperties>
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('prenome');
        parent::addAttribute('prenomep');
        parent::addAttribute('prenomeu');
        parent::addAttribute('precidade');
        parent::addAttribute('prefoto');
        parent::addAttribute('prehorario');
        parent::addAttribute('preslogan');
        parent::addAttribute('preendereco');
        parent::addAttribute('precep');
        parent::addAttribute('prebairro');
        parent::addAttribute('preemail');
        parent::addAttribute('presite');
        parent::addAttribute('precnpj');
        parent::addAttribute('preimagem');
        parent::addAttribute('prelogo');
        parent::addAttribute('prebrasao');
        parent::addAttribute('prebandeira');
        parent::addAttribute('preddd');
        parent::addAttribute('prefone');
        parent::addAttribute('predata');
        //<onAfterConstruct>
  
        //</onAfterConstruct>
    }

    
    /**
     * Method getSecretarias
     */
    public function getSecretarias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('prefeitura_id', '=', $this->precodigo));
        return Secretaria::getObjects( $criteria );
    }
    
    //<userCustomFunctions>
  
    //</userCustomFunctions>

    /**
     * @return \UnidadeGestora
     */

    public function getDiretorio()
    {
        $path = 'files/prefeituras/' . $this->codigoUnidGestora . '/';
     //   $path = 'files/prefeituras/' . $this->codigoUnidGestora . '/';
        if (!file_exists($path)) {
            mkdir($path, 755, true);
        }
        return $path;
    }

    public function get_Brasao()
    {
        $file = $this->getDiretorio() . $this->prebrasao;
        if (is_file($file)) {
            return $file;
        }
        return PATH_IMG_PADRAO . 'brasao.png';
    }
    public function get_Secfotor()
    {
        $file = $this->getDiretorio() . $this->secfotor;
        if (is_file($file)) {
            return $file;
        }
        return PATH_IMG_PADRAO . 'user.png';
    }

    public function get_Logo()
    {
        $file = $this->getDiretorio() . $this->prelogo;
        if (is_file($file)) {
            return $file;
        }
        return PATH_IMG_PADRAO . 'brasao.png';
    }

    public function get_Bandeira()
    {
        $file = $this->getDiretorio() . $this->prebandeira;
        if (is_file($file)) {
            return $file;
        }
        return PATH_IMG_PADRAO . 'piaui.gif';
    }

    

    public static function getPrefeitura($unidadeGestora)
    {
        $repo = new \Adianti\Database\TRepository('Prefeitura');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("codigoUnidGestora", '=', $unidadeGestora));
        $prefeitura = $repo->load($criteria);
        return $prefeitura ? $prefeitura[0] : new Prefeitura();
    }



}
