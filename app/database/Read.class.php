<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Read
 *
 * @author MAGNUSOFT-PC
 */
class Read extends Conexao {

    private $Select;
    private $Places;
    private $Result;
    private $Tabela;

    /** @var PDO */
    private $Conn;

    /** @var PDOStatement */
    private $Read;

    public function ExeRead($Table, $Termos = null, $parseString = null) {
        if (!empty($parseString)):
            parse_str($parseString, $this->Places);
        endif;
        $this->Select = "SELECT * FROM {$Table} {$Termos}";


        $this->Execute();
    }

    public function parseQuery($Query, $parseString = null) {
        $this->Select = (string) $Query;
        if (!empty($parseString)):
            parse_str($parseString, $this->Places);
        endif;
        $this->Execute();
    }

    public function getResult() {
        return $this->Result;
    }

    public function getRowCount() {
        return $this->Read->rowCount();
    }

    public function setPlaces($parseString) {
        parse_str($parseString, $this->Places);
        $this->Execute();
    }

    /** METODOS PRIVADOS * */
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }

    private function getSyntax() {
        if ($this->Places):
            foreach ($this->Places as $key => $value):
                if ($key == 'limit' || $key == 'offset'):
                    $value = (int) $value;
                endif;
                $this->Read->bindValue($key, $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    private function Execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (Exception $exc) {
            $this->Result = null;
            MErro($exc);
        }
    }

    public function __construct() {
        
    }

    public function __set($name, $value) {
        
    }

   

}
