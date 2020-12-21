<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 3/26/2018
 * Time: 11:59 AM
 */

class File
{

   static function moveSemPorONome( $origemComNome, $destinoSemNome) {
        $partes = pathinfo( $origemComNome);
        $name = $partes['filename'];
        $destinoComNome = $destinoSemNome . $name.".".$partes['extension'];
        return rename( $origemComNome, $destinoComNome );
   }

    static function moveRenomeando($origemComNome, $destinoSemNome ,$incremento=false) {
        $partes = pathinfo( $origemComNome);
        $name = Caracteres::allReplace(substr($partes['filename'],0,90));
        $filename =  $name.".".$partes['extension'];
        $destinoComNome = $destinoSemNome . DIRECTORY_SEPARATOR . $filename;
        if($incremento) {
            $i = 0;
            while (file_exists($destinoComNome)) {

                $filename =  "(" . ++$i . ")" .$name. "." . $partes['extension'];
                $destinoComNome = $destinoSemNome . DIRECTORY_SEPARATOR . $filename;
            }
        }
        rename( $origemComNome, $destinoComNome );
        return $filename;
    }


}