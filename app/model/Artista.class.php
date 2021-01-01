<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prefeito
 *
 * @author MAGNUSOFT-PC
 */
class Artista extends Read {

    private $properties;
    private $Table = 'artista';
    private $read;

    public function __construct($id = null,$criterio=null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE artcodigo = :id", "id={$id}");
        } else {
            parent::ExeRead($this->Table,$criterio);
        }

        $this->read = parent::getResult();
        $this->setParam();
    }

    private function setParam() {
        if ($this->read):
            foreach ($this->read as $value) {
                foreach ($value as $key => $campo) {
                    $this->$key = $campo;
                }
            }
        endif;
    }

    public function __set($name, $value) {
        // objects and arrays are not set as properties
        if (is_scalar($value)) {
            // store the property's value
            $this->properties[$name] = $value;
        }
    }

    public function __get($name) {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }
    }

    public function getDiscos($criterio = null) {
        $collections = [];
        $discos = new Disco(null,$criterio);
        if ($discos->getResult()):
            foreach ($discos->getResult() as $disco):
                $ids = explode(';', $disco['artcodigo']);
                foreach ($ids as $id):
                    if ($id == $this->artcodigo):
                        $object = new Disco($disco['discodigo']);
                        $collections[] = $object;
                    endif;

                endforeach;
            endforeach;
        endif;
        return $collections;
    }

    public function getMusicas() {
        $collections = [];
        $musicas = new Musica();
        if ($musicas->getResult()):
            foreach ($musicas->getResult() as $musicas):
                $ids = explode(';', $musicas['musautor']);
                $ids2 = explode(';', $musicas['artcodigo']);
                $ids3 = explode(';', $musicas['musarranjo']);
                $ids = array_merge($ids, $ids2, $ids3);
                $ids = array_unique($ids);
                foreach ($ids as $id):
                    if ($id == $this->artcodigo):
                        $object = new Musica($musicas['muscodigo']);
                        $collections[] = $object;
                    endif;

                endforeach;
            endforeach;
        endif;
        return $collections;
    }

    public function getInstrumentos() {
        $collections = [];
        if ($this->inscodigo):
            $ids = explode(';', $this->inscodigo);
            foreach ($ids as $id):
                $object = new Instrumento($id);
                $collections[] = $object;
            endforeach;
        endif;
        return $collections;
    }
    
    public function getGeneros() {
        $collections = [];
        if ($this->gencodigo):
            $ids = explode(';', $this->gencodigo);
            foreach ($ids as $id):
                $object = new Genero($id);
                $collections[] = $object;
            endforeach;
        endif;
        return $collections;
    }

     function getInstrumentosByMusica($musicoCodigo, $musicaCodigo){
        parent::parseQuery("SELECT i.* from musico_instrumento as mi
        join musica as m on mi.cod_musica =  m.muscodigo 
        join artista on artista.artcodigo = mi.cod_musico
        join instrumento as i on i.inscodigo =  mi.cod_instrumento
        WHERE mi.cod_musica = ".$musicaCodigo." and  mi.cod_musico = ".$musicoCodigo);
        return parent::getResult();
    }

    function getNoticias(){
        parent::parseQuery("SELECT noticia.* from noticia_artista as na
        join noticias as noticia on na.cod_noticia =  noticia.notid
        WHERE na.cod_artista = ".$this->artcodigo . " ORDER BY noticia.notid DESC ");
        return parent::getResult();
    }

    function getEventos(){
        parent::parseQuery("SELECT evento.* from evento_artista as na
        join eventos as evento on na.cod_evento =  evento.evecodigo
        WHERE na.cod_artista = ".$this->artcodigo);
        return parent::getResult();
    }

    public function getVideos() {
        $collections = [];
        $videos = new Videos(null," JOIN video_artista as va on va.id_video = videos.vidcodigo WHERE va.id_artista= {$this->artcodigo}");
        foreach ($videos->getResult() as $video){
            $collections[] = new Videos($video["vidcodigo"]);
        }
        return $collections;
    }

    function getBandas(){
        $collections = [];
        $bandas = new Banda(null);
        if ($bandas->getResult()):
            foreach ($bandas->getResult() as $banda):
                $ids = explode(';', $banda['banmusicos']);
                foreach ($ids as $id):
                    if ($id == $this->artcodigo):
                        $object = new Banda($banda['bancodigo']);
                        $collections[] = $object;
                    endif;

                endforeach;
            endforeach;
        endif;
        return $collections;
    }
    
  /*   function getLivros(){
        $collections = [];
        $livros = new Banda(null);
        if ($livros->getResult()):
            foreach ($livros->getResult() as $livro):
                $ids = explode(';', $livro['livmusicos']);
                foreach ($ids as $id):
                    if ($id == $this->artcodigo):
                        $object = new Livro($livro['livcodigo']);
                        $collections[] = $object;
                    endif;

                endforeach;
            endforeach;
        endif;
        return $collections;
    }*/

}
