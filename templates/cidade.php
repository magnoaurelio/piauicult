<?php
$api = new Api();
$precodigo = isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] <= 224 ? $_GET['id'] : die("Não existe esta cidade que você está tentando acessar!");
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
//$prefotop =  Imagem::getPrefeitura($prefeito->prefotop,$prefeitura->codigoUnidGestora);
//$prefotop =  Imagem::getPrefeitura($prefeito->preapep,$prefeitura->codigoUnidGestora);


?>
<div id="section" style="background:url(images/header.jpg) no-repeat top center">
	<div class="row">
		<div class="large-12 columns">
			<h3>Cidades - Artistas - Emissoras</h3>
		</div><!-- /large-12 -->
	</div><!-- /row -->
</div><!-- /section -->
<div id="main-wrap" style="padding-top: 10px">
    <div id="main" class="row">
        <div class="large-9 columns">
            <article class="post group" style="padding: 10px;">
                <div class="artistas-container row">
                    <div class="large-12 columns" >
                        
                        <h1 class="list-title">
                            <a href="?p=emissora&id=<?=$_GET['id']?>&precodigo=<?=$precodigo?>">
                                <span style="color: #000; font-size: 22;">  </span> 
                                <?= $prefeitura->prenome?> &nbsp;<span style="color:#000;font-size: 20px;">(Emissora(s))</span>
                            </a>
                        </h1>
                        <table>
                            <?php

                            $emissoras  = new Emissora(null,"WHERE emicidade = {$precodigo}");

                            if ($emissoras->getResult()):
                                $cont = 0;
                                echo "<tr>";
                                $tm =$emissoras->getRowCount();
                                foreach ($emissoras->getResult() as $emissora):
                                    $emissora = new Emissora($emissora['emicodigo']);
                                    if ($cont == 6):
                                        $cont = 0;
                                        echo "</tr><tr>";
                                    endif;
                                    ?>
                                    <td >
                                        <aside class="widget group" style="width: 125px; height:125px; margin-right: 5px; margin-bottom:20px;">
                                            <figure class="event-thumb" style="margin: 0px;">
                                                <a href="?p=emissora-detalhe&id=<?= $emissora->emicodigo ?>&precodigo=<?= $_GET['id']?>" title="<?= $emissora->eminome ?>">
                                                    <img src="admin/files/emissoras/<?= $emissora->emifoto ?>"  style="width: 120px; height: 120px;"  alt="" />
                                                </a>
                                            </figure>
                                            <a  style="text-align: center;" href="?p=emissora-detalhe&id=<?= $emissora->emicodigo ?>" class="action-btn"><?= $emissora->eminome ?></a>
                                        </aside>
                                    </td>
                                    <?php
                                    $cont ++;
                                endforeach;
                                if ($cont <= 6 || ($tm % 6== 0)):
                                    echo "</tr>";
                                endif;
                            endif;
                            ?>
                        </table>
                    </div>
                </div>
            </article>

            <article class="post group">
                <header class="entry-top special-top">
                    <a href="?p=emissora&id=<?=$_GET['id']?>">
                    <h4 class="entry-title page-title" style="text-align: center">
                     <?= $prefeitura->prenome ?>&nbsp;<span style="color:#000;font-size: 22;"> (Artistas)</span><br>
                    <img style="float: left; margin-top: -28px;" src="<?=$brasao; ?>" width="80" alt="" /> &nbsp; 
                    <img style="float: right; margin-top: -15px;" src="<?=$bandeira ?>" width="80" alt="" />
                    </h4>
                    </a>
                </header>
                <hr>
                <?php
                    $tipo = new Read;
                    $tipo->ExeRead("artista_tipo");

                    $tipos  = $tipo->getResult();
                    foreach ($tipos as $tipo):
                    $artistas = new Read;
                    $artistas->ExeRead("artista", "WHERE artvinculo  = {$precodigo} and arttipocodigo = {$tipo['arttipocodigo']} ORDER BY artnome");
                    $artistasby  = $artistas->getResult();
                    if ($artistasby){
                        ?>
                        <div class="artistas-container row">
                            <div class="large-2 columns">
                                <aside class="widget group" style="width: 80px; height:80px; margin-left:5px;">
                                    <a class="action-btn"><?= $tipo['arttiponome'] ?></a>
                                </aside>
                            </div>
                            <div class="large-10 columns" style="">
                                <table>
                                    <?php
                                    $cont = 0;
                                    echo "<tr>";
                                    $tm = sizeof($artistasby);
                                    foreach ($artistasby as $artista):
                                        if ($cont == 5):
                                            $cont = 0;
                                            echo "</tr><tr>";
                                        endif;

                                        ?>
                                        <td>
                                            <aside class="widget group"
                                                   style="width: 125px; height:125px; margin-right: 5px; margin-bottom:20px;">
                                                <figure class="event-thumb" style="margin: 0px;">
                                                    <a href="?p=artist&id=<?= $artista['artcodigo']; ?>"
                                                       title="<?= $artista['artnome'] ?>">
                                                        <img src="admin/files/artistas/<?= $artista['artfoto'] ?>" alt=""/>
                                                    </a>
                                                </figure>
                                                <a style="text-align: center;"
                                                   href="?p=artist&id=<?= $artista['artcodigo']; ?>"
                                                   class="action-btn"><?= $artista['artusual'] ?></a>
                                            </aside>
                                        </td>
                                        <?php
                                        $cont++;
                                    endforeach;
                                    if ($cont <= 5 || ($tm % 5 == 0)):
                                        echo "</tr>";
                                    endif;
                                    ?>
                                </table>
                            </div>
                        </div>
                    <?php
                    }
                    endforeach;
                ?>

            </article>
        </div>
        <div class="large-3 columns sidebar sidebar-1">
            <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgp ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgp ?>" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                               <ol class="tracklisting tracklisting-top">
                                <li class="group track">
                                    <a class="fa fa-home"></a>
                                    <h5 class="track-meta">Site:</h5>
                                    <h4 class="track-title"><a style="font-size: 12px; font-weight: 0" target="_blank" href="http://<?= $prefeitura->presite ?>">
                                    <?= $prefeitura->presite ?>
                                    </a>
                                    </h4>
                                </li>
                               </ol>
                        </figure>
                    </li>
                    <li>
                         <?php
                      //  $precodigo = $_GET['id'];
                        $filterAmpar = new Filter("precodigo","=", intval($precodigo));
                        $prefeito = new Read();
                        $prefeito->ExeRead("prefeito", "WHERE precodigo = $precodigo  ORDER BY precodigo limit 1 ");
                         foreach($prefeito->getResult() as $prefeitos){
                            $prenomep = $prefeitos['prenomep'];
                            $preapep  = $prefeitos['preapep'];
                            $prefeito =  $api->getPrefeito([$filterAmpar->getValue()], true);
                            $prefotop =  Imagem::getPrefeito($prefeitos['prefotop'],$prefeitura->codigoUnidGestora);

                         }
                        ?>  
                        <figure class="event-thumb">
                            <a href="<?= $prefotop ?>" data-rel="prettyPhoto">
                                <img src="<?= $prefotop ?>" />
                                <div class="overlay icon-zoom-in"></div>
                                 <ol class="tracklisting tracklisting-top">
                                <li class="group track">
                                    <a class="fa fa-home"></a>
                                    <h5 class="track-meta">Prefeito(a)</h5>
                                    <h4 class="track-title">&nbsp;<?= $preapep?></h4>
                                </li>
                                 </ol>
                            </a>
                        </figure>
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
                <h3 class="widget-title">Dados do Município</h3>
                <ol class="tracklisting tracklisting-top">
                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Endereço:</h5>
                        <h4 class="track-title">&nbsp;<?= $prefeitura->preendereco ?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">CNPJ:</h5>
                        <h4 class="track-title">&nbsp;<?= $prefeitura->precnpj?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Fone:</h5>
                        <h4 class="track-title">&nbsp;<?= $prefeitura->prefone ?></h4>
                    </li>



                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Email:</h5>
                        <h4 class="track-meta">&nbsp;<?= $prefeitura->preemail ?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Site:</h5>
                        <h4 class="track-title"><a style="font-size: 12px; font-weight: 0" target="_blank" href="http://<?= $prefeitura->presite ?>"><?= $prefeitura->presite ?></a></h4>
                    </li>

                </ol>
            </aside><!-- /widget -->
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