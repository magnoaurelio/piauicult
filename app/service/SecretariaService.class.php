<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/9/2018
 * Time: 11:23 AM
 */

class SecretariaService
{

    private $secretarias;
    private $id;
    private $precodigo;
    private $api;


    /**
     * VereadorService constructor.
     * @param $vereadores
     */
    public function __construct($secretarias)
    {
        $this->secretarias = (array)$secretarias;
        $this->api = new Api();
    }

    /**
     * @param $precodigo
     * @return array
     */
    function getByPrecodigo($precodigo){
        $this->precodigo =  $precodigo;
        return array_values(array_filter($this->secretarias, function ($secretaria)
        {
            return ($secretaria->precodigo == $this->precodigo);
        }));
    }


}

