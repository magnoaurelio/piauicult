<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sessao
 *
 * @author MAGNUSOFT-PC
 */
class Sessao {
//put your code here
 
    public function __construct($handler = NULL, $path = NULL)
    {
        if ($path)
        {
            session_save_path($path);
        }
        
        if ($handler)
        {
            session_set_save_handler($handler, true);
        }
		
        // if there's no opened session
        if (!session_id())
        {
            session_start();
        }
    }
    
    public static function enabled()
    {
        if (!session_id())
        {
            return session_start();
        }
        return TRUE;
    }
    
    
    public static function setValue($var, $value)
    {
     
            $_SESSION[$var] = $value;
           
       
        
    }
    
    public static function getValue($var)
    {
       
            if (isset($_SESSION[$var]))
            {
                return $_SESSION[$var];
            }
        
    }
    
    /**
     * Clear the value for a variable
     * @param $var   Variable Name
     */
    public static function delValue($var)
    {
       
            unset($_SESSION[$var]);
    }
    
    /**
     * Regenerate id
     */
    public static function regenerate()
    {
        session_regenerate_id();
    }
    
    /**
     * Clear session
     */
    public static function clear()
    {
        self::freeSession();
    }
    
    /**
     * Destroy the session data
     * Backward compatibility
     */
    public static function freeSession()
    {
       
            $_SESSION[] = array();
        
    }
}
