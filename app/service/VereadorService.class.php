<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/9/2018
 * Time: 11:23 AM
 */

class VereadorService
{

    /**
     * Partido constructor.
     */
    private $vereadores;
    private $id;
    private $precodigo;
    private $tipo;
    private $ativo;
    private $letra;
    private $tipos;
    private $api;
    private $ocupacao;

    private $associacao;
    private $parcodigo;

    /**
     * VereadorService constructor.
     * @param $vereadores
     */
    public function __construct($vereadores)
    {
        $this->vereadores = (array)$vereadores;
        $this->api = new Api();
        $this->ativo = 1;
    }

    /**
     * @param $precodigo
     * @return array
     */
    function getVereadorPrecodigo($precodigo){
        $this->precodigo =  $precodigo;
        return array_values(array_filter($this->vereadores, function ($prefeito)
        {
            return ($prefeito->preestado == $this->ativo && $prefeito->precodigo == $this->precodigo);
        }));
    }

    /**
     * @param $letra
     * @return array
     */
    function getVereadorLetra($letra){
        $this->letra =  $letra;
        $this->tipo = 0;
        return array_values(array_filter($this->vereadores, function ($vereador)
        {
            return ($vereador->preestado == $this->ativo && substr($vereador->vernome,0,1)== $this->letra  );
        }));
    }

    /**
     * @param $letra
     * @param $precodigo
     * @return array
     */
    function getVereadorLetraPrecodigo($letra, $precodigo){
        $this->letra =  $letra;
        $this->tipo = 0;
        return array_values(array_filter($this->getVereadorPrecodigo($precodigo), function ($vereador)
        {
            return ($vereador->preestado == $this->ativo && substr($vereador->vernome,0,1)== $this->letra  );
        }));
    }


    /**
     * @param $id
     * @return array
     */
    function getVereadorId($id){
        $this->id = $id;
        return array_values(array_filter($this->vereadores, function ($vereador)
        {
            return ($vereador->vercodigo == $this->id);
        }));
    }

    /**
     * @param $precodigo
     * @return array
     */
    function getVereadorPresidente($precodigo){
        return $this->getVereadorOcupacao("PRESIDENTE", $precodigo );
    }

    /**
     * @param $precodigo
     * @return array
     */
    function getVereadorVice($precodigo){
        return $this->getVereadorOcupacao("VICE", $precodigo);
    }


    /**
     * @param $letra
     * @return array
     */
    function getCamaraLetra($letra){
        $this->letra =  $letra;
        return array_values(array_filter($this->vereadores, function ($vereador)
        {
            return (substr($vereador->prefeitura->prenome,0,1)== $this->letra);
        }));
    }

    /**
     * @param $sigla
     * @return array
     */
    function getVereadorAssociacao($sigla){
        $this->associacao =  $sigla;
        return array_values(array_filter($this->vereadores, function ($vereador)
        {
            return ($vereador->prefeitura->preampar == $this->associacao);
        }));
    }

    /**
     * @param $parcodigo
     * @return array
     */
    function getByPartido($parcodigo){
        $this->parcodigo =  $parcodigo;
        return array_values(array_filter($this->vereadores, function ($vereador)
        {
            return ($vereador->parcodigo == $this->parcodigo);
        }));
    }


    /**
     * @param $ocupacao
     * @param $precodigo
     * @return array
     */
    private function getVereadorOcupacao($ocupacao, $precodigo){
        $this->ocupacao = $ocupacao;
        $this->precodigo = $precodigo;

        return array_values(array_filter($this->vereadores, function ($vereador)
        {
            return ($vereador->verocupacao == $this->getTipo($this->ocupacao) && $vereador->precodigo == $this->precodigo);
        }));
    }

    /**
     * @param $tipo
     * @return int|string
     */
    private function getTipo($tipo){
        $tipo = strtoupper($tipo);
        $this->tipos =  $this->api->getVereadorTipos();

        foreach($this->tipos as $key=>$objeto){
            if ($tipo == $objeto) return $key;
        }
        return 0;
    }

}

