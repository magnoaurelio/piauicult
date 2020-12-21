<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrevisaoTempo
 *
 * @author Marcelo
 */
class NoticiasBrasil {

    public static function requestNoticiaBrasil() {
        try {
             $curl = curl_init();
              curl_setopt_array($curl, array(
              CURLOPT_HEADER => "Content-Type:application/xml",
              CURLOPT_URL => 'http://globoesporte.globo.com/servico/semantica/editorias/plantao/feed.rss',
              CURLOPT_RETURNTRANSFER => TRUE
              ));
              $result = curl_exec($curl);
              curl_close($curl);
              $xml = new SimpleXMLElement($result);
              $namespaces = $xml->getNamespaces(true);
              return $xml->children()->channel->children()->item; 

           /* $urlxml = "http://globoesporte.globo.com/ESP/Noticia/Rss/0,,AS0-4271,00.xml";
            $xml = simplexml_load_file($urlxml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $array = json_decode(json_encode((array) $xml), TRUE);
            $array = ($array['channel']['item']);
            return $array;*/
        } catch (Exception $ex) {
            
        }
    }

}
