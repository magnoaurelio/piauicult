<?php
/**
 * Cliente Active Record
 * @author  <your-name-here>
 */
class Cliente extends TRecord
{
    const TABLENAME = 'cliente';
    const PRIMARYKEY= 'clicodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $artista;
    private $disco;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('discodigo');
        parent::addAttribute('artcodigo');
        parent::addAttribute('clinome');
        parent::addAttribute('cliusual');
        parent::addAttribute('cliendereco');
        parent::addAttribute('clibairro');
        parent::addAttribute('clicep');
        parent::addAttribute('clifone');
        parent::addAttribute('clicelular');
        parent::addAttribute('cliemail');
        parent::addAttribute('clisite');
        parent::addAttribute('clidata');
        parent::addAttribute('clidatacompra');
        parent::addAttribute('clisobre');
        parent::addAttribute('cliquantidade');
        parent::addAttribute('clivalor');
        parent::addAttribute('clifoto');
        parent::addAttribute('cliimagem');
        parent::addAttribute('cliuf');
        parent::addAttribute('clisexo');
        parent::addAttribute('clicor');
        parent::addAttribute('clitamanho');
        parent::addAttribute('cliprocodigo');
        parent::addAttribute('clilote');
    }

    
    /**
     * Method set_artista
     * Sample of usage: $cliente->artista = $object;
     * @param $object Instance of Artista
     */
    public function set_artista(Artista $object)
    {
        $this->artista = $object;
        $this->artista_id = $object->id;
    }
    
    /**
     * Method get_artista
     * Sample of usage: $cliente->artista->attribute;
     * @returns Artista instance
     */
    public function get_artista()
    {
        // loads the associated object
        if (empty($this->artista))
            $this->artista = new Artista($this->artista_id);
    
        // returns the associated object
        return $this->artista;
    }
    
    
    /**
     * Method set_disco
     * Sample of usage: $cliente->disco = $object;
     * @param $object Instance of Disco
     */
    public function set_disco(Disco $object)
    {
        $this->disco = $object;
        $this->disco_id = $object->id;
    }
    
    /**
     * Method get_disco
     * Sample of usage: $cliente->disco->attribute;
     * @returns Disco instance
     */
    public function get_disco()
    {
        // loads the associated object
        if (empty($this->disco))
            $this->disco = new Disco($this->disco_id);
    
        // returns the associated object
        return $this->disco;
    }
    
    public function get_tipoProduto()
    {
       return new ClienteProduto($this->cliprocodigo);
    }
    
      public function get_Responsavel()
    {
    // new Artista($this->artcodigo);
      $artista =  new Artista($this->artcodigo);
      return $artista? $artista : new Artista();
    }
    


}
