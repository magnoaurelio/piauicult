<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dependencias
 *
 * @author MAGNUSOFT-PC
 */
class Dependencias {
    public static function setDependencias(Array $dependencias,Array $request) {
        $atributo = [];
        foreach ($dependencias as $value) {
            if (in_array($value,$request)):
                throw new Exception("Ausências de depêndecias na pagina");
            else:
                $atributo[$value] = $request[$value];
            endif;
        }
        return $atributo;       
    }

}
