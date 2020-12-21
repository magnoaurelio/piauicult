<?php

class Noticia extends Read {

    private $properties;
    private $Table = 'noticias';
    private $read;

    public function __construct($id = null,$criterio=null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE notid = :id", "id={$id}");
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
        parent::parseQuery("SELECT artista.* from noticia_artista as na
        join artista on na.cod_artista =  artista.artcodigo
        WHERE na.cod_noticia= ".$this->notid);
        return parent::getResult();
    }

}
