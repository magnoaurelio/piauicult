<?php
/**
 * Links Active Record
 * @author  <your-name-here>
 */
class Links extends TRecord
{
    const TABLENAME = 'links';
    const PRIMARYKEY= 'lincodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $artista;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('artcodigo');
        parent::addAttribute('linnome');
        parent::addAttribute('linurl');
        parent::addAttribute('linresponsavel');
        parent::addAttribute('linusual');
        parent::addAttribute('lincontato');
        parent::addAttribute('linemail');
        parent::addAttribute('linimagem');
        parent::addAttribute('linfoto');
        parent::addAttribute('linativo');
    }

    
    /**
     * Method set_artista
     * Sample of usage: $links->artista = $object;
     * @param $object Instance of Artista
     */
    public function set_artista(Artista $object)
    {
        $this->artista = $object;
        $this->artista_id = $object->id;
    }
    
    /**
     * Method get_artista
     * Sample of usage: $links->artista->attribute;
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
    
    
    function setAtivo () {
        $this->linativo =  $this->linativo ? 0 : 1;
        $this->store();
    }
       


}
