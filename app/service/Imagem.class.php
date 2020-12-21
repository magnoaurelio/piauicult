<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/9/2018
 * Time: 10:59 AM
 */

class Imagem
{
    static  function getPrefeitura($value,$unidadeGestora){
        return !self::checkUrl($value) ? Api::$path."prefeituras/".$unidadeGestora."/".trim($value): Api::$linkBase.$value;
    }

    static  function getPrefeito($value,$unidadeGestora){
       return Imagem::getPrefeitura($value, $unidadeGestora);
    }

    static  function getPartido($value,$sigla){
        return Api::$path."partido/".strtolower($sigla)."/".trim($value);
    }

    static  function getPadroeiro($value){
        return Api::$path."padroeiro/".trim($value);
    }

    static  function getGestor($value, $unidadeGestora){
        return Imagem::getPrefeitura($value, $unidadeGestora);
    }

    static function checkUrl($url){
        return (strstr($url,"/"));
    }



}