<?php
/**
 * Disco Active Record
 * @author  <your-name-here>
 */
class Festival extends TRecord
{
    const TABLENAME = 'festival';
    const PRIMARYKEY= 'fescodigo';
    const IDPOLICY =  'serial'; // {max, serial}
    

    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('fesnome');
        parent::addAttribute('artcodigo');
        parent::addAttribute('fesimagem');
        parent::addAttribute('fesfoto1');
        parent::addAttribute('fesfoto2');
        parent::addAttribute('fesfoto3');
        parent::addAttribute('fesdata');
        parent::addAttribute('fesperiodo');
        parent::addAttribute('precodigo');
        parent::addAttribute('fessobre');
        parent::addAttribute('fesoutros');
        parent::addAttribute('procodigo');
        parent::addAttribute('fesprodutor');
        parent::addAttribute('fesmostra');
        parent::addAttribute('festipocodigo');
        parent::addAttribute('festema');
    }

    // ARTISTA
    function getArtistas () {
        $repository = new TRepository('FestivalArtista');
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id_festival','=', $this->fescodigo));
        $collection = $repository->load($criteria);
        $artistas = array();
        if ($collection){
            foreach ($collection as $festival_artista){
                $artista = new Artista($festival_artista->id_artista);
                $artistas[] =  $artista;
            }
        }
        return $artistas;

    }

    function getArtista($id){
        $repository = new TRepository('FestivalArtista');
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id_festival','=', $this->fescodigo));
        $criteria->add(new TFilter('id_artista','=', $id));
        $collection =  $repository->load($criteria);
        return $collection ? $collection[0] : null;
    }

    function addArtistaSave ($id) {
        if (!$this->existeArtista($id)) {
            $festival_artista = new FestivalArtista();
            $festival_artista->id_artista = $id;
            $festival_artista->id_festival = $this->fescodigo;
            $festival_artista->store();
        }
    }

    function removeArtistaSave ($id) {
        if ($this->existeArtista($id)) {
            $repository = new TRepository('FestivalArtista');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('id_festival','=', $this->fescodigo));
            $criteria->add(new TFilter('id_artista','=', $id));
            $repository->delete($criteria);
        }
    }

    function existeArtista($id){
       return ($this->getArtista($id));
    }


    // MÚSICA
    function getMusicas () {
        $repository = new TRepository('FestivalMusica');
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id_festival','=', $this->fescodigo));
        $collection = $repository->load($criteria);
        $musicas = array();
        if ($collection){
            foreach ($collection as $festival_musica){
                $musica = new Musica($festival_musica->id_musica);
                $musicas[] =  $musica;
            }
        }
        return $musicas;

    }

    function getMusica($id){
        $repository = new TRepository('FestivalMusica');
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id_festival','=', $this->fescodigo));
        $criteria->add(new TFilter('id_musica','=', $id));
        $collection =  $repository->load($criteria);
        return $collection ? $collection[0] : null;
    }

    function addMusicaSave ($id) {
        if (!$this->existeMusica($id)) {
            $festival_musica = new FestivalMusica();
            $festival_musica->id_musica = $id;
            $festival_musica->id_festival = $this->fescodigo;
            $festival_musica->store();
        }
    }

    function removeMusicaSave ($id) {
        if ($this->existeMusica($id)) {
            $repository = new TRepository('FestivalMusica');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('id_festival','=', $this->fescodigo));
            $criteria->add(new TFilter('id_musica','=', $id));
            $repository->delete($criteria);
        }
    }

    function existeMusica($id){
        return ($this->getMusica($id));
    }


    public function delete($id = NULL)
    {
        $id = isset($id) ? $id : $this->fescodigo;
        // delete the related DiscoMusica objects
        $repository = new TRepository('FestivalArtista');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('fescodigo', '=', $id));
        $repository->delete($criteria);

        $repository = new TRepository('FestivalMusica');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('fescodigo', '=', $id));
        $repository->delete($criteria);
        
    
        // delete the object itself
        parent::delete($id);
    }



    function get_livro(){

       $livros =  Livro::where('fescodigo','=', $this->fescodigo)->load();
       return ($livros) ? $livros[0] : new Livro();
    }
    
    function get_tipo(){

       return new Festival_tipo($this->festipocodigo);
    }
    
     function get_produtor(){

       return new Artista($this->artcodigo);
    }



}
