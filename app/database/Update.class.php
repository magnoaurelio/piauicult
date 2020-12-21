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
class Update extends Conexao {

    private $Dados;
    private $Termos;
    private $Places;
    private $Result;
    private $Tabela;

    /** @var PDO */
    private $Conn;

    /** @var PDOStatement */
    private $Update;

    public function ExeUpdate($Table, array $Dados, $Termos, $parseString) {
        $this->Tabela = (string) $Table;
        $this->Dados = $Dados;
        $this->Termos = (string) $Termos;
        parse_str($parseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    public function getResult() {
        return $this->Result;
    }

    public function getRowCount() {
        return $this->Update->rowCount();
    }

    public function setPlaces($parseString) {
        parse_str($parseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /** METODOS PRIVADOS * */
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Update = $this->Conn->prepare($this->Update);
    }

    private function getSyntax() {
        foreach ($this->Dados as $key => $value):
            $Places[] = $key . '= :' . $key;
        endforeach;
            $Places  = implode(',', $Places);
           $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
    }

    private function Execute() {
        $this->Connect();
        try {
            $this->Update->execute(array_merge($this->Dados,$this->Places));
            $this->Result = true;
        } catch (Exception $exc) {
            $this->Result = null;
            MErro($exc);
        }
    }

}
