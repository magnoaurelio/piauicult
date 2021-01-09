<?php
$tempo = 0;
$api = new Api();
$precodigo =  $_GET['precodigo'];
$filterAmpar = new Filter("precodigo","=", intval($precodigo));
$prefeitura = $api->getPrefeitura([$filterAmpar->getValue()], true);

$filterPref = new Filter("unidadeGestora","=",  $prefeitura->codigoUnidGestora);
$filters =  array();
$filters[] = $filterPref->getValue();
$secretarias = $api->getSecretaria($filters);
$secretaria = null;
if ($secretarias) {
    foreach ($secretarias as $sec){
        $cultura = false;
        if (strstr(strtolower($sec->secnome), "cultura")){
            $cultura = true;
            if (strstr(strtolower($sec->secnome), "agricultura")) {
                $cultura = false;
            }
        }
        if (!$cultura && strstr(strtolower($sec->secnome), "lazer")){
            $cultura = true;
        }

        if ($cultura) {
            $secretaria = $sec;
            break;
        }
    }
}


function FactorySecretaria(){
    $secretaria = new stdClass();
    $secretaria->secfoto = "user.png";
    $secretaria->secfotor = "user.png";
    $secretaria->secnome = "Indefinido";
    $secretaria->secusual = "Indefinido";
    $secretaria->secendereco = "Indefinido";
    $secretaria->secfone = "Indefinido";
    $secretaria->secemail = "Indefinido";
    return $secretaria;
}

$secretaria =  !$secretaria ? FactorySecretaria() : $secretaria;

//$preimagem = Imagem::getPrefeitura($cidade->prefoto, $cidade->codigoUnidGestora);
$secfoto =  Imagem::getPrefeitura($secretaria->secfoto,$prefeitura->codigoUnidGestora);
$secfotor =  Imagem::getPrefeitura($secretaria->secfotor,$prefeitura->codigoUnidGestora);
$imgp =  Imagem::getPrefeitura($prefeitura->prefoto,$prefeitura->codigoUnidGestora);
$brasao =  Imagem::getPrefeitura($prefeitura->prebrasao,$prefeitura->codigoUnidGestora);
$bandeira =  Imagem::getPrefeitura($prefeitura->prebandeira,$prefeitura->codigoUnidGestora);

