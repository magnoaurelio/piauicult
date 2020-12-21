<?php
/**
 * Noticias Active Record
 * @author  <your-name-here>
 */
class Noticias extends TRecord
{
    const TABLENAME = 'noticias';
    const PRIMARYKEY= 'notid';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nottitulo');
        parent::addAttribute('notfoto');
        parent::addAttribute('notfoto1');
        parent::addAttribute('notfoto2');
        parent::addAttribute('notfoto3');
        parent::addAttribute('notfoto4');
        parent::addAttribute('notfoto5');
        parent::addAttribute('notfoto6');
        parent::addAttribute('notnoticia');
        parent::addAttribute('notdata');
        parent::addAttribute('artcodigo');
        parent::addAttribute('notvisita');
        parent::addAttribute('nottipo');
        parent::addAttribute('notestado');
        parent::addAttribute('notinclui');
        parent::addAttribute('notaltera');
        parent::addAttribute('notexclui');
        parent::addAttribute('notmesano');
        parent::addAttribute('usuid');
        parent::addAttribute('home');
    }


    function getArtistas () {
        $repository = new TRepository('NoticiaArtista');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cod_noticia','=', $this->notid));
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
                    $noticia_artista = new NoticiaArtista();
                    $noticia_artista->cod_noticia =  $this->notid;
                    $noticia_artista->cod_artista =  $objeto->artcodigo;
                    $noticia_artista->store();
                }
            }
        }
    }


    function deleteArtistas () {
        $repository = new TRepository('NoticiaArtista');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cod_noticia','=', $this->notid));
        $repository->delete($criteria);
    }

    function get_Artista(){
        return new Artista($this->artcodigo);
    }


}
