<?php
/**
 * Musica Active Record
 * @author  <your-name-here>
 */
class Musica extends TRecord
{
    const TABLENAME = 'musica';
    const PRIMARYKEY= 'muscodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $discos;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('musnome');
        parent::addAttribute('musregistro');
        parent::addAttribute('arttipocodigo');
        parent::addAttribute('bancodigo');
        parent::addAttribute('musduracao');
        parent::addAttribute('musdata');
        parent::addAttribute('musautor');
        parent::addAttribute('artcodigo');
        parent::addAttribute('gencodigo');
        parent::addAttribute('musfaixa');
        parent::addAttribute('musbanda');
        parent::addAttribute('musletra');
        parent::addAttribute('musaudio');
        parent::addAttribute('musarranjo');
        parent::addAttribute('mustocada');
        parent::addAttribute('musvideo');
        parent::addAttribute('musmusico');
        parent::addAttribute('mussobre');
        parent::addAttribute('musativo');
        parent::addAttribute('letativo');
        parent::addAttribute('vidativo');
        parent::addAttribute('livativo');
        parent::addAttribute('muslanca');
        parent::addAttribute('inscodigo');
    }
    
    
    
   function get_Compositor(){
  
         if(empty($this->musautor)){
               $artista =  new stdClass;
               $artista->artusual = "Indefinido";  
               $artista->artfoto = "user.png";  
         }else{
              $artista =  new Artista($this->musautor);
         }
     return   $artista;
   }
   
   function get_Interprete(){
  
         if(empty($this->artcodigo)){
               $artista =  new stdClass;
               $artista->artusual = "Indefinido";  
               $artista->artfoto = "user.png";  
         }else{
              $artista =  new Artista($this->artcodigo);
         }
     return   $artista;
   }
   
   
   function get_Disco(){
  
         if(empty($this->musbanda)){
               $disco =  new stdClass;
               $disco->disnome = "Indefinido";  
               $disco->disimagem = "user.png";  
         }else{
              $disco =  new Disco($this->musbanda);
         }
     return   $disco;
   }


    
    /**
     * Method addDisco
     * Add a Disco to the Musica
     * @param $object Instance of Disco
     */
    public function addDisco(Disco $object)
    {
        $this->discos[] = $object;
    }
    
    /**
     * Method getDiscos
     * Return the Musica' Disco's
     * @return Collection of Disco
     */
    public function getDiscos()
    {
        return $this->discos;
    }

    /**
     * Reset aggregates
     */
    public function clearParts()
    {
        $this->discos = array();
    }

    /**
     * Load the object and its aggregates
     * @param $id object ID
     */
    public function load($id)
    {
    
        // load the related Disco objects
        $repository = new TRepository('MusicaDisco');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('muscodigo', '=', $id));
        $musica_discos = $repository->load($criteria);
        if ($musica_discos)
        {
            foreach ($musica_discos as $musica_disco)
            {
                $disco = new Disco( $musica_disco->disco_id );
                $this->addDisco($disco);
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
    
       /* // delete the related MusicaDisco objects
        $criteria = new TCriteria;
        $criteria->add(new TFilter('muscodigo', '=', $this->id));
        $repository = new TRepository('MusicaDisco');
        $repository->delete($criteria);
        // store the related MusicaDisco objects
        if ($this->discos)
        {
            foreach ($this->discos as $disco)
            {
                $musica_disco = new MusicaDisco;
                $musica_disco->disco_id = $disco->id;
                $musica_disco->musica_id = $this->id;
                $musica_disco->store();
            }
        }*/
    }

    /**
     * Delete the object and its aggregates
     * @param $id object ID
     */
    public function delete($id = NULL)
    {
        $id = isset($id) ? $id : $this->id;
        // delete the related MusicaDisco objects
        $repository = new TRepository('MusicaDisco');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('muscodigo', '=', $id));
        $repository->delete($criteria);
        
    
        // delete the object itself
        parent::delete($id);
    }


}
