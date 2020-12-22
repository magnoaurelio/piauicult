<?php
/**
 * Programacao Active Record
 * @author  <your-name-here>
 */
class Programacao extends TRecord
{
    const TABLENAME = 'programacao';
    const PRIMARYKEY= 'procodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    private $musicas;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pronome');
        parent::addAttribute('prohorario');
        parent::addAttribute('emicodigo');
        parent::addAttribute('dataplay');
        parent::addAttribute('aprcodigo');
        parent::addAttribute('detalhe');
    }

    
    /**
     * Method addMusica
     * Add a Musica to the Programacao
     * @param $object Instance of Musica
     */
    public function addMusica(Musica $object)
    {
        $this->musicas[] = $object;
    }
    
    /**
     * Method getMusicas
     * Return the Programacao' Musica's
     * @return Collection of Musica
     */
    public function getMusicas()
    {
        return $this->musicas;
    }
    
    public function get_Emissora()
    {
        return new Emissora($this->emicodigo);
    }
    
    

    /**
     * Reset aggregates
     */
    public function clearParts()
    {
        $this->musicas = array();
    }

    /**
     * Load the object and its aggregates
     * @param $id object ID
     */
    public function load($id)
    {
    
        // load the related Musica objects
        $repository = new TRepository('ProgramacaoMusica');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('procodigo', '=', $id));
        $programacao_musicas = $repository->load($criteria);
        if ($programacao_musicas)
        {
            foreach ($programacao_musicas as $programacao_musica)
            {
                $musica = new Musica( $programacao_musica->muscodigo );
                $this->addMusica($musica);
            }
        }
    
        // load the object itself
        return parent::load($id);
    }

    /**
     * Store the object and its aggregates
     */
    public function store()
    {
        // store the object itself
        parent::store();
    
        // delete the related ProgramacaoMusica objects
        $criteria = new TCriteria;
        $criteria->add(new TFilter('procodigo', '=', $this->procodigo));
        $repository = new TRepository('ProgramacaoMusica');
        $repository->delete($criteria);
        // store the related ProgramacaoMusica objects
        if ($this->musicas)
        {
            foreach ($this->musicas as $musica)
            {
                $programacao_musica = new ProgramacaoMusica;
                $programacao_musica->muscodigo = $musica->muscodigo;
                $programacao_musica->procodigo = $this->procodigo;
                $programacao_musica->store();
            }
        }
    }

    /**
     * Delete the object and its aggregates
     * @param $id object ID
     */
    public function delete($id = NULL)
    {
        $id = isset($id) ? $id : $this->procodigo;
        // delete the related ProgramacaoMusica objects
        $repository = new TRepository('ProgramacaoMusica');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('procodigo', '=', $id));
        $repository->delete($criteria);
        
    
        // delete the object itself
        parent::delete($id);
    }
    
    function get_Apresentador(){
      return new Apresentador($this->aprcodigo);    
    }
    
    


}
