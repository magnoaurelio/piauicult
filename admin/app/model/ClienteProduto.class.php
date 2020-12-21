<?php
/**
 * ArtistaTipo Active Record
 * @author  <your-name-here>
 */
class  ClienteProduto extends TRecord
{
    const TABLENAME = 'cliente_produto';
    const PRIMARYKEY= 'cliprocodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('clipronome');
        parent::addAttribute('cliprofoto');
        parent::addAttribute('cliprotamanho');
        parent::addAttribute('cliprosexo');
    }
   


}
