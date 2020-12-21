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
class BandaTipo extends Read {

    private $properties;
    private $Table = 'banda_tipo';
    private $read;

    public function __construct($id = null,$criterio=null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE bantipocodigo = :id", "id={$id}");
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

     public function getBandas() {
        $grupos = [];
        $bandas = new Banda();
        foreach ($bandas->getResult() as $banda):
            $ids = explode(';', $banda['bantipocodigo']);
            foreach ($ids as $id):
                if ($id == $this->bantipocodigo):
                    $grupo = new Banda($banda['bancodigo']);
                    $grupos[] = $grupo;
                endif;
            endforeach;
        endforeach;
        return $grupos;
    }
     public static function getBandasTipoOrdem($id = null) {
        $collections = [];
        $bandatipos = new BandaTipo();
        foreach ($bandatipos->getResult() as $bandatipo):
            $bandatipo = new BandaTipo($bandatipo['bantipocodigo']);
            if ($id):
                if ($bandatipo->bantipocodigo == $id):
                    $collections[$bandatipo->bantipocodigo] = sizeof($bandatipo->getMusicos());
                endif;

            else:
                $tm = sizeof($bandatipo->getBandas());
                if ($tm):
                    $collections[$bandatipo->bantipocodigo] = $tm;
                endif;

            endif;
        endforeach;
        arsort($collections);
        return $collections;
    }
 }
