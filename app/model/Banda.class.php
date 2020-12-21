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
class Banda extends Read {

    private $properties;
    private $Table = 'banda';
    private $read;

    public function __construct($id = null,$criterio=null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE bancodigo = :id", "id={$id}");
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
    
    
     public  function getParticipantes() {
        $collections = [];
        if($this->banmusicos){
            $ids = explode(';', $this->banmusicos);
            foreach ($ids as $id):
                $object = new Artista($id);
                $collections[] = $object;
            endforeach;
        }
        return $collections;
    }

    public function getDiscos() {
        $collections = [];
        $discos = new Disco(null," JOIN banda_disco as bd on bd.discodigo = disco.discodigo WHERE bd.bancodigo= {$this->bancodigo}");
        foreach ($discos->getResult() as $disco){
            $collections[] = new Disco($disco["discodigo"]);
        }
        return $collections;
    }

    public function getVideos() {
        $collections = [];
        $videos = new Videos(null," JOIN video_banda as vb on vb.id_video = videos.vidcodigo WHERE vb.id_banda= {$this->bancodigo}");
        foreach ($videos->getResult() as $video){
            $collections[] = new Videos($video["vidcodigo"]);
        }
        return $collections;
    }

    
    //tipo retorna os ids ou os objetos
    public function getMusicas($tipo=0) {
        $collections = [];
        $coll_ids = [];
        $musicas = new Musica(null,null, "WHERE musbanda = {$this->bancodigo}");
        if ($musicas->getResult()):
            foreach ($musicas->getResult() as $musica):
                        $coll_ids[] = $musica['muscodigo'];
                        $object = new Musica($musica['muscodigo']);
                        $collections[] = $object;
            endforeach;
        endif;
        
        if ($tipo == 1):
            return $coll_ids;
        endif;
            
        return $collections;
    }

 
}
