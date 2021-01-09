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
class Disco extends Read {

    private $properties;
    private $Table = 'disco';
    private $read;

    public function __construct($id = null, $criterio =  null) {
        if ($id) {
            parent::ExeRead($this->Table, "WHERE discodigo = :id", "id={$id}");
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

    public  function getParticipantes() {
        $collections = [];
        $ids = explode(';', $this->artcodigo);
        foreach ($ids as $id):
            $object = new Artista($id);
            $collections[] = $object;
        endforeach;
        return $collections;
    }

    public  function participaDisco($artcodigo) {
        $participantes = $this->getParticipantes();
        foreach ($participantes as $participante):
              if($participante->artcodigo == $artcodigo) return true;
        endforeach;
        return false;
    }

    public static function getArtistaOrdem($id_artista = null) {
        $collections = [];
        $retorno = [];
        $discos = new Disco();
        $artistas = new Artista();
        foreach ($artistas->getResult() as $artista) {
            $collections[$artista['artcodigo']] = 0;
        }
        foreach ($discos->getResult() as $disco):
            $ids = explode(';', $disco['artcodigo']);
        if ($ids) {
            foreach ($ids as $id):
                if (isset($collections[$id]))
                    $collections[$id] = $collections[$id] + 1;
            endforeach;
        }
        endforeach;


        foreach ($collections as $key => $value) {
            if ($id_artista):
                if ($key == $id_artista):
                    $retorno[$key] = $value;
                endif;
            else:

                if ($value):
                    $retorno[$key] = $value;
                endif;
            endif;
        }


        arsort($retorno);
        
      
        return $retorno;
    }

    public static function getAutor($idMusica) {
        $musica = new Musica($idMusica);
        $ids = explode(';', $musica->artcodigo);
        foreach ($ids as $id):
            $object = new Artista($id);
            return $object;
        endforeach;
    }

    public static function getAutorDisco($idDisco) {
        $disco = new Disco($idDisco);
        $ids = explode(';', $disco->artcodigo);
        foreach ($ids as $id):
            $object = new Artista($id);
            return $object;
        endforeach;
    }



    #produtores
    /**
     * @param $id do disco
     * @return array
     */
    public static function getProdutor($id) {
        $collections = [];
        $disco = new Disco($id);
        $ids = explode(';', $disco->disprodutor);
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

    #arte
    /**
     * @param $id do disco
     * @return array
     */
    public static function getArte($id) {
        $collections = [];
        $disco = new Disco($id);
        $ids = explode(';', $disco->disarte);
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


    public static function getLivro($idDisco){
        $read  =  new Read();
        $read->ExeRead('livro','WHERE livdisco = :disco limit 1',"disco={$idDisco}");
        if ($read->getRowCount()) {
            return new Livro($read->getResult()[0]['livcodigo']);
        }
        return false;
    }
    
   //  public static function getCliente($idDisco){
   //     $read  =  new Read();
   //     $read->ExeRead('cliente','WHERE discodigo = :disco limit 1',"disco={$idDisco}");
   //     if($read->getRowCount())
   //         return new Cliente($read->getResult()[0]['clicodigo']);
   //     return false;
  //  }

}
