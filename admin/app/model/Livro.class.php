<?php
/**
 * Livro Active Record
 * @author  <your-name-here>
 */
class Livro extends \Adianti\Database\TRecord
{
    const TABLENAME = 'livro';
    const PRIMARYKEY= 'livcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('livnome');
        parent::addAttribute('livtipo');
        parent::addAttribute('livisbn');
        parent::addAttribute('livautor');
        parent::addAttribute('livgenero');
        parent::addAttribute('livfoto');
        parent::addAttribute('livimagem');
        parent::addAttribute('livano');
        parent::addAttribute('liveditora');
        parent::addAttribute('livpagina');
        parent::addAttribute('livresumo');
        parent::addAttribute('livdisco');
        parent::addAttribute('fescodigo');
        parent::addAttribute('livcategoria');
        parent::addAttribute('livmostra');
        parent::addAttribute('livmusicos');
        
    //    if ($id) {
    //        parent::ExeRead($this->Table, "WHERE livcodigo = :id", "id={$id}");
    //    } else {
    //        if(!$criterio) 
    //            $criterio =  "WHERE livmostra = 1";
            
    //        parent::ExeRead($this->Table, $criterio);
    //    }

    //    $this->read = parent::getResult();
    //    $this->setParam();
    }

    function get_Disco(){
      $disco =  new Disco($this->livdisco);
     return $disco;
   }

   function get_Tipo(){
     return DadosFixos::TipoLivro($this->livtipo);
   }


   function getPaginas(){
       return LivroPagina::where('livcodigo','=', $this->livcodigo)->orderBy('numero','asc')->load();
   }

    function getUltimaPagina(){
        $paginas =  LivroPagina::where('livcodigo','=', $this->livcodigo)->orderBy('numero','desc')->load();
        return ($paginas) ? $paginas[0] : new LivroPagina();
    }

    function get_Artista(){
   //   $artista =  new Artista($this->livautor);
     return  new Artista($this->livautor);
   }
}
