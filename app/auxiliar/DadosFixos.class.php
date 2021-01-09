<?php
class DadosFixos {


 static function ObjetoArray($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = self::ObjetoArray($value);
        }
        return $result;
    }
    return $data;
}

    static function Modalidade($id = null) {
        $modalidade = array(
            "-----------",
            "Concorrência",
            "Tomada de Preço",
            "Carta Convite",
            "Concurso",
            "Leilão",
            "Pregão",
            "Inexigibilidade",
            "Dispensa",
            "Internacional");
        if ($id == null) {
            return $modalidade;
        } else {
            return $modalidade[$id];
        }
    }

    static function TipoLicitacao($id = null) {
        $tipo = array(
            "-----------",
            "Nenhum",
            "Menor Preço",
            "Melhor Técnica",
            "Técnica Preço",
            "Maior Lance e Oferta",
            "Dispensa");
        if ($id == null) {
            return $tipo;
        } else {
            return $tipo[$id];
        }
    }

    static function Regime($id = null) {
        $regime = array(
            "----------",
            "Nenhum",
            "Empreitada Global",
            "Empreitada Integral",
            "Empreitada Preço Unitário",
            "Tarefa");
        if ($id == null) {
            return $regime;
        } else {
            return $regime[$id];
        }
    }

    static function Informacoes($id = null) {
        $info = array(
            "----------",
            "Obras e Serviços de Engenharia",
            "Material Permanente",
            "Material de Consumo",
            "Outros",
            "Consultoria",
            "Publicidade/Propaganda");
        if ($id == null) {
            return $info;
        } else {
            return $info[$id];
        }
    }

    //|###############################################################################################|
    //|********************* CONTRATO  VARIAVEIS UTILIZADAS COMO BANCO DE DADOS **********************|
    //|###############################################################################################|
    static function TiposContratos($id = null) {
        $tipo_c = array(
            "----------",
            "Contratos",
            "Aditivo",
        );
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function Escolaridade($id = null) {
        $tipo_c = array(
            "Sem exigência",
            "Alfabetizado",
            "Ensino fundamental",
            "Ensino médio",
            "Superior incompleto",
            "Superior completo",
            "Pós-graduação - Especialista",
            "Pós-graduação - Mestre",
            "Pós-graduação - Doutor");
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function EstadoCivil($id = null) {
        $tipo_c = [
            'Solteiro(a)',
            'Casado(a)',
            'Viúvo(a)',
            'Separado(a) Judicial',
            'Divorciado (a)'
        ];
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function Genero($id = null) {
        $tipo_c = [
            'M' => 'Masculino',
            'F' => 'Feminino'
        ];
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function Pretipo($id = null) {
        $tipo_c = [
            'Prefeito',
            'Vice'
        ];

        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function Parentesco($id = null) {
        $tipo_c = array(
            'Cônjuge/Companheiro',
            'Ex- cônjuge/ Ex- companheiro',
            'Filho',
            'Enteado',
            'Tutelado',
            'Pai/mãe',
            'Irmão',
            'Outros');
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function MotivoInativacao($id = null) {
        $tipo_c = array(
            '----',
            'Voluntária',
            'Compulsória',
            'Invalidez');
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function AtoPessoal($id = null) {
        $tipo_c = array(
            "----",
            "Admissão p/ cargo efetivo",
            "Admissão p/ cargo comissionado",
            "Admissão p/ emprego público",
            "Reintegração",
            "Aposentadoria",
            "Transferência para a reserva",
            "Reforma",
            "Exoneração/ Demissão de cargo efetivo",
            "Exoneração/ Demissão de cargo comissionado",
            "Exoneração/ Demissão de emprego público",
            "Falecimento",
            "Contratação por tempo determinado",
            "Dispensa de função gratificada",
            "Afastamento contando o tempo de serviço",
            "Afastamento sem contar o tempo de serviço",
            "À disposição com ônus",
            "À disposição sem ônus",
            "Disponibilidade",
            "Reversão",
            "Nomeação p/ cargo Eletivo",
            "Benefício previdenciário (Auxílio Saúde, Sal. Maternidade)",
            "Alteração da unidade orçamentária de trabalho",
            "Retorno de afastamento (contando ou não tempo de serviço)",
            "Retorno de servidor que se encontrava à disposição (com ou sem ônus)",
            "Retorno de servidor que se encontrava em gozo de Benefício Previdenciário",
            "Rescisão de contrato por tempo determinado",
            "Término de contrato por tempo determinado",
            "Reestruturação de cargos",
            "Alteração de regime previdenciário",
            "Alteração de regime de Trabalho",
            "Readaptação",
            "Aproveitamento",
            "Recondução",
            "Reenquadramento",
            "Designação para exercício de função gratificada",
            "Afastamento contando tempo de contribuição",
            "Afastamento sem contar tempo de contribuição",
            "Outros"
        );
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function RegimePrevidencia($id = null) {
        $tipo_c = array(
            'Sem vínculo',
            'Regime geral',
            'Regime próprio');
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function RegimeTrabalho($id = null) {
        $tipo_c = array(
            'Estatutário',
            'Celetista',
            'Contratual',
            'Eletivo');
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function Vinculo($id = null) {
        $tipo_c = array(
            'Inativos',
            'Pensionistas',
            'Efetivos',
            'Eletivos',
            'Cargo comissionado',
            'Função de confiança',
            'Contratação por excepcional interesse público',
            'Emprego público',
            'Benefício previdenciário temporário',
            'À disposição',
            99 => 'Outros');
        if ($id == null) {
            return $tipo_c;
        } else {
            return $tipo_c[$id];
        }
    }

    static function status($id = null) {
        $regime = array(
            "----------",
            "Finalizada",
            "Cancelada",
            "Em andamento",
            "Outros");
        if ($id == null) {
            return $regime;
        } else {
            return $regime[$id];
        }
    }

    static function DiretoriaTipo($id = null) {
        $diretoria = [
            "PRESIDENTE",
            "VICE-PRESIDENTE",
            "SECRETÁRIO",
            "TESOUREIRO",
            "MEMBRO"
        ];
        if ($id == null) {
            return $diretoria;
        } else {
            return $diretoria[$id];
        }
    }

    static function TipoEtiqueta($id = null) {
        $etiqueta = [
            "AMPAR-MUNICIPIO",
            "APPM-MUNICIPIO",
            "PREFEITURA-MUNICIPIOS",
            "ORGÃO-MUNICIPIO",
            "PREFEITURA"
        ];
        if ($id == null) {
            return $etiqueta;
        } else {
            return $etiqueta[$id];
        }
    }

    public static function TipoNoticia($id = null) {
        $noticias = [
            1 => "Administração",
            "Saúde",
            "Finanças",
            "Obras",
            "Esportes",
            "Cidadania",
            "Educação",
        ];
        if ($id == null) {
            return $noticias;
        } else {
            return $noticias[$id];
        }
    }
    
    
    public static function TipoVideo($id = null) {
        $video = [
            1 => "Documentário",
            2 => "Entrevista",
            3 => "Apresentação",
            4 => "Pessoal",
            5 => "Outro"
        ];
        if ($id == null) {
            return $video;
        } else {
            return $video[$id];
        }
    }
    
    
     public static function getUser($id) {
       
    }
    
    static function getMes($id=null){
      $meses['01'] = 'JANEIRO';
      $meses['02'] = 'FEVEREIRO';
      $meses['03'] = 'MARCO';
      $meses['04'] = 'ABRIL';
      $meses['05'] = 'MAIO';
      $meses['06'] = 'JUNHO';
      $meses['07'] = 'JULHO';
      $meses['08'] = 'AGOSTO';
      $meses['09'] = 'SETEMBRO';
      $meses['10'] = 'OUTUBRO';
      $meses['11'] = 'NOVEMBRO';
      $meses['12'] = 'DEZEMBRO';
      
      $mes = ($id)?$meses[$id]:$meses;
      return $mes;   
    }
    
   static function getAnos($qt=3){
   $anos = array();
    for($i=0;$i<$qt;$i++){
    $anos[date('Y')-$i] = date('Y')-$i;
    }
      return $anos;   
    }

    static  function  getPrefeituras(){
        $url = 'http://ampar.org.br/portal/api.php?method=Prefeitura';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $cidades = curl_exec($ch);
        $cidades = json_decode($cidades);

        $cidade  = array();
        foreach($cidades->prefeituras as $c){
            $cidade[$c->codigo] = $c->nome;
        }
        return $cidade;
    }
    static  function  getPrefeiturasFull(){
        try{
            $url = 'http://ampar.org.br/portal/api.php?method=Prefeitura&full';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $cidades = curl_exec($ch);
            $cidades = json_decode($cidades);
            curl_close($ch);
        }catch (Exception $e){
            die('Não foi possível carregar as Cidades devido :'.$e->getMessage());
        }
        return $cidades->prefeituras;
    }
    
    public static function TipoLivro($id = null) {
        $livro = [
            1 => "Partituras",
            2 => "Letras",
            3 => "Cinema",
            4 => "Humor",
            5 => "Poesia"
        ];
        if ($id == null) {
            return $livro;
        } else {
            return $livro[$id];
        }
    }
    
    
    

}
