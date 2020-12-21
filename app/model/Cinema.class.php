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
class Cinema extends Read {

    private $properties;
    private $Table = 'cinema';
    private $read;

    public function __construct($id = null, $criterio =  null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE cincodigo = :id", "id={$id}");
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

   // function get_artista(){
   //     return new Artista($this->artcodigo);
   // }
    function getGenero(){
        $categoria = new CinemaGenero($this->cingenero);
        return $categoria;
    }
    function getFestival(){
        return new Festival($this->fescodigo);;
    }

    function getElenco(){
        parent::parseQuery("SELECT a.* from cinema as c join cinema_elenco as ce join artista as a
        on c.cincodigo =  ce.cincodigo and ce.artcodigo = a.artcodigo WHERE c.cincodigo = ".$this->cincodigo);
        return parent::getResult();
    }







}
