<?php
/**
 * Eventos Active Record
 * @author  <your-name-here>
 */
class Eventos extends TRecord
{
    const TABLENAME = 'eventos';
    const PRIMARYKEY= 'evecodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('evetipo');
        parent::addAttribute('evenome');
        parent::addAttribute('evedata');
        parent::addAttribute('evehorario');
        parent::addAttribute('evedetalhe');
        parent::addAttribute('artcodigo');
        parent::addAttribute('discodigo');
        parent::addAttribute('procodigo');
        parent::addAttribute('eveimagem1');
        parent::addAttribute('eveimagem2');
        parent::addAttribute('eveimagem3');
        parent::addAttribute('eveimagem4');
        parent::addAttribute('eveimagem5');
        parent::addAttribute('eveimagem6');
        parent::addAttribute('evelocal');
        parent::addAttribute('evehome');
    }

    function getArtistas () {
        $repository = new TRepository('EventoArtista');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cod_evento','=', $this->evecodigo));
        $artistas = [];
        $collections  = $repository->load($criteria);
        if ($collections){
            foreach($collections as $objeto){
                $artistas[] = new Artista($objeto->cod_artista);
            }
        }
        return $artistas;
    }


    function setArtistas ($artirtas) {
        $this->deleteArtistas();
        if (is_array($artirtas)) {
            if ($artirtas) {
                foreach ($artirtas as $objeto) {
                    $noticia_artista = new EventoArtista();
                    $noticia_artista->cod_evento =  $this->evecodigo;
                    $noticia_artista->cod_artista =  $objeto->artcodigo;
                    $noticia_artista->store();
                }
            }
        }
    }


    function deleteArtistas () {
        $repository = new TRepository('EventoArtista');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cod_evento','=', $this->evecodigo));
        $repository->delete($criteria);
    }

   function get_Artista(){
        return new Artista($this->artcodigo);
    }
    
   function get_Disco(){
        return new Disco($this->discodigo);
    }
    
   function get_Projeto(){
        return new Projeto($this->procodigo);
    }

}
