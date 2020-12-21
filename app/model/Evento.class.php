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
class Evento extends Read {

    private $properties;
    private $Table = 'eventos';
    private $read;

    public function __construct($id = null,$criterio=null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE evecodigo = :id", "id={$id}");
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

    function getArtistas(){
        parent::parseQuery("SELECT artista.* from evento_artista as ea
        join artista on ea.cod_artista =  artista.artcodigo
        WHERE ea.cod_evento = ".$this->evecodigo);
        return parent::getResult();
    }

}
