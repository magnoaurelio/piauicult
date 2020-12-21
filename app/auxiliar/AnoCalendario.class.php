<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataCalendario
 *
 * @author MAGNUSOFT-PC
 */
class AnoCalendario {

    private $numero;
    private $periodo = array(
       '01' => '2017-2018', '02' => '2015-2016',
       '03' => '2013-2014', '04' => '2011-2012',
       '05' => '2009-2010', '06' => '2007-2008',
       '07' => '2005-2006', '08' => '2003-2004',
       '09' => '2000-2002', '10' => '1998-1999',
       '11' => '1996-1997', '12' => '1994-1995', 
      
    );
    
    public function __construct($periodo) {
        $this->periodo ; //= substr($this->periodo, 0, 9)
    }
     public function getPeriodo() {
        return $this->periodo;
    }
    
}
