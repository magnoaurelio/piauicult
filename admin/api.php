<?php
require_once 'init.php';
new TSession;

    if(isset($_REQUEST['method'])){
       $param = $_REQUEST;
       if(function_exists($_REQUEST['method'])){
           $_REQUEST['method']($param);  
       }
    }
    #----------------------------------------------------------
    // musica mais tocada
    function setMusicaTocada($param){
     try{
         TTransaction::open('conexao');
         if(!isset($param['muscodigo']))
             throw new Exception("muscodigo nulo");
         $musica = new Musica($param['muscodigo']);
         $musica->mustocada ++;
         $musica->store();  
         TTransaction::close();
         echo json_encode(['result'=>True]);
     }catch(Exception $e){
         echo json_encode(['result'=>False]);
     }
     
    }
    
    # -------------------------------------------------------    
     // disco mais acessado
    function setDiscoAcesso($param){
     try{
         TTransaction::open('conexao');
         if(!isset($param['discodigo']))
             throw new Exception("discodigo nulo");
         $disco = new Disco($param['discodigo']);
         $disco->disacesso ++;
         $disco->store();  
         TTransaction::close();
         echo json_encode(['result'=>True]);
     }catch(Exception $e){
         echo json_encode(['result'=>False]);
     }
     
    }
   # -----------------------------------------------------------
    // serviço mais acessado
    function setArtistaAcesso($param){
     try{
         TTransaction::open('conexao');
         if(!isset($param['artcodigo']))
             throw new Exception("artista nulo");
         $artista = new Artista($param['artcodigo']);
         $artista->artacesso ++;
         $artista->store();  
         TTransaction::close();
         echo json_encode(['result'=>True]);
     }catch(Exception $e){
         echo json_encode(['result'=>False]);
     }
     
    }
    
    # -------------------------------------------------------    
     // pegar todas as musicas
    function getMusicasAll($param){
     try{
         TTransaction::open('conexao');
         $repo = new \Adianti\Database\TRepository('Musica');
         $criteira = new \Adianti\Database\TCriteria();
         $criteira->setProperty("order","musnome");
         $collections = $repo->load($criteira);
         $tm =  $repo->count($criteira);
         $musicasall = array();
         if($collections){
             $musicas = array();
             foreach ($collections as $musica){
                 if($musica->musativo == "N"){
                    $musica->mustocada = 0;
                    $musica->store();
                    continue;                 
                 }
                 $filenamme =  "files/musicas/audio/".$musica->musaudio;
                 $artista =  new Artista($musica->artcodigo);
                 $title = "<img src=admin/files/artistas/".trim($artista->artfoto)." width=25 height=25> &nbsp; ".$musica->musnome."-".$artista->artusual;
                 if(!empty($musica->musnome) && file_exists($filenamme) && $musica->musativo == "S" ){
                    $musicas[] = ["codigo"=>$musica->muscodigo,"title" =>$title, "file"=>$musica->musaudio, "howl"=>null];
                  }
             }
             $musicasall["musicas"] = $musicas;


         }
         $musicasall["size"] = $tm;
         TTransaction::close();
         echo json_encode($musicasall);
     }catch(Exception $e){
         echo json_encode(['result'=>False]);
     }
     
    }


    # -------------------------------------------------------
    // pegar todas as musicas
    function getMusicasDisco($param){
        try{
            TTransaction::open('conexao');
            $disco =  new Disco($param['discodigo']);
            $collections =  $disco->getMusicas();
            $musicasall = array();
            if($collections){
                $musicas = array();
                foreach ($collections as $musica){                    $filenamme =  "files/musicas/audio/".$musica->musaudio;
                    $artista =  new Artista($musica->artcodigo);
                    $title = "<img src=admin/files/artistas/".trim($artista->artfoto)." width=25 height=25> &nbsp; ".$musica->musnome."-".$artista->artusual;
                    
                    if(!empty($musica->musnome) && file_exists($filenamme) )
                        $musicas[] = ["title" =>$title, "file"=>$musica->musaudio, "howl"=>null];
                }
                $musicasall["musicas"] = $musicas;


            }
            $musicasall["size"] = sizeof($collections);
            TTransaction::close();
            echo json_encode($musicasall);
        }catch(Exception $e){
            echo json_encode(['result'=>False]);
        }

    }
    
    
     # -------------------------------------------------------
    // pegar todos os usuários do sistema
    function getUsuarios($param){
        try{
            TTransaction::open('permission');
            $repo = new TRepository('SystemUser');
            $criteria = new TCriteria;
            if(isset($param['filter']) and is_array($param['filter']) and sizeof($param['filter'])==3){
              $criteria->add(new TFilter($param['filter'][0],$param['filter'][1],$param['filter'][2]));
             }
             
             $collections = $repo->load($criteria);
             if($collections){
                foreach ($collections as $key=>$user){
                  $collections[$key] = ((array)$user->toArray());
                }
          
              }
            TTransaction::close();
            echo json_encode($collections);
        }catch(Exception $e){
            echo json_encode(['result'=>False]);
        }

    }
