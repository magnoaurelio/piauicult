<?php
$api = new Api();
$precodigo = isset($_GET['precodigo']) && !empty($_GET['precodigo']) && $_GET['precodigo'] <= 224 ? $_GET['precodigo'] : die("Não existe esta cidade que você está tentando acessar!");
//$precodigo =  $_GET['precodigo'];
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
                    <h4 class="list-title">
                        <a href="?p=emissora&id=<?=$_GET['id']?>"> 
                            <img style="float: left;" src="<?=$brasao ?>" width="60" height="60" alt="" /> &nbsp; 
                        <img style="float: left;" src="<?=$bandeira ?>" width="80" height="60" alt="" />
                       <?= $prenome?>
                        </a>
                    </h4>
                    <h1 class="entry-title page-title"> 
                        <img src="<?= $imgfoto ?>" width="80" height="80"  /> 
                        
                        Emissora <a href="#"><?= $emissora->eminome ?></a>
                    </h1>
                </header>
                <?php
                $apremissora = $_GET['id'];
                $apresentador = new Read();
                $apresentador->ExeRead("apresentador", "WHERE apremissora = $apremissora ORDER BY rand() limit 10");
                ?>
                <header class="entry-top special-top">
                 
                <h4 class="widget-title">
                    <a href="?p=emissora">Profissionais do Rádio</a>
                </h4>
                </header>
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
                                    <img src="<?=$aprfoto?>" width="250" height="250" alt="" />
                                    <div class="overlay icon-info-sign"></div>
                                </figure>
                                <h4 class="list-title"><a href="?p=emissora&id=<?=$apresentador['aprcodigo']?>"><?= $apresentador['aprnome']?></a></h4>
                                <h5 class="list-title"><a  href="?p=emissora&id=<?=$apresentador['aprcodigo']?>" title="Mais sobre... <?=$apresentador['aprfuncao']?>" class="action-btn"><?=$apresentador['aprfuncao']?></a></h5>
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
                    <li><span>Site: </span><a  href="<?=$emissora->emisite?>" target="_blanck" ><?=$emissora->emisite?></a></li>
                    <li><h3>Sobre:</h3><span style="width: 100%;"><?=$emissora->emisobre?></span></li>
                </ul>
                    <h3>Programações</h3>
                    <ol class="tracklisting">
                        <?php
                         $programacoes =  new Read();
                         $programacoes->ExeRead("programacao","WHERE emicodigo = :cod", "cod={$emissora->emicodigo}");
                         if($programacoes->getResult()) {
                             foreach ($programacoes->getResult() as $programacao){
                             ?>
                             <li class="group track">
                               <a href="?p=emissora" id="" class="media-btn">Play programação</a>
                                <h4 class="track-title"><?= DataCalendario::date2br($programacao['dataplay']) ?></h4><br/>
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
                        <h5 class="list-subtitle"><?= $emissora->eminome ?></h5>
                    </li>
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgimagem ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgimagem ?>" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                        </figure>
                        <h5 class="list-subtitle"><?= $emissora->eminome ?></h5>
                    </li>
                </ol>
            </aside><!-- /widget -->
               <aside class="widget group">
                <h3 class="widget-title"><?= $secretaria->secnome?></h3>
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
                        <h5 class="track-meta">Secretário:</h5>
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