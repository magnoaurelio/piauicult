<div id="main-wrap" style="margin-top: -120px">
    <div id="main" class="row">
        <div class="large-12 columns">
            <header class="entry-top special-top">
                <h1 class="entry-title page-title">Emissoras.</h1> </header>
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
                <div class="large-3 columns">
                </div>
                <div class="large-9 columns"> &nbsp; </div>
            </div>
            <article class="post group">
                <?php

                ?>
                <div class="artistas-container row">
                    <div class="large-12 columns" style=" padding: 10px;">
                        <table class="table">
                            <?php
                            $cidades =  DadosFixos::getPrefeiturasFull();
                            foreach ($cidades as $cidade) {
                            $emissoras = new Emissora(null, "WHERE emicidade = {$cidade->codigo}");
                            $tm = $emissoras->getRowCount();
                            if ($tm < 1)
                                continue;
                            ?>
                            <tr class="group track">
                                <td style="margin-right: 10px;">
                                    <h5 class="track-title"><a href="?p=cidade&id=<?= $cidade->codigo; ?>"><?= $cidade->nome; ?>: &nbsp;</a></h5>
                                </td>
                                <?php

                                if ($emissoras->getResult()):
                                    $cont = 0;
                                    foreach ($emissoras->getResult() as $emissora):
                                        $emissora = new Emissora($emissora['emicodigo']);
                                        ?>
                                        <td>
                                            <aside class="widget group"
                                                   style="width: 125px; height:125px; margin-right: 5px; margin-bottom:20px;">
                                                <figure class="event-thumb" style="margin: 0px;">
                                                    <a href="?p=emissora-detalhe&id=<?= $emissora->emicodigo ?>"
                                                       title="<?= $emissora->eminome ?>">
                                                        <img src="admin/files/emissoras/<?= $emissora->emifoto ?>"
                                                             style="width: 120px; height: 80px;" alt=""/>
                                                    </a>
                                                </figure>
                                                <a style="text-align: center;"
                                                   href="?p=emissora-detalhe&id=<?= $emissora->emicodigo ?>"
                                                   class="action-btn"><?= $emissora->eminome ?></a>
                                            </aside>
                                        </td>
                                        <?php

                                    endforeach;
                                endif;
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </article>
        </div>
        <!-- /large-12 -->
    </div>
    <!-- /main -->
</div>