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
class ArtistaTipo extends Read {

    private $properties;
    private $Table = 'artista_tipo';
    private $read;

    public function __construct($id = null,$criterio=null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE arttipocodigo = :id", "id={$id}");
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

    public static function getMusicosTipo($id = null) {
        $collections = [];
        if ($id):
            $artistas = new Artista(null, "WHERE arttipocodigo = {$id}");
            if ($artistas->getResult()):
                foreach ($artistas->getResult() as $artista):
                    $artista = new Artista($artista['artcodigo']);
                    $collections[] = $artista;
                endforeach;
            endif;
        else:
            $artista_tipos = new ArtistaTipo();
            foreach ($artista_tipos->getResult() as $artista_tipo):
                $artistas = new Artista(null, "WHERE arttipocodigo = {$artista_tipo['arttipocodigo']} ORDER BY RAND() LIMIT 1");
                if ($artistas->getResult()):
                    foreach ($artistas->getResult() as $artista):
                        $artista = new Artista($artista['artcodigo']);
                        $collections[] = $artista;
                    endforeach;
                endif;
            endforeach;
        endif;
        return $collections;
    }

}
