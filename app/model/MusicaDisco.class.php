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
class MusicaDisco extends Read {

    private $properties;
    private $Table = 'musica_disco';
    private $read;
    private $musicas = [];
    private $disco;

    public function __construct($disco=null,$musica=null) {
        
        if($disco):
            parent::ExeRead($this->Table, "WHERE discodigo = :id", "id={$disco}");  
        elseif($musica):
            parent::ExeRead($this->Table, "WHERE muscodigo = :id", "id={$musica}"); 
        endif;
             
        $this->read = parent::getResult();
        
        
        if($disco):
            $this->setMusicas();
        elseif($musica):
            $this->setDisco();
        endif;
        
       
    }

    private function setMusicas() {
        if ($this->read):
            foreach ($this->read as $value) {
                $musicas  = new Musica($value['muscodigo']);
                $this->musicas[] = $musicas;
            }
        endif;
    }

    public function getMusicas(){
        return $this->musicas;  
   } 
   
    private function setDisco() {
        if ($this->read):
            foreach ($this->read as $value) {
                $disco  = new Disco($value['discodigo']);
                $this->disco = $disco;
            }
        endif;
        
        if($this->disco == null):
            $disco = new stdClass();
            $disco->disimagem =  "piaui_cult.png";
            $disco->discodigo =  "0";
            $this->disco =  $disco;
        endif;
    }

    public function getDisco(){
        return $this->disco;  
   } 

}
