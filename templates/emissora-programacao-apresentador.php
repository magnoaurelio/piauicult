<?php
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
                <header class="entry-top special-top">
                     <?php
                        $precodigo = $_GET['precodigo'];
                        $prefeitura = new Read();
                        $prefeitura->ExeRead("prefeitura", "WHERE precodigo = $precodigo  ORDER BY precodigo limit 1 ");
                         foreach($prefeitura->getResult() as $prefeitura){
                            $prenome = $prefeitura['prenome'];
                         }
                        ?>  
                    <h1 class="list-title">
                        <a href="?p=emissora&precodigo=<?= $precodigo?>" title="Voltar para página de EMISSORAS "> 
                            <!--img style="float: left;" src="<?=$brasao ?>" width="60" height="60" alt="" /> &nbsp; 
                        <img style="float: left;" src="<?=$bandeira ?>" width="80" height="60" alt="" /-->
                        <?= $prenome?>&nbsp;&nbsp;&nbsp;&nbsp; <!--i class="icon-reply"></i-->
                        </a>
                    </h1>
                    <h2 class="entry-title page-title"> 
                        <img src="<?= $imgfoto ?>" width="80" height="80"  /> 
                        
                        <a href="<?=$emissora->emisite?>" target="_blanck" title="Veja o SITE da <?=$emissora->eminome?>">
                                <?= $emissora->eminome ?>&nbsp;-  Programações
                        </a>
                        
                        <?php if ($emissora->emivivo <> '') { ?>
                         <a href="<?=$emissora->emivivo?>" target="_blanck" title="Ouça Ao Vivo <?=$emissora->eminome?>">
                             <img src="images/FONE DE OUVIDO0.png" width="80" height="80"  />
                          </a>
                         <?php }else{ ?>   
                             <a href="<?=$emissora->emisite?>" target="_blanck" title="Veja o SITE da: <?=$emissora->eminome?>">
                             <img src="images/FONE DE OUVIDO0.png" width="80" height="80"  />
                          </a>
                        <?php } ?>
                    </h2>
                </header>
                 <!--h4>
                     &nbsp;
                       <a href="<?=$emissora->emisite?>" target="_blanck" title="Veja o SITE da <?=$emissora->eminome?>">
                           &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#000;font-size: 22;">
                           Profissionais</span> 
                       </a>
                   </h4-->
                <?php
                $apremissora = $_GET['emicodigo'];
                $aprcodigo = $_GET['aprcodigo'];
                $apresentador = new Read();
                $apresentador->ExeRead("apresentador", "WHERE apremissora = $apremissora and aprcodigo = $aprcodigo ORDER BY rand() limit 10");
                ?>
               
                 <article class="post group">
                  
                 <?php 
                    foreach($apresentador->getResult() as $apresentador):
                            $aprcodigo = $apresentador['aprcodigo'];

                            $aprfoto = "admin/files/apresentador/" . trim($apresentador['aprfoto']);
                            if (!file_exists($aprfoto) or !is_file($aprfoto)):
                            $aprfoto = 'admin/files/imagem/user.png';
                            endif;
                    ?>
                    
                    <!--div class="large-4 columns sidebar sidebar-1">
                       <aside class="widget group" style="margin-bottom: 0px;">
                           <ol class="widget-list widget-list-single" >
                            <li style="max-height: 300px; min-height: 300px; margin-bottom:0px;">
                                <figure class="event-thumb">
                                    <a  href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da: <?=$emissora->eminome?> e Veja: <?=$apresentador['aprnome']?>">
                                    <img src="<?=$aprfoto?>" width="250" height="250" alt="" />
                                    <div class="overlay icon-info-sign"></div>
                                    </a>
                                </figure>
                                <h4 class="list-title"><a href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da <?=$emissora->eminome?>"><?= $apresentador['aprnome']?></a></h4>
                                <h5 class="list-title"><a  href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da <?=$emissora->eminome?>" title="Mais sobre... <?=$apresentador['aprfuncao']?>" class="action-btn"><?=$apresentador['aprfuncao']?></a></h5>
                            </li>
                  
                     </ol>
                    </aside>
                 </div--> 
                 <?php  endforeach; ?>
                 </article> 
           <div class="entry-content">
               <ol class="tracklisting">
                          <table width="100%" border="0" style="margin-left: 0px;">
                            
                            <th width="100"><a href="#"><i class="icon-pencil"></i> &nbsp;Programação</a></th>
                            <th width="100"><a href="#"><i class="icon-pencil"></i> &nbsp;Data</a></th>
                            <th width="100"><a href="#"><i class="icon-microphone"></i> &nbsp;Apresentador</a></th>
                            <th width="50"><a href="#"><i class="icon-picture"></i> &nbsp;Foto</a></th>
                            <th width="100"><a href="#"><i class="icon-music"></i> &nbsp;Músicas</a></th>
                            <th width="100"><a href="#"><i class="icon-time"></i> &nbsp;Duração Total</a></th>
                            
                           </table>
                        <?php
                         $mus_qte = 0;
                         $mus_tempo = 0;
                         $programacoes =  new Read();
                         $programacoes->ExeRead("programacao","WHERE emicodigo = :cod", "cod={$emissora->emicodigo}");
                         if($programacoes->getResult()) {
                             foreach ($programacoes->getResult() as $programacao){
                              //   var_dump($programacao);
                                 $aprcodigo = $programacao['aprcodigo'];
                             ?>
                        <li class="group track">
                            <table width="100%" border="0" style="margin-left: 0px;">
                                    <tr>
                                        <td width="100">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn">
                                              <img src="images/piauicult.jpg" width="120" alt="" />
                                              PIUAICult
                                            </a> 
                                        </td>
                                         <td  width="100">
                                             <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn">
                                                <h4 class="track-title"><?= DataCalendario::date2br($programacao['dataplay']) ?></h4>
                                             </a> 
                                        </td>
                                        <td  width="100">
                                             <?php
                                                $aprcodigo = $programacao['aprcodigo'];;
                                                $apresentador = new Read();
                                                $apresentador->ExeRead("apresentador", "WHERE aprcodigo = $aprcodigo ORDER BY rand() limit 1");
                                                foreach($apresentador->getResult() as $apresentador){
                                                        $aprnome = $apresentador['aprnome'];
                                                        $aprfoto = "admin/files/apresentador/" . trim($apresentador['aprfoto']);
                                                        if (!file_exists($aprfoto) or !is_file($aprfoto)):
                                                        $aprfoto = 'admin/files/imagem/user.png';
                                                        endif;
                        
                                               ?>
                                             <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn"" id="" class=""> 
                                                <h4 class="track-title"><?= $aprnome ?></h4>
                                             </a> 
                                             <?php } ?>
                                        </td>
                                          <td width="100" style="padding-left: 0px;">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn"" id="" class="search-btn">
                                            <img src="<?=$aprfoto?>" width="120" height="120" alt="" />
                                            </a> 
                                            
                                        </td>
                                         <td  width="100">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn"" id="" class="search-btn">
                                                <?=$mus_tempo?>
                                            </a>
                                           musicas 
                                        </td>
                                         <td  width="50">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn"" id="" class="search-btn">
                                                <?=$mus_qte?>
                                            </a>
                                              horas
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
               
         </article>
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