<?php
/**
 * Literatura Active Record
 * @author  <your-name-here>
 */
class Literatura extends TRecord
{
    const TABLENAME = 'literatura';
    const PRIMARYKEY= 'litcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('litnome');
        parent::addAttribute('artcodigo');
        parent::addAttribute('fescodigo');
        parent::addAttribute('litsobre');
        parent::addAttribute('litcatcodigo');
        parent::addAttribute('litarquivo');
        parent::addAttribute('fesprecodigo');
        parent::addAttribute('litpagina');
    }

    function get_artista(){
        return new Artista($this->artcodigo);
    }

    function get_literatura_Categoria(){
        return new LiteraturaCategoria($this->litcatcodigo);
    }

    function get_festival(){
        return new Festival($this->fescodigo);
    }
     function get_festival_Premio(){
        return new Festival_Premio($this->fesprecodigo);
    }

}
