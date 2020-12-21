<?php

/**
 * Prefeitura Active Record
 * @author  <Marcelo Alves - PC >
 */
class Prefeitura extends TRecord implements Direcionavel
{
    const TABLENAME = 'prefeitura';
    const PRIMARYKEY = 'precodigo';
    const IDPOLICY = 'max'; // {max, serial}
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('preorgao');
        parent::addAttribute('prenome');
        parent::addAttribute('preslogan');
        parent::addAttribute('prehorario');
        parent::addAttribute('prepopulacao');
        parent::addAttribute('preeleitor');
        parent::addAttribute('precidade');
        parent::addAttribute('preibge');
        parent::addAttribute('codigoUnidGestora');
        parent::addAttribute('premapa');
        parent::addAttribute('preclima');
        parent::addAttribute('historico');
        parent::addAttribute('prehino');
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
        parent::addAttribute('prefax');
        parent::addAttribute('prefoto');
        parent::addAttribute('pretema');
        parent::addAttribute('padcodigo');
        parent::addAttribute('preampar');
        parent::addAttribute('precoegemas');
        parent::addAttribute('preundime');
        parent::addAttribute('precosems');
        parent::addAttribute('prepiaui');
        parent::addAttribute('preconsorcio');
        parent::addAttribute('prech');
        parent::addAttribute('concheque');
        parent::addAttribute('preiptu');
        parent::addAttribute('prelicenca');
        parent::addAttribute('preamparlogo');
        parent::addAttribute('predata');
    }
   
    /**
     * @return \UnidadeGestora
     */

    public function get_UnidadeGestora()
    {
        return new UnidadeGestora($this->codigoUnidGestora);
    }

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

    public static function seedPrefeitura()
    {
        $prefeitura = new Prefeitura();
        $prefeitura->pretema = "default";
        $prefeitura->codigoUnidGestora = \Adianti\Registry\TSession::getValue('codigoUnidGestora');
        return $prefeitura;
    }

    public static function getPrefeitura($unidadeGestora)
    {
        $repo = new \Adianti\Database\TRepository('Prefeitura');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("codigoUnidGestora", '=', $unidadeGestora));
        $prefeitura = $repo->load($criteria);
        return $prefeitura ? $prefeitura[0] : new Prefeitura();
    }


    public function getDados()
    {
        $repo = new \Adianti\Database\TRepository('PrefeituraDados');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        $dados = $repo->load($criteria);
        return $dados ? $dados[0] : new PrefeituraDados();
    }

    public function getSecretarias()
    {
        $repo = new \Adianti\Database\TRepository('Secretaria');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    /** @VER <IMPORTANE> 
    public function getPublicidade()
    {
        $repo = new \Adianti\Database\TRepository('Publicidade');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    */
   
    public function getIgrejas()
    {
        $repo = new \Adianti\Database\TRepository('Igreja');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    
    public function getEsportes()
    {
        $repo = new \Adianti\Database\TRepository('Esportes');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    
    public function getCombustivel()
    {
        $repo = new \Adianti\Database\TRepository('Combustivel');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    public function getTransporte()
    {
        $repo = new \Adianti\Database\TRepository('Transportes');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    public function getAlimento()
    {
        $repo = new \Adianti\Database\TRepository('Alimentos');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    
    public function getPonto()
    {
        $repo = new \Adianti\Database\TRepository('Pontos');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    public function getPovoado()
    {
        $repo = new \Adianti\Database\TRepository('Povoado');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    
    public function getBancoSite()
    {
        $repo = new \Adianti\Database\TRepository('Bancos');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }


    public function getHotelarias()
    {
        $repo = new \Adianti\Database\TRepository('Hotelaria');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
    
    public function getGaleria()
    {
        $repo = new \Adianti\Database\TRepository('Galeria');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }
	
	
	public function getBancarios()
    {
        $repo = new \Adianti\Database\TRepository('Bancario');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        return $repo->load($criteria);
    }


    public function getNoticias($limit = 100)
    {
        $repo = new \Adianti\Database\TRepository('Noticia');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        $param['order'] = 'notcodigo';
        $param['direction'] = 'desc';
        $criteria->setProperties($param); // order, offset
        $criteria->setProperty('limit', $limit);
        return $repo->load($criteria);
    }
    
     

    public function getVideos($limit = 100)
    {
        $repo = new \Adianti\Database\TRepository('Videos');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        $criteria->add(new \Adianti\Database\TFilter("videstado", '=', 1));
        $param['order'] = 'viddata';
        $param['direction'] = 'desc';
        $criteria->setProperties($param); // order, offset
        $criteria->setProperty('limit', $limit);
        return $repo->load($criteria);
    }

    public function getLinks($limit = 100)
    {
        $repo = new \Adianti\Database\TRepository('Links');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora), \Adianti\Database\TExpression::OR_OPERATOR);
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', "geral"), \Adianti\Database\TExpression::OR_OPERATOR);
        $param['order'] = 'lincodigo';
        $param['direction'] = 'asc';
        $criteria->setProperties($param); // order, offset
        $criteria->setProperty('limit', $limit);
        return $repo->load($criteria);
    }
    
     public function getGalerias($limit = 100)
    {
        $repo = new \Adianti\Database\TRepository('Galeria');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', $this->codigoUnidGestora));
        $criteria->add(new \Adianti\Database\TFilter("unidadeGestora", '=', "geral"), \Adianti\Database\TExpression::OR_OPERATOR);
        $param['order'] = 'galcodigo';
        $param['direction'] = 'desc';
        $criteria->setProperties($param); // order, offset
        $criteria->setProperty('limit', $limit);
        return $repo->load($criteria);
    }


    public function getPrefeitosVices()
    {
        $repo = new \Adianti\Database\TRepository('Prefeito');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter("precodigo", '=', $this->precodigo));
        return $repo->load($criteria);
    }

    /**
     * @param int $vice
     * @return Prefeito
     */
    public function getGestor($vice = 0)
    {
        $repo = new TRepository('Prefeito');
        $criteria = new TCriteria;
        $criteria->add(new TFilter("precodigo", "=", $this->precodigo));
        $criteria->add(new TFilter("preativo", "=", 1));
        $criteria->add(new TFilter("pretipo", "=", $vice));
        $prefs = $repo->load($criteria);
        return $prefs ? $prefs[0] : new Prefeito();
    }


}
