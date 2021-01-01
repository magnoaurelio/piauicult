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
class Instrumento extends Read {

    private $properties;
    private $Table = 'instrumento';
    private $read;

    public function __construct($id = null, $artista = null, $criterio = null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE inscodigo = :id", "id={$id}");
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

    public function getMusicos() {
        $musicos = [];
        $artistas = new Artista(null, "ORDER BY artnome");
        foreach ($artistas->getResult() as $artista):
            $ids = explode(';', $artista['inscodigo']);
            foreach ($ids as $id):
                if ($id == $this->inscodigo):
                    $musico = new Artista($artista['artcodigo']);
                    $musicos[] = $musico;
                endif;
            endforeach;
        endforeach;
        return $musicos;
    }
    
    public function getGeneros() {
        $musicos = [];
        $artistas = new Artista(null, "ORDER BY artnome");
        foreach ($artistas->getResult() as $artista):
            $ids = explode(';', $artista['inscodigo']);
            foreach ($ids as $id):
                if ($id == $this->inscodigo):
                    $musico = new Artista($artista['artcodigo']);
                    $musicos[] = $musico;
                endif;
            endforeach;
        endforeach;
        return $musicos;
    }

    public static function getMusicosOrdem($id = null) {
        $collections = [];
        $instrumentos = new Instrumento();
        foreach ($instrumentos->getResult() as $instrumento):
            $instrumento = new Instrumento($instrumento['inscodigo']);
            if ($id):
                if ($instrumento->inscodigo == $id):
                    $collections[$instrumento->inscodigo] = sizeof($instrumento->getMusicos());
                endif;

            else:
                $tm = sizeof($instrumento->getMusicos());
                if ($tm):
                    $collections[$instrumento->inscodigo] = $tm;
                endif;

            endif;
        endforeach;
        arsort($collections);
        return $collections;
    }

}
