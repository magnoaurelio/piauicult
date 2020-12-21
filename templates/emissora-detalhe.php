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
        <div class="large-9 columns">
            <article class="post group">
                <?php
                $emissora = new Emissora($_GET['id']);
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
                        <a href="?p=emissora&id=<?=$_GET['id']?>" title="Voltar para página de EMISSORAS "> 
                            <!--img style="float: left;" src="<?=$brasao ?>" width="60" height="60" alt="" /> &nbsp; 
                        <img style="float: left;" src="<?=$bandeira ?>" width="80" height="60" alt="" /-->
                        <?= $prenome?>&nbsp;&nbsp;&nbsp;&nbsp; <!--i class="icon-reply"></i-->
                        </a>
                    </h1>
                    <h2 class="entry-title page-title"> 
                        <img src="<?= $imgfoto ?>" width="80" height="80"  /> 
                        
                        <a href="<?=$emissora->emisite?>" target="_blanck" title="Veja o SITE da <?=$emissora->eminome?>">
                                <?= $emissora->eminome ?>&nbsp;<span style="color:#000;font-size: 22;">(Emissora)</span>
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
                 <h4>
                     &nbsp;
                       <a href="<?=$emissora->emisite?>" target="_blanck" title="Veja o SITE da <?=$emissora->eminome?>">
                           &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#000;font-size: 22;">
                           Profissionais</span> 
                       </a>
                   </h4>
                <?php
                $apremissora = $_GET['id'];
                $apresentador = new Read();
                $apresentador->ExeRead("apresentador", "WHERE apremissora = $apremissora ORDER BY rand() limit 10");
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
                    
                    <div class="large-4 columns sidebar sidebar-1">
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
                 </div> 
                 <?php  endforeach; ?>
                 </article> 
                
                <div class="entry-content">
                <ul class="cpt-meta">
                    <li><span>Cidade: </span><?=$prenome?></li>
                    <li><span>Estado: </span><?=$emissora->emiestado?></li>
                    <li><span>Endereço:</span> <?=$emissora->emiendereco?></li>
                    <li><span>Bairro: </span><?=$emissora->emibairro?></li>
                    <li><span>Cep:</span> <?=$emissora->emicep?></li>
                    <li><span>Contato:</span> <?=$emissora->emicontato?></li>
                    <li><span>Email: </span> <?=$emissora->emiemail?></li>
                    <li><span>Site: </span>
                        <a  href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da <?=$emissora->eminome?> " ><?=$emissora->emisite?>
                        </a>
                    </li>
                    <li><h3>Sobre:</h3><span style="width: 100%;"><?=$emissora->emisobre?></span></li>
                </ul>
                    <h3>Programações</h3>
                    
                    <ol class="tracklisting">
                          <table width="100%" border="0" style="margin-left: 0px;">
                            
                            <th width="100"><a href="#"><i class="icon-pencil"></i> &nbsp;Programação</a></th>
                            <th width="75"><a href="#"><i class="icon-calendar"></i> &nbsp;Data</a></th>
                            <th width="100"><a href="#"><i class="icon-microphone"></i> &nbsp;Apresentador</a></th>
                            <th width="50"><a href="#"><i class="icon-picture"></i> &nbsp;Foto</a></th>
                            <th width="100"><a href="#"><i class="icon-music"></i> &nbsp;Músicas</a></th>
                            <th width="100"><a href="#"><i class="icon-time"></i> &nbsp;Duração</a></th>
                            
                           </table>
                        <?php
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
                                              <img src="images/piauicult.jpg" width="70" alt="" />
                                              PIUAICult
                                            </a> 
                                        </td>
                                        <td  width="100">
                                             <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="">
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
                                             <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class=""> 
                                                <h4 class="track-title"><?= $aprnome ?></h4>
                                             </a> 
                                             <?php } ?>
                                        </td>
                                          <td width="100" style="padding-left: 0px;">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn">
                                            <img src="<?=$aprfoto?>" width="70" height="70" alt="" />
                                            </a> 
                            
                                        </td>
                                         <td  width="100">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn">
                                            <img src="images/FONE DE OUVIDO0.png" width="70" alt="" />
                                            </a>
                                        </td>
                                         <td  width="100">
                                            <a href="?p=emissora-programacao&emicodigo=<?= $emissora->emicodigo ?>&precodigo=<?= $precodigo ?>&aprcodigo=<?= $aprcodigo ?>" id="" class="search-btn">
                                              <img src="images/FONE DE OUVIDO0.png" width="70" alt="" />
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </li> 
                            
                             <?php
                          }
                        }
                        ?>
                    </ol>
            </article>
        </div>
        <div class="large-3 columns sidebar sidebar-1">
            <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgfoto ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgfoto ?>" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                        </figure>
                        Site:<br>
                        <a  href="<?=$emissora->emisite?>" target="_blanck" title="Acesse o SITE da <?=$emissora->eminome?> " ><?= $emissora->emisite?>
                        </a>
                    </li>
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgimagem ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgimagem ?>" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                        </figure>
                       
                    
               <aside class="widget group">
                   <h4 class="list-subtitle" >Redes Sociais</h4>  
                 <ol class="widget-list widget-list-single">
                   
                   
                  <nav id="nav">
                      <ul id="navigation" class="group" >
                          
                         
                      <li width = "40">
                         <a href="<?= $emissora->emifacebook ?>" target="_blank" class="" title="Siga <?= trim($emissora->eminome) ?> no Facebook.  ">
                             <img class="par" width="28" height="28" src="images/facebook1.png"/>
                         </a>
                      </li>
                      <li>
                         <a href="<?= $emissora->emiinstagram ?>" target="_blank" class="" title="Siga  <?= trim($emissora->eminome) ?> no Instagram.">
                              <img class="par" width="28" height="28" src="images/instagram1.png"/>
                         </a>
                      </li>
                      <li>
                         <a href="<?= $emissora->emitwitter ?>" target="_blank" class="" title="Siga <?= trim($emissora->eminome) ?> no Twitter." >
                              <img class="par" width="28" height="28" src="images/twitter1.png"/>
                         </a>
                      </li>
                      <li>
                         <a href="<?= $emissora->emiyuotube ?>" target="_blank" class="" title="Siga  <?= trim($emissora->eminome) ?> no Yuo Tube.">
                              <img class="par" width="28" height="28" src="images/yuotube1.png"/>
                         </a>
                       </li>
                      <li>
                         <a href="<?= $emissora->emiwhatsapp ?>" target="_blank" class="" title="Siga <?= trim($emissora->eminome) ?> no WhatsApp.">
                            <img class="par" width="28" height="28" src="images/whatsapp1.png"/>
                         </a>
                       </li>
                    </ul>
                  </nav>
                  </ol>
                   </li>
           </aside><!-- /widget -->
                </ol>
                
            </aside><!-- /widget -->
               <aside class="widget group">
                   <h3 class="widget-title">
                <a href="<?= $secretaria->secsite ?>" target="_blank" class="" title="Site Oficial <?= trim($secretaria->secnome) ?>.">
                  <?= $secretaria->secnome?>
                </a>
                       </h3>
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $secfoto ?>" data-rel="prettyPhoto">
                                <img src="<?= $secfoto ?>" />
                                <div class="overlay icon-zoom-in"></div>
                            </a>
                        </figure>
                    </li>
                </ol>
                 <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $secfotor ?>" data-rel="prettyPhoto">
                                <img src="<?= $secfotor ?>" />
                                <div class="overlay icon-zoom-in"></div>
                            </a>
                        </figure>
                    </li>
                </ol>
                <ol class="tracklisting tracklisting-top">
                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Secretário(a):</h5>
                        <h4 class="track-title">&nbsp;<?= $secretaria->secusual?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Endereço:</h5>
                        <h4 class="track-title">&nbsp;<?= $secretaria->secendereco ?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Fone:</h5>
                        <h4 class="track-title">&nbsp;<?= $secretaria->secfone ?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Email:</h5>
                        <h4 class="track-meta">&nbsp;<?= $secretaria->secemail ?></h4>
                    </li>
                    
                    <li class="group track">
                        <a class="fa fa-globe"></a>
                        <h5 class="track-meta">Site:</h5>
                        <h4 class="track-meta">
                        <a href="<?= $secretaria->secsite ?>" target="_blank" class="" title="Site Oficial <?= trim($secretaria->secnome) ?>.">
                             &nbsp;<?= $secretaria->secsite ?>
                        </a>
                        </h4>
                    </li>

                </ol>
            </aside><!-- /widget -->
            <aside class="widget group">
           
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