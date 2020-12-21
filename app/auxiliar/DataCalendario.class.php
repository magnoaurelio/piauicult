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


class DataCalendario {

    private $data;
    private $dia;
    private $mes;
    private $ano;
    private $meses = array(
        1 => 'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    );

    public function __construct($data) {
        $data = $this->ValidaData($data);
        $this->data = $data;
        $this->ano = substr($this->data, 0, 4);
        $this->mes = substr($this->data, 4, 2);
        $this->dia = substr($this->data, 6, 2);
    }

    public function getDiaSemana() {
        $diasemana = [
            'Domingo',
            'Segunda-Feira',
            'Terça-Feira',
            'Quarta-Feira',
            'Quinta-Feira',
            'Sexta-Feira',
            'Sábado'
        ];

        $hoje = date('w', strtotime($this->data));

        return $diasemana[$hoje];
    }

    public function getMes() {
        return $this->meses[intval($this->mes)];
    }

    public function getMesKey() {
        return $this->mes;
    }

    public function getDia() {
        return str_pad($this->dia, 2, '0', STR_PAD_LEFT);
    }

    public function getAno() {
        return $this->ano;
    }

    public function getAtualDiaSemana() {
        $data = date('Y') . "-" . $this->mes . "-" . $this->dia;
        $dahj = new DataCalendario($data);
        $diasemana = $dahj->getDiaSemana();
        return $diasemana;
    }

    public function getIdade() {
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $nascimento = mktime(0, 0, 0, $this->mes, $this->dia, $this->ano);
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        return $idade;
    }

    public static function getMeses($tipo = 1, $key = null) {
        $meses = array('01' => 'JANEIRO', '02' => 'FEVEREIRO', '03' => 'MARCO', '04' => 'ABRIL', '05' => 'MAIO',
            '06' => 'JUNHO', '07' => 'JULHO', '08' => 'AGOSTO', '09' => 'SETEMBRO', '10' => 'OUTUBRO',
            '11' => 'NOVEMBRO', '12' => 'DEZEMBRO', "00" => date('Y'),);
        switch ($tipo) {
            case 1:
                $mes = $meses[$key];
                break;
            case 2:
                $mes = $meses;
                break;
            case 3:
                $mes = array_search($key, $meses);
                break;
        }

        return $mes;
    }

    public static function getPeriodos() {
        $periodo = [
            '01' => '2017-2018',
            '02' => '2015-2016',
            '03' => '2013-2014',
            '04' => '2011-2012',
            '05' => '2009-2010',
            '06' => '2007-2008',
            '07' => '2005-2006',
            '08' => '2003-2004',
            '09' => '2000-2002',
            '10' => '1998-1999',
            '11' => '1996-1997',
            '12' => '1994-1995'
        ];

        return $periodo;
    }

    private function ValidaData($data) {
        $data = trim($data);
        $data = str_replace('-', '', $data);
        $data = str_replace('/', '', $data);
        $data = str_replace(':', '', $data);
        $data = str_replace(' ', '', $data);
        $data = str_replace('.', '', $data);
        if (strlen($data) > 8):
            throw new Exception("Data inválida");
        endif;
        return $data;
    }

    public static function date2us($date) {
        if ($date) {
            // get the date parts
            $day = substr($date, 0, 2);
            $mon = substr($date, 3, 2);
            $year = substr($date, 6, 4);
            return "{$year}-{$mon}-{$day}";
        }
    }

    /**
     * Shortcut to convert a date to format dd/mm/yyyy
     * @param $date = date in format yyyy-mm-dd
     */
    public static function date2br($date) {
        if ($date) {
            // get the date parts
            $year = substr($date, 0, 4);
            $mon = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            return "{$day}/{$mon}/{$year}";
        }
    }

}
