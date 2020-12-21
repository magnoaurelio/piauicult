<?php

/**
 * Prefeito Active Record
 * @author  <your-name-here>
 */
class Prefeito extends TRecord //implements Direcionavel
{
    const TABLENAME = 'prefeito';
    const PRIMARYKEY = 'prenumero';
    const IDPOLICY = 'serial'; // {max, serial}


    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('precodigo');
        parent::addAttribute('pretipo');
        parent::addAttribute('preescola');
        parent::addAttribute('preendereco');
        parent::addAttribute('precep');
        parent::addAttribute('prebairro');
        parent::addAttribute('preemail');
        parent::addAttribute('preapep');
        parent::addAttribute('prenomep');
        parent::addAttribute('prefotop');
        parent::addAttribute('prepartidop');
        parent::addAttribute('pretitulo');
        parent::addAttribute('precpf');
        parent::addAttribute('prerg');
        parent::addAttribute('prergdata');
        parent::addAttribute('prerguf');
        parent::addAttribute('prergorgao');
        parent::addAttribute('preddd');
        parent::addAttribute('prefone');
        parent::addAttribute('precelular');
        parent::addAttribute('precivil');
        parent::addAttribute('historico');
        parent::addAttribute('preniverp');
        parent::addAttribute('presexop');
        parent::addAttribute('preconjuge');
        parent::addAttribute('preconusual');
        parent::addAttribute('preniverc');
        parent::addAttribute('presexoc');
        parent::addAttribute('precelulac');
        parent::addAttribute('prefotoc');
        parent::addAttribute('preativo');
        parent::addAttribute('preperiodo');
        parent::addAttribute('pretse');
    }

    public function get_Cidade()
    {
        TTransaction::open('conexao');
        if ($this->precodigo) {
            $cidade = new Prefeitura($this->precodigo);
            return $cidade->prenome;
        } else {
            return "MAGNUSOFT";
        }
        TTransaction::close();
    }

    public function get_Tipo()
    {
        return DadosFixos::Pretipo($this->pretipo);
    }

    function getPrefeitura()
    {
        return new Prefeitura($this->precodigo);
    }

    public function get_EstadoCivil()
    {
        return DadosFixos::EstadoCivil($this->precivil);
    }

    public function get_Escolaridade()
    {
        return DadosFixos::Escolaridade($this->preescola);
    }

    function getPartido()
    {
        return new Partido($this->prepartidop);
    }

    public static function getPrefeito($precodigo, $pretipo = 0)
    {
        $repo = new TRepository('Prefeito');
        $criteria = new TCriteria;
        $criteria->add(new TFilter("precodigo", "=", $precodigo));
        $criteria->add(new TFilter("preativo", "=", 1));
        $criteria->add(new TFilter("pretipo", "=", $pretipo));
        $prefs = $repo->load($criteria);
        return $prefs ? $prefs[0] : new Prefeito();
    }


    public static function getPrefeitoDiretor()
    {
        try {
            TTransaction::open('conexao');
            $repo = new TRepository('Diretoria');
            $criteria = new TCriteria;
            $criteria->add(new TFilter("tipcodigo", "=", 1));
            $dir = $repo->load($criteria);
            if ($dir):
                foreach ($dir as $value):
                    if (strstr($value->dirperiodo, date("Y"))) {
                        return new Prefeito($value->prenumero);
                    }
                endforeach;
            endif;
            $std = new stdClass;
            $std->prenomep = "Presidente";
            return $std;
            TTransaction::close();
        } catch (Exception $e) {
            TMessage('warning', $e->getMessage());
        }
    }


    function getDiretorio()
    {
        return $this->getPrefeitura()->getDiretorio();
    }

    function getFoto()
    {
        $file = $this->getDiretorio() . $this->prefotop;
        if (is_file($file)) return $file;
        return 'files/prefeituras/user.png';
    }

    function getFotoConjuge()
    {
        $file = $this->getDiretorio() . $this->prefotoc;
        if (is_file($file)) return $file;
        return 'files/prefeituras/user.png';
    }

    function serializer()
    {

    }


}
