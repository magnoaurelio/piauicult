<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Delete
 *
 * @author MAGNUSOFT-PC
 */
class Delete extends Conexao {

    private $Tabela;
    private $Places;
    private $Result;
    private $Termos;

    /** @var PDO */
    private $Conn;

    /** @var PDOStatement */
    private $Delete;

    public function ExeDelete($Table, $Termos, $parseString) {
        $this->Tabela = (string) $Table;
        $this->Termos = (string) $Termos;
        parse_str($parseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    public function getResult() {
        return $this->Result;
    }

    public function getRowCount() {
        return $this->Delete->rowCount();
    }

    public function setPlaces($parseString) {
        parse_str($parseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /** METODOS PRIVADOS * */
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

    private function getSyntax() {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }

    private function Execute() {
        $this->Connect();
        try{
           $this->Delete->execute($this->Places); 
           $this->Result = true;
        } catch (PDOException $ex) {
         $this->Result = null;
           MErro($ex);
        }
    }

   

}
