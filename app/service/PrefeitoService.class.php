<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/9/2018
 * Time: 11:23 AM
 */

class PrefeitoService
{

    /**
     * PrefeitoService constructor.
     */
    private $prefeitos;
    private $id;
    private $precodigo;
    private $tipo;
    private $ativo;
    private $letra;
    private $parcodigo;


    public function __construct($prefeitos)
    {
        $this->prefeitos = (array)$prefeitos;
        $this->ativo = 1;
    }

    function getPrefeitoPrecodigo($precodigo){
        $this->precodigo =  $precodigo;
        $this->tipo = 0;
        return array_values(array_filter($this->prefeitos, function ($prefeito)
        {
            return ($prefeito->pretipo == $this->tipo && $prefeito->preativo == $this->ativo && $prefeito->precodigo == $this->precodigo);
        }));
    }

    function getPrefeitoLetra($letra){
        $this->letra =  $letra;
        $this->tipo = 0;
        return array_values(array_filter($this->prefeitos, function ($prefeito)
        {
            return ( $prefeito->pretipo == $this->tipo && $prefeito->preativo == $this->ativo && substr($prefeito->prenomep,0,1)== $this->letra  );
        }));
    }


    function getViceLetra($letra){
        $this->letra =  $letra;
        $this->tipo = 1;
        return array_values(array_filter($this->prefeitos, function ($prefeito)
        {
            return ( $prefeito->pretipo == $this->tipo && $prefeito->preativo == $this->ativo && substr($prefeito->prenomep,0,1)== $this->letra  );
        }));
    }


    function getVicePrecodigo($precodigo){
        $this->precodigo =  $precodigo;
        $this->tipo = 1;
        return array_values(array_filter($this->prefeitos, function ($prefeito)
        {
            return ($prefeito->pretipo == $this->tipo && $prefeito->preativo == $this->ativo && $prefeito->precodigo == $this->precodigo);
        }));
    }

    function getPrefeitoPartido($parcodigo, $tipo=0){
        $this->parcodigo =  $parcodigo;
        $this->tipo = $tipo;
        return array_values(array_filter($this->prefeitos, function ($prefeito)
        {
            return ($prefeito->prepartidop == $this->parcodigo && $prefeito->preativo == $this->ativo && $prefeito->pretipo == $this->tipo);
        }));
    }

    function getVicepPartido($parcodigo){
         return $this->getPrefeitoPartido($parcodigo,1);
    }


    function getViceId($id){
       return $this->getPrefeitoId($id);
    }

    function getPrefeitoId($id){
        $this->id = $id;
        return array_values(array_filter($this->prefeitos, function ($prefeito)
        {
            return ($prefeito->prenumero == $this->id);
        }));
    }
}