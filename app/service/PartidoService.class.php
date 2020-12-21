<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/9/2018
 * Time: 11:23 AM
 */

class PartidoService
{

    /**
     * Partido constructor.
     */
    private $partidos;
    private $sigla;
    private $parcodigo;

    public function __construct($partidos)
    {
        $this->partidos = (array)$partidos;
    }

    function getPartidoParcodigo($parcodigo){
        $this->parcodigo =  $parcodigo;
        return array_values(array_filter($this->partidos, function ($partido)
        {
            return ($partido->parcodigo == $this->parcodigo);
        }));
    }

    function getPartidoSigla($sigla){
        $this->sigla =  $sigla;
        return array_values(array_filter($this->partidos, function ($partido)
        {
            return ($partido->parsigla == $this->sigla);
        }));
    }


}