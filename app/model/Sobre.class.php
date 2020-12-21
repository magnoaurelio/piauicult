<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sorbe
 *
 * @author MAGNUSOFT-PC
 */
class Sobre extends Read {

    private $properties;
    private $Table = 'sobre';
    private $read;

    public function __construct() {
        parent::ExeRead($this->Table, "WHERE id = :id", "id=1");
        $this->read = parent::getResult();
        $this->setParam();
        return (object)parent::getResult()[0];
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
