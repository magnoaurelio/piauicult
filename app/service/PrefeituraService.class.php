<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/9/2018
 * Time: 11:24 AM
 */

class PrefeituraService
{
    /**
     * PrefeitoService constructor.
     */
    private $prefeituras;
    private $id;
    private $precodigo;
    private $letra;


    public function __construct($prefeituras)
    {
        $this->prefeituras = (array)$prefeituras;
    }

    function getPrefeiturasLetra($letra){
        $this->letra =  $letra;
        return array_values(array_filter($this->prefeituras, function ($prefeitura)
        {
            return (substr($prefeitura->prenome,0,1)== $this->letra && $prefeitura->codigoUnidGestora > 201000 );
        }));
    }

    function getCamaraLetra($letra){
        $this->letra =  $letra;
        return array_values(array_filter($this->prefeituras, function ($prefeitura)
        {
            return (substr($prefeitura->prenome,0,1)== $this->letra && $prefeitura->codigoUnidGestora < 201000 );
        }));
    }

    function getPrefeituras(){
        return $this->prefeituras;
    }

     function getByPrecodigo($precodigo)
    {
        $this->precodigo =  $precodigo;
        return array_values(array_filter($this->prefeituras, function ($prefeitura)
        {
            return ($prefeitura->precodigo == $this->precodigo);
        }));
    }

}