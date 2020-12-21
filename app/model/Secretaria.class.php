<?php

/**
 * Secretaria Active Record
 * @author  <your-name-here>
 */
class Secretaria extends \Adianti\Database\TRecord implements Direcionavel
{
    const TABLENAME = 'secretaria';
    const PRIMARYKEY = 'prenumero';
    const IDPOLICY = 'max'; // {max, serial}


    private $unidades;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('presec');
        parent::addAttribute('precodigo');
	parent::addAttribute('seccodigo');
        parent::addAttribute('prenome');
        parent::addAttribute('sectipocodigo');
        parent::addAttribute('secnome');
        parent::addAttribute('secimagem');
	parent::addAttribute('secfoto');
        parent::addAttribute('secfotor');
        parent::addAttribute('secendereco');
        parent::addAttribute('secbairro');
        parent::addAttribute('secfone');
        parent::addAttribute('secemail');
        parent::addAttribute('secsecretario');
        parent::addAttribute('secusual');
        parent::addAttribute('secicon');
        parent::addAttribute('secsexo');
        parent::addAttribute('descricao');
        parent::addAttribute('unidadeGestora');
        parent::addAttribute('sectipo');
        parent::addAttribute('secsite');
    }


    /**
     * Method addUnidade
     * Add a Unidade to the Secretaria
     * @param $object Instance of Unidade
     */

      public function getSecretariaTipo()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('secretaria_tipo', '=', $this->secretaria_tipo));
        return Secretaria::getObjects( $criteria );
    }
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

    public function addUnidade(Unidade $object)
    {
        $this->unidades[] = $object;
    }

    /**
     * Method getUnidades
     * Return the Secretaria' Unidade's
     * @return Collection of Unidade
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * Reset aggregates
     */
    public function clearParts()
    {
        $this->unidades = array();
    }

    /**
     * Load the object and its aggregates
     * @param $id object ID
     */
    public function load($id)
    {

        // load the related Unidade objects
        $repository = new TRepository('Unidade');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('unisec', '=', $id));
        $this->unidades = $repository->load($criteria);

        // load the object itself
        return parent::load($id);
    }


    function  get_unidades(){
        $repository = new TRepository('Unidade');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('unisec', '=', $this->prenumero));
        return $this->unidades = $repository->load($criteria);
    }

    /**
     * Store the object and its aggregates
     */
    public function store()
    {
        // store the object itself
        parent::store();

        // delete the related Unidade objects
        $criteria = new TCriteria;
        $criteria->add(new TFilter('unisec', '=', $this->id));
        $repository = new TRepository('Unidade');
        $repository->delete($criteria);
        // store the related Unidade objects
        if ($this->unidades) {
            foreach ($this->unidades as $unidade) {
                unset($unidade->id);
                $unidade->secretaria_id = $this->id;
                $unidade->store();
            }
        }
    }

    
    /**
     * Delete the object and its aggregates
     * @param $id object ID
     */
    public function delete($id = NULL)
    {
        $id = isset($id) ? $id : $this->id;
        // delete the related Unidade objects
        $repository = new TRepository('Unidade');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('unisec', '=', $id));
        $repository->delete($criteria);


        // delete the object itself
        parent::delete($id);
    }


    public function getDiretorio()
    {
        $path = 'files/prefeituras/' . $this->unidadeGestora . '/secretaria/';
        if (!file_exists($path)) {
            mkdir($path, 755, true);
        }
        return $path;
    }


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
//    }
}
