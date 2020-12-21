<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/8/2018
 * Time: 9:27 AM
 */

class Filter
{
    private $campo;
    private $operador;
    private $valor;

    /**
     * Filter constructor.
     * @param $campo
     * @param $operador
     * @param $valor
     */
    public function __construct($campo, $operador, $valor)
    {
        $this->campo = $campo;
        $this->operador = $operador;
        $this->valor = $valor;
    }


    public function getValue(){
        return [
            $this->campo,
            $this->operador,
            $this->valor
        ];
    }


}