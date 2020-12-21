<?php
/**
 * Cinema Active Record
 * @author  <your-name-here>
 */
class Cinema extends TRecord
{
    const TABLENAME = 'cinema';
    const PRIMARYKEY= 'cincodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cinnome');
        parent::addAttribute('cingenero');
        parent::addAttribute('cinduracao');
        parent::addAttribute('cinsobre');
        parent::addAttribute('cindata');
        parent::addAttribute('fescodigo');
        parent::addAttribute('cinimagem');
        parent::addAttribute('fesprecodigo');
    }


    function get_genero(){
        return new CinemaGenero($this->cingenero);
    }

    function get_festival(){
        return new Festival($this->fescodigo);
    }

    function get_festival_Premio(){
        return new Festival_Premio($this->fesprecodigo);
    }



}
