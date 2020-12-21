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
class Literatura extends Read {

    private $properties;
    private $Table = 'literatura';
    private $read;

    public function __construct($id = null, $criterio =  null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE litcodigo = :id", "id={$id}");
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

    function getArtista(){
        $artista = new Artista($this->artcodigo);
        $artista->foto = "admin/files/artistas/" . trim($artista->artfoto);
        return $artista;
    }

    function getCategoria(){
        $categoria = new LiteraturaCategoria($this->litcategoria);
        return $categoria;
    }

//    function getPagina(){
//        parent::parseQuery("SELECT lv.* from humor as h join livro_pagina as lv
//        on lv.id = h.humpagina WHERE h.humcodigo = ".$this->humcodigo);
//        return parent::getRowCount() ? new Livro_Pagina(parent::getResult()[0]["id"]) : new Livro_Pagina();
//    }


    function getPagina(){
        parent::parseQuery("SELECT lv.* from literatura as h 
        join festival as f join livro_pagina as lv 
        join livro as l 
        on f.fescodigo = h.fescodigo and l.fescodigo = f.fescodigo and lv.livcodigo = l.livcodigo and lv.numero = h.litpagina
        WHERE f.fescodigo = ".$this->fescodigo." AND lv.numero = ".$this->litpagina);
        $pagina =   parent::getRowCount() ? new Livro_Pagina(parent::getResult()[0]["id"]) : new Livro_Pagina();
        return $pagina;
    }




}
