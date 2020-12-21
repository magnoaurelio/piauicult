<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prefeito
 *
 * @author MAGNUSOFT-PC modelo de representação de tabela
 */
class Links extends Read {

    private $properties;
    private $Table = 'links';
    private $read;

    public function __construct($id = null, $criterio = null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE lincodigo = :id", "id={$id}");
        } else {
            if(!$criterio) 
                $criterio =  "WHERE linativo = 1";
            
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

    
}
