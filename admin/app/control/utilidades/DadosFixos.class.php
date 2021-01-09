<?php
class DadosFixos{
    
     public static function getLimits($id = null) {
        $limit = [
            5 => "Documentário"
        ];
        if ($id == null) {
            return $limit;
        } else {
            return $limit[$id];
        }
    }
     public static function TipoVideo($id = null) {
        $video = [
            1 => "Documentário",
            2 => "Entrevista",
            3 => "Espetáculo",
            4 => "Pessoal",
            5 => "Apresentação",
            6 => "Festival",
            7 => "Outro"
        ];
        if ($id == null) {
            return $video;
        } else {
            return $video[$id];
        }
    }
    
    
    static function tipoAssessor($id=null){
        $tipo_c = [
            'A'=>'Assessor',
            'C'=>'Contrato',
            'S'=>'Secretaria'
           
        ];
        if($id==null){
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }
    static function tipoImagem($id=null){
        $tipo_c = [
            '0'=>'Inspiradora',
            '1'=>'Relacionada',
            '2'=>'Unidades',
            '3'=>'Turismo'
        ];
        if($id==null){
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }

   static function extensaoDoc(){
     return ["pdf","doc",'jpg','jpeg','PDF'];
   }

    static function extensaoImagem(){
        return ["jpg","JPG",'png','PNG','jpeg','JPEG','gif','GIF'];
    }

    static function tipoUsuario($id=null){
        $tipos = [
            "Padrão",
            "Admin",
        ];
        if ($id) return $tipos[$id];
        return $tipos;
    }

    static function getColor($id=null){
        $tipos = self::getArquivosCores();
        if ($id) return $tipos[$id];
        return $tipos;
    }

    static function getArquivosCores()
    {
        $entries = array();
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/templates/theme4/css/color/'),
            RecursiveIteratorIterator::CHILD_FIRST) as $arquivo) {
            if (substr($arquivo, -4) == '.css') {
                $name = $arquivo->getFileName();
                $pieces = explode('.', $name);
                $class = (string)$pieces[0];
                $entries[$class] = $class;
            }
        }
        ksort($entries);
        return $entries;
    }


    static function Escolaridade($id=null){
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
        if($id==null){
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }
    static function EstadoCivil($id=null){
        $tipo_c = [
            'Solteiro(a)',
            'Casado(a)',
            'Viúvo(a)',
            'Separado(a) Judicial',
            'Divorciado (a)'
        ];
        if($id==null){
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }

    static function Genero($id=null){
        $tipo_c = [
            'M'=>'Masculino',
            'F'=>'Feminino'
        ];
        if($id==null){
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }

    static function Pretipo($id=null){
        $tipo_c = [
            'Prefeito',
            'Vice'
        ] ;

        if($id==null){
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }


    static function Parentesco($id=null){
        $tipo_c = array(
            'Cônjuge/Companheiro',
            'Ex- cônjuge/ Ex- companheiro',
            'Filho',
            'Enteado',
            'Tutelado',
            'Pai/mãe',
            'Irmão',
            'Outros');
        if($id==null){
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }

    static function Categoria($id=null){
        $tipo_c = array(
            1=> 'Saúde',
                'Educação',
                'Cidadania',
                'Obras',
                'Esportes',
                'Religioso',
                'Turismo',
                'Lazer',
                'Tecnologia',
                'Finanças',
                'Política',
                'Agronegócio',
                'Cultura',
                'Geral'
            );
        if($id==null){
            asort($tipo_c);
            return $tipo_c;
        }else{
            return $tipo_c[$id];
        }
    }



    public static function getLogoPreampar($preampar)
    {
        switch ($preampar){
            case 'ampar':
                return "files/associacao/ampar.png";
            default:
                return "files/associacao/piaui.png";
        }
    }

    static function tipoHospedagens($id = null) {

        $tipos = [
            1 => "Pousada",
            "Hotel",
            "Motel",
            "Pensões",
            "Casa de Aluguel"
        ];

        if ($id):
            return $tipos[$id];
        else:
            return $tipos;
        endif;
    }

    static function getUrlVideo($url){
        $pos = strripos($url, "v=");
        if ($pos):
           return  substr($url, $pos + 2, 11);
        else:
            $pos = strripos($url, ".be/");
            if ($pos):
               return substr($url, $pos + 4, 11);
            else:
                throw new Exception("Problemas com a URL do vídeo");
            endif;
        endif;
    }

    static function tipoServicosBancarios($id = null) {

        $tipos = [
            1 => "Lotérica",
            "Pague Contas",
            "Correios",
            "Caixa Rápido",
            "Caixa de Câmbio"
        ];

        if ($id):
            return $tipos[$id];
        else:
            return $tipos;
        endif;
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
    
     public static function LivroCategoria($id = null) {
        $livro = [
            1 => "Cancioneiro",
            2 => "Encarte",
        ];
        if ($id == null) {
            return $livro;
        } else {
            return $livro[$id];
        }
    }

}
