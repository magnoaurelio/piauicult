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
class Festival extends Read {

    private $properties;
    private $Table = 'festival';
    private $read;

    public function __construct($id = null, $criterio =  null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE fescodigo = :id", "id={$id}");
        } else {
            parent::ExeRead($this->Table, $criterio);
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

    function getArtistas(){
        parent::parseQuery("SELECT artista.* from festival as f join festival_artista as fa
        on f.fescodigo =  fa.id_festival join artista on artista.artcodigo = fa.id_artista WHERE f.fescodigo = :codigo", "codigo={$this->fescodigo}");
         return parent::getResult();
    }


    function getMusicas(){
        parent::parseQuery("SELECT musica.* from festival as f join festival_musica as fm
        on f.fescodigo =  fm.id_festival join musica on musica.muscodigo = fm.id_musica WHERE f.fescodigo = :codigo", "codigo={$this->fescodigo}");
        return parent::getResult();
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


     function getFestivaisHumor($cidade = null){
        $criterio = $cidade ? " AND precodigo = $cidade" : '';
        parent::parseQuery("SELECT * FROM festival WHERE fescodigo IN (SELECT f.fescodigo from festival as f join humor as h
        on f.fescodigo =  h.fescodigo) $criterio ORDER BY fesperiodo desc");
        return parent::getResult();
     }

    function isFestivalHumor(){
        parent::parseQuery("SELECT f.* from festival as f join humor as h
        on f.fescodigo =  h.fescodigo WHERE f.fescodigo = ".$this->fescodigo);
        return parent::getRowCount();
    }


    function getHumor(){
        parent::parseQuery("SELECT h.* from festival as f join humor as h
        on f.fescodigo =  h.fescodigo WHERE h.fescodigo = ".$this->fescodigo);
        return parent::getResult();
    }

    function getFestivaisCinema($cidade = null){
        $criterio = $cidade ? " AND precodigo = $cidade" : '';
        parent::parseQuery("SELECT * FROM festival WHERE fescodigo IN (SELECT f.fescodigo from festival as f join cinema as c
        on f.fescodigo =  c.fescodigo)$criterio");
        return parent::getResult();
    }

    function isFestivalCinema(){
        parent::parseQuery("SELECT f.* from festival as f join cinema as c
        on f.fescodigo =  c.fescodigo WHERE c.fescodigo = ".$this->fescodigo);
        return parent::getRowCount();
    }


    function getCinema(){
        parent::parseQuery("SELECT c.* from festival as f join cinema as c
        on f.fescodigo =  c.fescodigo WHERE c.fescodigo = ".$this->fescodigo);
        return parent::getResult();
    }
    
     function getFestivaisLiteratura($cidade = null){
        $criterio = $cidade ? " AND precodigo = $cidade" : '';
        parent::parseQuery("SELECT * FROM festival WHERE fescodigo IN (SELECT f.fescodigo from festival as f join literatura as h
        on f.fescodigo =  h.fescodigo) $criterio ORDER BY fesperiodo desc");
        return parent::getResult();
     }

    function isFestivalLiteratura(){
        parent::parseQuery("SELECT f.* from festival as f join literatura as h
        on f.fescodigo =  h.fescodigo WHERE f.fescodigo = ".$this->fescodigo);
        return parent::getRowCount();
    }


    function getLiteratura(){
        parent::parseQuery("SELECT h.* from festival as f join literatura as h
        on f.fescodigo =  h.fescodigo WHERE h.fescodigo = ".$this->fescodigo);
        return parent::getResult();
    }

}
