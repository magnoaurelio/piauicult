<?php
class Zip{

     static function extrairPara($arquivo,$path){
       $zip = new ZipArchive;
           if ($zip->open($arquivo) === TRUE) {
                $zip->extractTo($path);
                $zip->close();
                return true;
            }else{
               new TMessage('error','Erro ao extrair o arquivo:'.$arquivo);
               return false;
            }
      
        }
}
