<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-12 columns">

            <article class="post group">
                <?php
                $cinema = new Cinema($_GET['id']);
                $imgp = "admin/files/cinema/" . trim($cinema->cinimagem);

                $festival = $cinema->getFestival();
                $imgfestival = "admin/files/festivais/" . trim($festival->fesimagem);

                $premio = new FestivalPremio($cinema->fesprecodigo);
                $fesprenome = $premio->fesprenome;
                $fesprefoto = "admin/files/festivais/".$premio->fesprefoto;

                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>

                <style>
                    .texted span{
                        margin-right: 5px;
                        font-weight: 600;
                        font-family: bold;
                    }
                </style>

                <header class="entry-top special-top">
                       <h1><a href="?p=festivais-cinema"> <img src="<?= $imgfestival ?>" width="80"/> <small>Filme: </small> <?= $cinema->cinnome ?>  </a> <small>Ano:</small> <a href="#"> <?= trim($festival->fesperiodo) ?> </a><small> Evento: </small><a href="#"><?= $festival->fesnome ?>.</a></a></h1>
                </header>
                           <article class="post group">
                <?php
                $elenco = $cinema->getElenco();
                ?>
                <h3 style="margin-left: 25px;">Produção e Elenco</h3>
                <?php
                if ($elenco):
                    foreach ($elenco as $artista):
                        $artista =  new Artista($artista["artcodigo"]);

                        ?>

                        <div class="large-2 columns sidebar sidebar-1">
                            <aside class="widget group" style="padding: 0px;  margin-bottom: 10px;">
                                <ol class="widget-list widget-list-single" > <!--tracklisting tracklisting-top- numeração-->

                                    <li  style="max-height: 140px; min-height: 140px; margin: 0px;">
                                        <table width="100%" border="0" style=" text-align:center; margin-left: 0px;">
                                            <tr>
                                                <td  width="100"  style=" align:center">
                                                    <a href="?p=artista-cinema&id=<?= $artista->artcodigo ?>" class="" title="<?= $artista->artusual ?>">
                                                        <img src="admin/files/artistas/<?= $artista->artfoto ?>" width="800" alt="" />
                                                    </a>
                                                </td>

                                            </tr>
                                        </table>

                                        <a  href="?p=artista-cinema&id=<?= $artista->artcodigo ?>"  title="Ir para o ARTISTA:  <?=  $artista->artusual ?> ">
                                            <strong><?= $artista->artusual?></strong><br>
                                            <?= $artista->artcidade?>-<strong><?=$artista->artuf?></strong>

                                        </a>
                                    </li>
                                </ol>


                            </aside>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </article>
                <div class="entry-content row">
                    <div class="large-9 columns">
                        <ul  style="list-style: none">
                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted"><span>Nome:</span><?= $cinema->cinnome ?></p>
                            </li>

                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted"><span>Festival:</span><?= $festival->fesnome ?></p>
                            </li>
                            <li >
                                <a class="fa fa-home"></a>
                                <p class="texted"><span>Gênero:</span><?= $cinema->getGenero()->descricao ?></p>
                            </li>

                            <li >
                                <a class="fa fa-home"></a>
                                <p class="texted"><span>Premiação:</span> <img src="<?= $fesprefoto ?>" width="30"/> <?= $fesprenome?></p>
                            </li>

                            <li >
                                <a class="fa fa-home"></a>
                                <p class="texted"><span>Duração:</span><?= $cinema->cinduracao ?></p>
                            </li>

                            <li >
                                <a class="fa fa-home"></a>
                                <p class="texted"><span>Sobre:</span><?=$cinema->cinsobre ?></p>
                            </li>

                        </ul>
                    </div>
                    <div class="large-3 columns sidebar sidebar-1">
                        <aside class="widget group">
                            <ol class="widget-list widget-list-single">
                                <li>
                                    <figure class="event-thumb">
                                        <a href="<?= $imgp ?>" data-rel="prettyPhoto">
                                            <img src="<?= $imgp ?>"/>
                                            <div class="overlay icon-zoom-in"></div>
                                        </a>
                                    </figure>
                                </li>
                            </ol>
                        </aside><!-- /widget -->


                    </div>
                </div>
            </article>

      
        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    function BuscaID(str, id) {
        var pos1 = str.search("users/");
        var pos2 = str.search("&amp;");
        var codigo = str.substring(pos1 + 6, pos2)
        $("#" + id).val(codigo)
    }
</script>