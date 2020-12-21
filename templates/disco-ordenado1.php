<div id="main-wrap" style="margin-top: -80px">
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
                                        <h1 class="entry-title page-title">Discos em ordem alfabética.</h1>
                                    </header>
                                </div>
                                <?php
                                $n = 65;

                                for ($n = 65; $n <= 90; $n++) {

                                    $letra = chr($n);
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
                                            $discos = new Read;
                                            $discos->ExeRead("disco", "WHERE  SUBSTRING(disnome,1,1) = :letra  ORDER BY disnome", "letra={$letra}");
                                            if ($discos->getResult()):
                                                foreach ($discos->getResult() as $disco):
                                                $autor = Disco::getAutorDisco($disco['discodigo']);
                                                    ?>

                                                    <li class="group track">
                                                        <a class="my-btn"><i class="icon-star"></i></a>
                                                        <h5 class="track-title"><a href="?p=album&id=<?= $disco['discodigo']; ?>"><?= $disco['disnome']; ?></a></h5><br/>
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td  width="65">
                                                                    <a href="?p=album&id=<?= $disco['discodigo']; ?>" class="" title="<?= $disco['disnome']; ?>"><img src="admin/files/discos/<?= $disco['disimagem']; ?>" width="80" alt="" /></a>
                                                                    <a href="?p=artist&id=<?= $autor->artcodigo; ?>" class="" title="<?= $autor->artnome; ?>"><?= $autor->artusual; ?></a>
                                                                </td>
                                                                <td  width="65">
<!--                                                                    <a href="?p=artist&id=--><?//= $autor->artcodigo; ?><!--" class="" title="--><?//= $autor->artusual; ?><!--"><img src="admin/files/artistas/--><?//= $autor->artfoto; ?><!--" width="80" alt="" /></a>-->
                                                                </td>

                                                            </tr>

                                                        </table>
                                                        <!-- Modal -->
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