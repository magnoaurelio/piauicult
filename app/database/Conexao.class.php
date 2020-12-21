<?php

class Conexao {

    private static $Host = HOST;
    private static $DBName = DBNAME;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Type = TYPE_BANCO;
    
    /** @var PDO */  
    private static $Conect = null;

    
    private static function Conectar() {
        try {
            if (self::$Conect == null):
                switch (self::$Type):
                    case 'mysql':
                        $dsn = 'mysql:host='.self::$Host.'; dbname='.self::$DBName;
                        break;
                    default :
                        $dsn = 'mysql:host='.self::$Host.'; dbname='.self::$DBName;
                endswitch;
                    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$Conect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        self::$Conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Conect;
    }

    public static function getConn(){
        return self::Conectar();
    }
}
