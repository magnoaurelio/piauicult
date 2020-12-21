<?php
$api = new Api();
if (isset($_GET['precodigo'])) {
    $filterAmpar = new Filter("precodigo", "=", $_GET['precodigo']);
} else {
    echo "Selecione uma cidade para filtrar os locais de eventos";
    die();
}
$prefeituraService = new PrefeituraService($api->getPrefeitura([$filterAmpar->getValue()]));
?>
<div id="main-wrap" style="margin-top: -120px">
    <div id="main" class="row">
        <div class="large-12 columns">
            <header class="entry-top special-top">
                <h5 class="entry-title page-title">Locais de Eventos.</h5></header>
            <div class="row">
                <style>
                    td {
                        border-collapse: collapse;
                    }

                    .disco-logo {
                        float: left;
                    }

                    .artistas-container {
                        width: 100%;
                        padding: 10px;
                    }
                </style>
                <!--div class="large-3 columns">
                </div>
                <div class="large-9 columns"> &nbsp;</div-->
            </div>
            <article class="post group">
                <?php

                ?>
                <div class="artistas-container row">
                    <div class="large-12 columns" style=" padding: 10px;">

                            <?php
                            $cidades = $prefeituraService->getPrefeituras();
                            foreach ($cidades as $cidade) {
                            $codigo = str_pad($cidade->precodigo, 0, 3, 0);
                            $brasao = Imagem::getPrefeitura($cidade->prebrasao, $cidade->codigoUnidGestora);
                            $bandeira = Imagem::getPrefeitura($cidade->prebandeira, $cidade->codigoUnidGestora);
                            $locais = new EventoLocal(null, "WHERE loccidade = {$codigo}");
                            $tm = $locais->getRowCount();
                            ?>
                             <table class="table" width="100%">
                                <tr class="group track">
                                    <td style="margin-right: 10px; text-align: center">
                                       <h1 class="entry-title page-title" style="text-align: center">
                                          <img style="float: left; margin-top: -28px;" src="<?=$brasao; ?>" width="80" alt="" />
                                          &nbsp;<a href="?p=cidade&id=<?= $codigo; ?>"><?= $cidade->prenome; ?>  <small>(Locais de Eventos)</small> &nbsp;&nbsp;</a>
                                          &nbsp; <img style="float: right; margin-top: -15px;" src="<?=$bandeira ?>" width="80" alt="" />
                                      </h1>
                                        <!--h5 class="track-title"><a href="?p=cidade&id=<?= $codigo; ?>"><?= $cidade->prenome; ?> &nbsp;</a></h5-->
                                    </td>
                                </tr>
                            </table>
                        <hr>
                        <div class="large-12 columns">
                                <section class="events-section events-upcoming">
                                    <ol class="tracklisting">
                                   
                                  
                                    <!--h3>Locais de Eventos</h3-->
                                    <ol class="widget-list">
                                        <?php
                                            if ($tm < 1) {
                                                echo "<p><i>Esta cidade não possui locais cadastrados na plataforma</i></p>";
                                                continue;
                                            }
                                            foreach ($locais->getResult() as $local):
                                                $local = new EventoLocal($local['loccodigo']);

                                                $imgp = "admin/files/local/" . trim($local->locimagem1);
                                                if (!file_exists($imgp) or ! is_file($imgp)):
                                                    $imgp = 'admin/files/imagem/user.png';
                                                endif;
                                                ?>
                                                <li>
                                                    <table>
                                                        <tr>
                                                            <td style="width: 20%; margin-right: 5px;">
                                                                <a href="?p=local&id=<?= $local->loccodigo ?>">
                                                                    <figure class="entry-thumb" style="text-align:center;">
                                                                        <img src="<?= $imgp ?>" alt="" />
                                                                    </figure>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <h4 class="list-title"><a href="?p=local&id=<?= $local->loccodigo ?>"><?= $local->locnome ?></a></h4>
                                                                <a href="?p=local&id=<?= $local->loccodigo ?>" class="action-btn">Mais detalhes ...</a>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </li>
                                                <?php
                                            endforeach;
                                        ?>
                                    </ol>
                                    </ol>
                                </section>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </article>
        </div>
        <!-- /large-12 -->
    </div>
    <!-- /main -->
</div>