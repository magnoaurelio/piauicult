<?php
/**
 * Humor Active Record
 * @author  <your-name-here>
 */
class Humor extends \Adianti\Database\TRecord
{
    const TABLENAME = 'humor';
    const PRIMARYKEY= 'humcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('humnome');
        parent::addAttribute('artcodigo');
        parent::addAttribute('fescodigo');
        parent::addAttribute('fesprecodigo');
        parent::addAttribute('humsobre');
        parent::addAttribute('humcategoria');
        parent::addAttribute('humarquivo');
        parent::addAttribute('humpagina');
    }

    function get_artista(){
        return new Artista($this->artcodigo);
    }

    function get_categoria(){
        return new HumorCategoria($this->humcategoria);
    }

    function get_festival(){
        return new Festival($this->fescodigo);
    }
     function get_festival_Premio(){
        return new Festival_Premio($this->fesprecodigo);
    }


}
