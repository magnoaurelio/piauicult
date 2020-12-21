<?php

class Musica extends Read {

    private $properties;
    private $Table = 'musica';
    private $read;

    public function __construct($id = null, $compositor = null, $criterio=null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE muscodigo = :id", "id={$id}");
        } elseif ($compositor) {
            parent::ExeRead($this->Table, "WHERE musautor = :compositor", "compositor={$compositor}");
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
    
    function getAlbum(){
        if (!$this->muscodigo) {
            throw new Exception("Música nula você não pode acessar o album");
        }
        parent::parseQuery("SELECT disco.discodigo from musica as m join musica_disco as md on m.muscodigo = md.muscodigo join disco "
                . "on disco.discodigo = md.discodigo WHERE m.muscodigo = :codigo limit 1", "codigo={$this->muscodigo}");       
        if(parent::getRowCount()){
            return new Disco(parent::getResult()[0]["discodigo"]);
        }
        return null;
    }

    public static function getInterpretes($id) {
        $collections = [];
        $musica = new Musica($id);
        $ids = explode(';', $musica->artcodigo);
        foreach ($ids as $id):
            $object = new Artista($id);
            $collections[] = $object;
        endforeach;
        return $collections;
    }

    public static function getAutores($id) {
        $collections = [];
        $musica = new Musica($id);
        $ids = explode(';', $musica->musautor);
        foreach ($ids as $id):
            $object = new Artista($id);
            $collections[] = $object;
        endforeach;
        return $collections;
    }

    public static function getArranjos($id) {
        $collections = [];
        $musica = new Musica($id);
        $ids = explode(';', $musica->musarranjo);
        if (!empty($ids[0])):
            foreach ($ids as $id):
                $object = new Artista($id);
                $collections[] = $object;
            endforeach;
        else:
            $object = new stdClass();
            $object->artcodigo = "";
            $object->artusual = "------";
            $collections[] = $object;
        endif;
        return $collections;
    }

    public static function getMusicos($id) {
        $collections = [];
        $musica = new Musica($id);
        $ids = explode(';', $musica->musmusico);
        if (!empty($ids[0])):
            foreach ($ids as $id):
                $object = new Artista($id);
                $collections[] = $object;
            endforeach;
        else:
            $object = new stdClass();
            $object->artcodigo = "";
            $object->artusual = "------";
            $collections[] = $object;
        endif;
        return $collections;
    }

}
