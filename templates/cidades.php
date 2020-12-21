<?php
$api = new Api();
$filterAmpar = new Filter("precodigo","<=", 224);
$prefeituraService = new PrefeituraService($api->getPrefeitura([$filterAmpar->getValue()]));
$prefeitura = $api->getPrefeitura([$filterAmpar->getValue()], true);
$filterPref = new Filter("unidadeGestora","=",  $prefeitura->codigoUnidGestora);
$filters =  array();
$filters[] = $filterPref->getValue();



function FactorySecretaria(){
    $secretaria = new stdClass();
    $secretaria->secfoto = "user.png";
    $secretaria->secfotor = "user.png";
    $secretaria->secnome = "Indefinido";
    $secretaria->secusual = "Indefinido";
    $secretaria->secsecretario = "Indefinido";
    $secretaria->secendereco = "Indefinido";
    $secretaria->secfone = "Indefinido";
    $secretaria->secemail = "Indefinido";
    return $secretaria;
}

//$preimagem = Imagem::getPrefeitura($cidade->prefoto, $cidade->codigoUnidGestora);
//$secfoto =  Imagem::getPrefeitura($secretaria->secfoto,$prefeitura->codigoUnidGestora);
//$secfotor =  Imagem::getPrefeitura($secretaria->secfotor,$prefeitura->codigoUnidGestora);
$imgp =  Imagem::getPrefeitura($prefeitura->prefoto,$prefeitura->codigoUnidGestora);
$brasao =  Imagem::getPrefeitura($prefeitura->prebrasao,$prefeitura->codigoUnidGestora);
$bandeira =  Imagem::getPrefeitura($prefeitura->prebandeira,$prefeitura->codigoUnidGestora);

?>
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns">

            <div class="row">
                <style>
                    td{
                        border-collapse: collapse;
                    }
                    .disco-logo{
                        float: left;
                    }
                    .artistas-container{
                        width: 100%;
                        padding: 10px;
                    }
                </style>

                <div class="large-12 columns">
                    <article class="post group" style="width: 100%; padding: 5px 20px 20px 20px;">
                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <div class="col-lg-12 cabeca">
                                    <header class="entry-top special-top">
                                        <h1 class="entry-title page-title"><a href="#">Cidades de A - Z</a></h1>
                                    </header>
                                </div>

                                <?php
                                $n = 65;
                                for ($n = 65; $n <= 90; $n++) {

                                    $letra = chr($n);
                                    $prefeituras = $prefeituraService->getPrefeiturasLetra($letra);
                                    if (!sizeof($prefeituras)){
                                        continue;
                                    }
                                    $ativa = $letra == 'A' ? 'active' : "";
                                    ?>
                                    <li role="presentation" class="<?= $ativa ?>"><a href="#tab<?= $letra ?>" aria-controls="tab<?= $letra ?>" role="tab" data-toggle="tab"><?= $letra ?></a></li>
                                <?php } ?>
                            </ul>

                            <div class="tab-content" style="float: left; width: 100%;">
                                <?php
                                $d = 0;
                                $p = 0;
                                $n = 65;

                                for ($n = 65; $n <= 90; $n++) {

                                    $letra = chr($n);
                                    $ativa = $letra == 'A' ? 'active' : "";
                                    ?>
                                    <div role="tabpanel" class="tab-pane <?= $ativa ?>" id="tab<?= $letra ?>">
                                        <ol class="tracklisting">
                                            <?php
                                            $prefeituras = $prefeituraService->getPrefeiturasLetra($letra);
                                            if ($prefeituras):
                                                foreach ($prefeituras as $cidade):
                                                    $brasao =  Imagem::getPrefeitura($cidade->prebrasao,$cidade->codigoUnidGestora);
                                                    $bandeira =  Imagem::getPrefeitura($cidade->prebandeira,$cidade->codigoUnidGestora);
                                                    $filterPref = new Filter("unidadeGestora","=",  $cidade->codigoUnidGestora);
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
                                                    $secretaria =  !$secretaria ? FactorySecretaria() : $secretaria;   
                                                    $secfoto =  Imagem::getPrefeitura($secretaria->secfoto,$prefeitura->codigoUnidGestora);
                                                    $secfotor =  Imagem::getPrefeitura($secretaria->secfotor,$prefeitura->codigoUnidGestora);
                                                    ?> 
                                                    <li class="group track">
                                                        <!--a class="my-btn"><!--i class="icon-star"></i--></a-->
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td  width="65"> 
                                                                    <a href="?p=cidade&id=<?= $cidade->precodigo; ?>" class="" title="<?=$cidade->prenome; ?>">
                                                                        <img src="<?=$brasao; ?>" width="100" alt="" />
                                                                    </a>
                                                                </td>
                                                                 <td  width="65">
                                                                    <a href="?p=cidade&id=<?= $cidade->precodigo; ?>" class="" title="<?=$cidade->prenome; ?>">
                                                                        <img src="<?=$bandeira; ?>" width="100" alt="" />
                                                                    </a>
                                                                </td>
                                                                <td  width="65">
                                                                        <figure class="event-thumb">
                                                                            <a href="<?= $secfotor ?>"  data-rel="prettyPhoto">
                                                                                <img src="<?= $secfotor ?>" width="100" alt="imagem sec" />
                                                                             
                                                                            </a>
                                                                        </figure>
                                                                </td>
                                                                <td width="450" style="padding-left: 20px;">
                                                                    <p class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.1px;">
                                                                        <a href="?p=cidade&id=<?= $cidade->precodigo; ?>" class="" title="<?=$cidade->prenome; ?>">
                                                                            <strong> <?=$cidade->prenome?></strong>
                                                                        </a>
                                                                    </p>
                                                                   <a href="#"><strong><?= $secretaria->secnome?></strong></a><br>
                                                                   <strong><?=$secretaria->secsecretario?></strong>-<?= $secretaria->secusual ?><br>
                                                                   CNPJ: <?= $cidade->precnpj; ?> - Contato: <?= @$cidade->prefone; ?><br>
                                                                   Site:<a target="_blank"href="http://<?=$cidade->presite ?>" class="" title="Site oficla de: <?=$cidade->prenome; ?>">
                                                                               <?= $cidade->presite ?>
                                                                        </a>
                                                                    
                                                                </td>
                                                                
                                                                <td  width="150">
                                                                    <a title="Veja os Locais de Eventos de: <?=$cidade->prenome; ?>"style="text-align: center; padding-left: 20px;" href="?p=local-cidade&precodigo=<?=$cidade->precodigo?>">
                                                                        <img src="images/eventos.jpg" width="80" alt="" /><br>Locais de Eventos
                                                                    </a>
                                                                </td>
                                                                <td  width="150">
                                                                    <a title="Veja Emissoras cadastradas de: <?=$cidade->prenome; ?>" style="text-align: center; padding-left: 0px;" href="?p=emissora&precodigo=<?=$cidade->precodigo?>">
                                                                        <img src="images/emissoras.jpg" width="80" alt="" /><br> &nbsp; Emissoras
                                                                    </a>
                                                                </td>
                                                                 <td  width="120">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </li>

                                                    <?php
                                                endforeach;

                                            endif;
                                            ?>
                                        </ol>
                                    </div>
                                    <?php
                                    $d = 0;
                                } // fim do for das letras  
                                ?>
                            </div>

                        </div>
                </div>
                </article>

            </div>
        </div>

    </div>
    <!-- /large-12 -->
</div>
<!-- /main -->
</div>
<!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=artistas";
        } else {
            top.location.href = "?p=artista&id=" + this.value;
        }
    });
</script>