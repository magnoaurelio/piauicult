<?php

class Api
{

    private $linkApi = "http://api.municipiaui.com/rest.php";
    public static $path = "http://api.municipiaui.com/files/";
    public static $linkBase = "http://api.municipiaui.com/";

    private $request;

    /**
     * Api constructor.
     */
    public function __construct()
    {
        $this->request =  new Request($this->linkApi);
    }


    //buscar Prefeito
    function getPrefeito($filters = null, $individual=false){
        return $this->getObject("Prefeito", $filters, $individual);
    }

    //buscar Prefeitura
    function getPrefeitura($filters = null, $individual=false){
        return $this->getObject("Prefeitura", $filters, $individual);
    }

    function getPartido($filters = null, $individual=false){
        return $this->getObject("Partido", $filters, $individual);
    }

    function getVereador($filters = null, $individual=false){
        return $this->getObject("Vereador", $filters, $individual);
    }

    function getSecretaria($filters = null, $individual=false){
        return $this->getObject("Secretaria", $filters, $individual);
    }

    function getVereadorTipos(){
        return (array) $this->getObjectEspecifico("Vereador", 'getTipos');
    }

    function getVereadorPresidentes(){
        return (array) $this->getObjectEspecifico("Vereador", 'getPresidentes');
    }


    private function getObject($class, $filters = null, $individual=false){
        $data =  array();
        $data["filters"] =  $filters;
        $endpoint = "?class={$class}Service&method=loadAll";
        $objeto =  $this->request->onRequest($endpoint, $data);

        if ($individual && $objeto->status=="success" && sizeof($objeto->data)){
            return $objeto->data[0];
        }
        return $objeto->data;
    }

    private function getObjectEspecifico($class, $method, $param=null){
        $data =  array();
        $data["param"] =  $param;
        $endpoint = "?class={$class}Service&method={$method}";
        $objeto =  $this->request->onRequest($endpoint, $data);
        if($objeto->status == "success"){
            return $objeto->data;
        }
        return [];
    }

}