?>
<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-12 columns">
            <article class="post group">
               <div class="large-12 columns">
            <article class="post group">
               
              <div class="large-8 columns">
                <?php
                $emissora = new Emissora($_GET['emicodigo']);
                $imgfoto = "admin/files/emissoras/" . trim($emissora->emifoto);
                $imgimagem = "admin/files/emissoras/" . trim($emissora->emiimagem);

                if (!file_exists($imgfoto) or ! is_file($imgfoto)):
                    $imgfoto = 'admin/files/imagem/user.png';
                endif;
                if (!file_exists($imgimagem) or ! is_file($imgimagem)):
                    $imgimagem = 'admin/files/imagem/galeria.png';
                endif;
                ?>
            
                     <?php
                        $precodigo = $_GET['precodigo'];
                        $prefeitura = new Read();
                        $prefeitura->ExeRead("prefeitura", "WHERE precodigo = $precodigo  ");
                         foreach($prefeitura->getResult() as $prefeitura){
                            $prenome = $prefeitura['prenome'];
                         }
                        ?>  
                    <h1 class="list-title">
                        <a href="?p=emissora&precodigo=<?= $precodigo?>" title="Voltar para página de EMISSORAS "> 
                            <!--img style="float: left;" src="<?=$brasao ?>" width="60" height="60" alt="" /> &nbsp; 
                        <img style="float: left;" src="<?=$bandeira ?>" width="80" height="60" alt="" /-->
                        <?= $prenome?>&nbsp;&nbsp;&nbsp;&nbsp; 
                        </a>
                         <?php if ($emissora->emivivo <> '') { ?>
                        <a href="?p=emissora&precodigo=<?= $precodigo?>" title="Voltar para página de EMISSORAS "> 
                             <img src="images/FONE DE OUVIDO0.png" width="80" height="80"  />
                          </a>
                         <?php }else{ ?>   
                        <a href="?p=emissora&precodigo=<?= $precodigo?>" title="Voltar para página de EMISSORAS "> 
                             <img src="images/FONE DE OUVIDO0.png" width="80" height="80"  />
                          </a>
                        <?php } ?>
                    </h1>
                    <h2 class="entry-title page-title"> 
                        <img src="<?= $imgfoto ?>" width="120" height="120"  /> 
                        <a href="<?=$emissora->emisite?>" target="_blanck" title="Veja o SITE da <?=$emissora->eminome?>">
                                <?= $emissora->eminome ?>&nbsp;
                        </a>
                    </h2>
                </div>
           
                      <?php
                $apremissora = $_GET['emicodigo'];
                $aprcodigo = $_GET['aprcodigo'];
                $apresentador = new Read();
                $apresentador->ExeRead("apresentador", "WHERE apremissora = $apremissora and aprcodigo = $aprcodigo ");
                ?>
                  
                 <?php 
                    foreach($apresentador->getResult() as $apresentador):
                            $aprcodigo = $apresentador['aprcodigo'];

                            $aprfoto = "admin/files/apresentador/" . trim($apresentador['aprfoto']);
                            if (!file_exists($aprfoto) or !is_file($aprfoto)):
                            $aprfoto = 'admin/files/imagem/user.png';
                            endif;
                    ?>
                    <div class="large-4 columns sidebar sidebar-1">
                       <aside class="widget group">
                           <ol class="widget-list widget-list-single" >
                            <li style="max-height: 250px; min-height: 250px; margin-bottom:0px; float: right;">
                                <figure class="event-thumb">
                                    <a  href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da: <?=$emissora->eminome?> e Veja: <?=$apresentador['aprnome']?>">
                                    <img src="<?=$aprfoto?>" width="250" height="250" alt="" />
                                    <!--div class="overlay icon-info-sign"></div-->
                                    </a>
                                </figure>
                                <h4 class="list-title"><a href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da <?=$emissora->eminome?>"><?= $apresentador['aprnome']?></a></h4>
                                <h5 class="list-title"><a  href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da <?=$emissora->eminome?>" title="Mais sobre... <?=$apresentador['aprfuncao']?>" class="action-btn"><?=$apresentador['aprfuncao']?></a></h5>
                            </li>
                  
                     </ol>
                    </aside>
                 </div> 
                 <?php  endforeach; ?>
                     
                 </article>
             </div> 
                   
            <div class="entry-content">
               <ol class="tracklisting">
                          <table width="100%" border="0" style="margin-left: 0px;">
                            <th width="100"><i class="icon-pencil"></i><a href="#">&nbsp;Programação</a> </th>
                            <th width="100"><i class="icon-calendar"></i><a href="#"> &nbsp;Data</a></th>
                            <th width="100"><i class="icon-microphone"></i><a href="#"> &nbsp;Apresentador</a></th>
                            <th width="100"><i class="icon-picture"></i><a href="#"> &nbsp;Foto</a></th>
                            <th width="100"><i class="icon-rss"></i><a href="#"> &nbsp;Programa</a></th>
                            <th width="100"><i class="icon-time"></i><a href="#"> &nbsp;Horário</a></th>
                            <th width="100"><i class="icon-music"></i><a href="#"> &nbsp;Músicas</a></th>
                           </table>
                        <?php
                         $procodigo = $_GET['procodigo'];
                         $programacoes =  new Read();
                         $programacoes->ExeRead("programacao","WHERE procodigo = $procodigo");
                         if($programacoes->getResult()) {
                             foreach ($programacoes->getResult() as $programacao){
                              //   var_dump($programacao);
                                 $aprcodigo = $programacao['aprcodigo'];
                                 $pronome = $programacao['pronome'];
                                 $prohorario = $programacao['prohorario'];
                             ?>
                        <li class="group track">
                            <table width="100%" border="0" style="margin-left: 0px;">
                                    <tr>
                                        <td width="100">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>&procodigo=<?= $procodigo ?>" id="" class="search-btn">
                                              <img src="images/piauicult.jpg" width="120" alt="" />
                                              <h4 class="track-title">
                                              PIUAICult - <?= $procodigo ?>
                                              </h4>
                                            </a> 
                                        </td>
                                         <td  width="100">
                                             <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>&procodigo=<?= $procodigo ?>" id="" class="search-btn">
                                                <h4 class="track-title"><?= DataCalendario::date2br($programacao['dataplay']) ?></h4>
                                             </a> 
                                        </td>
                                        <td  width="100">
                                             <?php
                                                $aprcodigo = $programacao['aprcodigo'];
                                                $apresentador = new Read();
                                                $apresentador->ExeRead("apresentador", "WHERE aprcodigo = $aprcodigo ORDER BY rand() limit 1");
                                                foreach($apresentador->getResult() as $apresentador){
                                                        $aprnome = $apresentador['aprnome'];
                                                        $aprfoto = "admin/files/apresentador/" . trim($apresentador['aprfoto']);
                                                        if (!file_exists($aprfoto) or !is_file($aprfoto)):
                                                        $aprfoto = 'admin/files/imagem/user.png';
                                                        endif;
                        
                                               ?>
                                             <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>&procodigo=<?= $procodigo ?>" id="" class="search-btn" id="" class=""> 
                                                <h4 class="track-title"><?= $aprnome ?></h4>
                                             </a> 
                                             <?php } ?>
                                        </td>
                                          <td width="100" style="padding-left: 0px;">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>&procodigo=<?= $procodigo ?>" id="" class="search-btn"" id="" class="search-btn">
                                            <img src="<?=$aprfoto?>" width="120" height="120" alt="" />
                                            </a> 
                                        </td>
                                       <?php
                                     //   $aprcodigo = $programacao['aprcodigo'];;
                                        $aprcodigo = $programacao['aprcodigo'];
                                        $programacao = new Read();
                                        $programacao->ExeRead("programacao", "WHERE aprcodigo = $aprcodigo ORDER BY rand() limit 1");
                                                foreach($programacao->getResult() as $programacao){
                                                $procodigo = $programacao['procodigo'];
                                                $aprcodigo = $programacao['aprcodigo'];
                                                $pronome = $programacao['pronome'];
                                                $prohorario = $programacao['prohorario'];
                                        ?>
                                      
                                         <td  width="100">
                                            <h4 class="track-title">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>&procodigo=<?= $procodigo ?>" id="" class="search-btn"" id="" class="search-btn">
                                                <?=$programacao['pronome']?>
                                            </a>
                                            </h4>
                                        </td>
                                         <td  width="100">
                                             <h4 class="track-title">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>&procodigo=<?= $procodigo ?>" id="" class="search-btn"" id="" class="search-btn">
                                                <?=$programacao['prohorario']?>
                                            </a>
                                            </h4>
                                        </td>
                                            <?php } ?>
                                        <?php
                                        $mus_tempo = 0;
                                        $mus_qte   = 0;
                                        $n = 0;
                                       // $procodigo = $programacao_musica['procodigo'];
                                        $programacao_musica = new Read();
                                        $programacao_musica->ExeRead("programacao_musica", "WHERE procodigo = $procodigo ");
                                                foreach($programacao_musica->getResult() as $programacao_musica){
                                                $mus_qte = $programacao_musica['procodigo'];
                                          //      $mus_qte = count( $mus_qte);
                                           //     $pronome = $programacao_musica['pronome'];
                                        ?>
                                         <?php 
                                         $n++;
                                          } ?>
                                        <td  width="50">
                                            <h4 class="track-title">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>&procodigo=<?= $procodigo ?>" id="" class="search-btn"" id="" class="search-btn">
                                                &nbsp;<?=$n?> 
                                            </a>
                                               musicas 
                                           </h4>
                                             
                                        </td>
                                        
                                         
                                          
                                    </tr>
                                </table>
                            </li> 
                            
                             <?php
                          }
                        }
                        ?>
                    </ol>
           </div>
            
                <div class="entry-content">
                    <h4 class="track-title">Repertório Programado <a href="#"><i class="icon-calendar"></i> &nbsp;Data:</a> <?= DataCalendario::date2br($programacao['dataplay']) ?></h4>

                    <ol class="tracklisting">
                          <table width="100%" border="0" style="background-color:#C9C9C9;">
                            <th width="10"><a href="#"><i class="icon-play"></i></a></th>
                            <th width="240" style="text-align: left;"><i class="icon-music"></i><a href="#"> &nbsp;Música</a></th>
                            <th width="100" style="text-align: left;"><i class="icon-bullseye"></i> &nbsp;<a href="#">Disco</a></th>
                            <th width="100" style="text-align: left;"><i class="icon-pencil"></i><a href="#"> &nbsp;Autor(es)</a></th>
                            <th width="100" style="text-align: left;"><i class="icon-microphone"></i><a href="#"> &nbsp;Intérprete(s)</a></th>
                            <th width="100" style="text-align: left;"><i class="icon-music"></i><a href="#"> &nbsp;Arranjador(es)</a></th>
                          </table>
                        <?php
                         $programacoes =  new Read();
                         $programacoes->ExeRead("programacao","WHERE procodigo = $procodigo");
                         if($programacoes->getResult()) {
                             foreach ($programacoes->getResult() as $programacao){
                              //   var_dump($programacao);
                                 $aprcodigo = $programacao['aprcodigo'];
                                 $procodigo = $programacao['procodigo'];
                                 $programacao_musica =  new Read();
                                 $programacao_musica->ExeRead("programacao_musica","WHERE procodigo = $procodigo");
                                 if($programacao_musica->getResult()) {
                                        foreach ($programacao_musica->getResult() as $programacao_musica){
                                         //   var_dump($programacao);
                                        //    $quantidade = $programacao_musica->getResult();
                                            $muscodigo = $programacao_musica['muscodigo'];
                                        
                             ?>
                     <?php   /** @MUSICA  <MUSICA>  */?>
                        <li class="group track">
                            <table width="100%" border="0" style="margin-left: 0px;">
                                    <tr>
                                      <?php
                                              //  $muscodigo = $programacao_musica['muscodigo'];;
                                              
                                                $musica = new Read();
                                                $musica->ExeRead("musica", "WHERE muscodigo = $muscodigo ");
                                                foreach($musica->getResult() as $musica){
                                                        $musnome   = $musica['musnome'];
                                                        $artcodigo = $musica['artcodigo'];
                                                        $gencodigo = $musica['gencodigo'];
                                                        $musautor  = $musica['musautor'];
                                                        $musduracao  = $musica['musduracao'];
                                                        $musarranjo  = $musica['musarranjo'];
                                                        $mustocada  = $musica['mustocada'];
                                                        $musbanda  = $musica['musbanda'];
                                                        $audio = "admin/files/musicas/audio/{$musica['musaudio']}";
                                                       // interprestes
                                                        $interpretes = Musica::getInterpretes($musica['muscodigo']);
                                                        $interpretes_format = [];
                                                        foreach ($interpretes as $interprete):
                                                            $interpretes_format[] = "<a target = '_blanck' href='?p=artist&id={$interprete->artcodigo}'>" . $interprete->artusual . "</a>"; //<a href='?p=artist&id={$interprete->artcodigo}'>" . $interprete->artusual . "</a>
                                                        endforeach;
                                                        $interpretes_format = implode(" , ", $interpretes_format);
                                                        
                                                        // autores
                                                        $autores = Musica::getAutores($musica['muscodigo']);
                                                        $autores_format = [];
                                                        foreach ($autores as $autor):
                                                            $autores_format[] = "<a target = '_blanck' href='?p=artist&id={$autor->artcodigo}'>" . $autor->artusual . "</a>"; //<a href='?p=artist&id={$autor->artcodigo}'>" . $autor->artusual . "</a>
                                                        endforeach;
                                                        $autores_format = implode(" , ", $autores_format);

                                                        // aranjos
                                                        $arranjos = Musica::getArranjos($musica['muscodigo']);
                                                        $arranjos_format = [];
                                                        foreach ($arranjos as $arranjo):
                                                            $arranjos_format[] = "<a target = '_blanck' href='?p=artist&id={$arranjo->artcodigo}'>" . $arranjo->artusual . "</a>"; //<a href='?p=artist&id={$arranjo->artcodigo}'>" . $arranjo->artusual . "</a>
                                                        endforeach;
                                                        $arranjos_format = implode(" , ", $arranjos_format);

                                                        if (!file_exists($audio) or ! is_file($audio)):
                                                            $audio = "#";
                                                        endif;
                                               ?> 
                                       
                                        <td  width="300">
                                            <a href="#" id="" class="media-btn">
                                             <?php if ($musica['musativo'] == "S"): ?>
                                                <a href="<?= $audio ?>" id="<?= $musica['muscodigo'] ?>"  class="media-btn btn-play">Play</a>
                                            <?php else: ?>
                                                <a id="<?= $musica['muscodigo'] ?>" class="media-btn" style="background-color:#CCC;">Play</a>
                                            <?php endif; ?>
                                            </a> 
                                            
                                               <?php if ($musica['letativo'] == "S"): ?>
                                                <a title="Veja a LETRA desta MÚSICA" href="admin/files/musicas/letra/<?= $musica['musletra'] ?>"  onclick="Topo()" data-rel="prettyPhoto" class="action-btn">
                                                    <img src="/images/icone/letra.fw.png" width="15"> Letra
                                                </a>&nbsp;
                                             <?php else: ?>
                                                 <a data-rel="prettyPhoto"   onclick="Topo()" class="action-btn" style="background-color:#CCC;">Letra</a>
                                             <?php endif; ?>
                                                 <?php
                                                  
                                                  //  $livro = Disco::getLivro($disco_musica->discodigo);
                                                  //   if (!$livro->livtipo){
                                                   //      $livro->livtipo = 2;
                                                   //  }
                                                  //  if ($musica['livativo'] == "S" && $livro): ?>
                                                   <!--a title="Veja o ENCARTE deste DISCO" href="livro.php?livcodigo=<?= $livro['livcodigo'] ?>" target="_blank"   onclick="Topo()" class="action-btn">
                                                       <img src="/images/icone/book.fw.png" width="15">&nbsp;<?=DadosFixos::TipoLivro($livro->livtipo)?>
                                                   </a-->&nbsp;
                                                   <?php //else: ?>
                                                       <!--a  onclick="Topo()" class="action-btn" style="background-color:#CCC;"><i class="fa fa-book"></i> Cancioneiro/Encarte</a-->
                                                   <?php //endif; ?>
                                                    <?php if ($musica['vidativo'] == "S"): ?>
                                                      <a title="Veja o VÍDEO desta MUSICA" href="<?= $musica['musvideo'] ?>" data-rel="prettyPhoto"   onclick="Topo()" class="action-btn">
                                                          <img src="/images/icone/video1.fw.png" width="15">&nbsp;Vídeo
                                                      </a>&nbsp;
                                                   <?php else: ?>
                                                    <a data-rel="prettyPhoto"   onclick="Topo()" class="action-btn" style="background-color:#CCC;">Vídeo</a>
                                                   <?php endif; ?>
                                                <a href="#" id="" class=""> 
                                                 <h4 class="track-title"><?= $musnome ?></h4><br>
                                                 <h6 class="track-title"><a href="#"><i class="icon-time"></i> Duração:&nbsp;&nbsp; </a><?= $musduracao ?></h6>
                                                 <h6 class="track-title"><a href="#"><i class="icon-microphone"></i> + Tocadas:&nbsp;&nbsp;</a><?= $mustocada ?></h6>
                                                 <?php
                                                    $gencodigo = $musica['gencodigo'];;
                                                    $genero = new Read();
                                                    $genero->ExeRead("genero", "WHERE gencodigo = $gencodigo ");
                                                    foreach($genero->getResult() as $genero){
                                                            $gennome = $genero['gennome'];
                                                    } 
                                                 ?>
                                                 <h6 class="track-title"><i class="icon-music"></i> Gênero:&nbsp;&nbsp;<a href="?p=estilos&genero=<?= $genero['gencodigo'] ?>" title="Veja todas as Musicasdo estilo: <?= $gennome ?> "><?= $gennome ?></a></h6>
                                             </a> 
                                            
                                        </td>
                                        <?php   /** @DISCO  <DISCO>  */?>
                                         <td  width="150">
                                            <a href="#" id="" class="search-btn">
                                                <?php
                                                $discodigo = $musica['musbanda'];;
                                                $disco = new Read();
                                                $disco->ExeRead("disco", "WHERE discodigo = $musbanda ");
                                                foreach($disco->getResult() as $disco){
                                                        $disnome = $disco['disnome'];
                                                        $disimagem = $disco['disimagem'];
                                                      
                                                        
                                                       $disimagem = "admin/files/discos/" . trim($disimagem);
                                                      if (!file_exists($disimagem) or !is_file($disimagem)):
                                                       $disimagem = 'admin/files/imagem/user.png';
                                                       endif;
                                                         } 
                                               ?>
                                                <img src="<?=$disimagem?>" width="120" height="120" alt="" /><br>
                                                <h6 class="track-title"><?= $disnome ?></h6>
                                            </a>
                                        </td>
                                          <?php   /** @AUTOR  <AUTOR>  */?>
                                      <td width="150">
                                             <?php
                                                $artcodigo = $musica['artcodigo'];;
                                                $artista = new Read();
                                                $artista->ExeRead("artista", "WHERE artcodigo = $musautor ");
                                                foreach($artista->getResult() as $artista){
                                                        $artnome = $artista['artnome'];
                                                        $artusual = $artista['artusual'];
                                                        $artfoto  = $artista['artfoto'];
                                                        
                                                       $artfoto = "admin/files/artistas/" . trim($artfoto);
                                                      if (!file_exists($artfoto) or !is_file($artfoto)):
                                                       $artfoto = 'admin/files/imagem/user.png';
                                                       endif;
                                                         } 
                                               ?>
                                               <img src="<?=$artfoto?>" width="120" height="120" alt="" /><br>
                                               <h6 class="track-title"><?=  $autores_format ?></h6>
                                        </td>
                                           <?php   /** @INTERPRETE  <INTERPRETE>  */?>
                                          <td width="150">
                                              <?php
                                                $artcodigo = $musica['artcodigo'];;
                                                $artista = new Read();
                                                $artista->ExeRead("artista", "WHERE artcodigo = $artcodigo ");
                                                foreach($artista->getResult() as $artista){
                                                        $artnome = $artista['artusual'];
                                                        $artusual = $artista['artusual'];
                                                        $artfoto  = $artista['artfoto'];
                                                        
                                                       $artfoto = "admin/files/artistas/" . trim($artfoto);
                                                      if (!file_exists($artfoto) or !is_file($artfoto)):
                                                       $artfoto = 'admin/files/imagem/user.png';
                                                       endif;
                                                         } 
                                               ?>
                                              <img src="<?=$artfoto?>" width="120" height="120" alt="" /><br>
                                                 <h6 class="track-title"><?=  $interpretes_format ?></h6>
                                                 
                            
                                          </td>
                                           <?php   /** @ARRANJADOR  <ARRANJADOR>  */?>
                                          <td  width="150">
                                            <a href="#" id="" class="search-btn">
                                                <?php
                                                $artcodigo = $musica['artcodigo'];;
                                                $artista = new Read();
                                                $artista->ExeRead("artista", "WHERE artcodigo = $musarranjo ");
                                                foreach($artista->getResult() as $artista){
                                                        $artnome = $artista['artusual'];
                                                        $artusual = $artista['artusual'];
                                                        $artfoto  = $artista['artfoto'];
                                                  
                                                       $artfoto = "admin/files/artistas/" . trim($artfoto);
                                                       if (!file_exists($artfoto) or !is_file($artfoto)):
                                                       $artfoto = 'admin/files/imagem/user.png';
                                                       endif;
                                                         } 
                                               ?>
                                                 <img src="<?=$artfoto?>" width="120" height="120" alt="" /><br>
                                                 <h5 class="track-title"><?=  $arranjos_format ?></h5>
                                            </a>
                                        </td>
                                     
                                        <?php 
                                      //     $minuto  = fixHour($musduracao);
                                         $minuto  = intval(substr($musduracao,0,2));
                                         $segundo = substr($musduracao,3,2);
                                         $juntos = $minuto.".".$segundo;
                                    //     var_dump($juntos);
                                         $soma = fixHour($juntos);
                                         $tempo = fixHour($tempo + $soma);
                                         $minuto=0;
                                         $segundo=0;
                                        } 
                                        ?>  
                                    </tr>
                                </table>
                            </li> 
                            
                             <?php
                             } 
                           }
                          }
                        }
                        ?>
                         <script>
                            var musica_tocando = null;
                            player_tocando = true
                            $('.media-btn').click(function (e) {
                                if (musica_tocando === e.target.id && player_tocando === false) {
                                    player.play(player.index)
                                    player_tocando = true
                                } else {
                                    player.pause()
                                    player_tocando = false
                                    musica_tocando = e.target.id
                                }
                            })
                        </script>
                    </ol>
            
                </div>
            
               </article>
        </div>
          <?php
            function fixHour($num)
            {
                $decimal = $num - floor($num); // A função floor arredonda o número para o próximo menor valor inteiro

                if ($decimal >= 0.60) {
                    $num = ($num + 1) - 0.60;
                    return fixHour($num); // Recursão
                }

                return $num;
            }
     
         ?>
           <div class="large-12 columns sidebar sidebar-1">
                <aside class="widget group">
                    <ol class="widget-list widget-list-single" >
                     <li>
                         <h4 class="track-title"><a href="#">
                             <i class="icon-time"></i>  Duração Total: </a>
                             &nbsp;&nbsp;<?=$tempo?> minutos
                         </h4>
                     </li>
                   </ol>
             </aside>
          </div> 
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    function BuscaID(str,id) {
      var pos1 = str.search("users/");
      var pos2 = str.search("&amp;");
      var codigo = str.substring(pos1+6,pos2)
      $("#"+id).val(codigo)
    }
</script>