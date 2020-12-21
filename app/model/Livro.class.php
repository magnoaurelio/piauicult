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
class Livro extends Read {

    private $properties;
    private $Table = 'livro';
    private $read;

    public function __construct($id = null, $artista = null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE livcodigo = :id", "id={$id}");
        } else {
            parent::ExeRead($this->Table);
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
    
    function get_Artista(){
   //   $artista =  new Artista($this->livautor);
     return  new Artista($this->livautor);
   }
   
   /* public  function getLivroParticipantes() {
        $collections = [];
        if($this->livmusicos){
            $ids = explode(';', $this->livmusicos);
            foreach ($ids as $id):
                $object = new Artista($id);
                $collections[] = $object;
            endforeach;
        }
        return $collections;
    }*/

    
}
