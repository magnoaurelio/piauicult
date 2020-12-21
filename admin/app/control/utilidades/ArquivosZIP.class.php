<?php
class ArquivosZIP
{
   
  static function ArquivosDir($path){
    if(is_dir($path))
    {
    $diretorio = dir($path);
    $arquvos = array();
    while(($arquivo = $diretorio->read()) !== false)
    {
       if($arquivo!='.' && $arquivo!='..'){
         $arquvos[] = $arquivo;
       }
    }
    
    $diretorio->close();
    } 
    
    sort($arquvos, SORT_STRING);    
    return $arquvos;  
   }
   
   
   static function Move($origem, $destino){
     try{
     copy($origem, $destino);
     unlink($origem);
     }catch(Exception $e){
        new TMessage('warning','Erro ao Move o arquivo '.$origem.'<br> <small>'.$e.'</small>');    
      }
   }
}
