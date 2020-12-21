<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-12 columns">

            <article class="post group">
                <?php
                $festival = new Festival($_GET['id']);
                $imgp = "admin/files/festivais/" . trim($festival->fesimagem);
                $festema = $festival->festema;
                $fesmostra = $festival->fesmostra;

                if (!file_exists($imgp) or !is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                $fotos = array();
                $foto1 = "admin/files/festivais/" . trim($festival->fesfoto1);
                $foto2 = "admin/files/festivais/" . trim($festival->fesfoto2);
                $foto3 = "admin/files/festivais/" . trim($festival->fesfoto3);
                if (is_file($foto1)) $fotos[] = $foto1;
                if (is_file($foto2)) $fotos[] = $foto2;
                if (is_file($foto3)) $fotos[] = $foto3;

                //   $data = DataCalendario::date2us($festival->fesdata);
                //  $data = new DataCalendario($data);
                // $data->getDia() . " " . $data->getMes() . " " . $data->getAno() 

                ?>
                <header class="entry-top special-top">
                    <h1 class="entry-title page-title">  <a href="?p=festivais-literatura"><img src="<?= $imgp ?>" width="80"/></a>
                        <small>Festival:</small>
                        <a href="#"> <?= $festival->fesnome ?>.</a>
                        <small>Ano:</small>
                        <a href="#"> <?= trim($festival->fesperiodo) ?> </a>
                        <small> Tema:</small>
                        <a href="#"> <?= $festival->festema ?>.</a></h1>
                </header>
                <div class="entry-content row">
                    <div class="large-9 columns">
                        <ul class="cpt-meta">
                            <li><h3>Sobre:</h3><span style="width: 100%;"><?= $festival->fessobre ?></span></li>
                            <li><h3>Mais:</h3><span style="width: 100%;"><?= $festival->fesoutros ?></span></li>
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
                                <?php
                                if ($fotos) {
                                    foreach ($fotos as $foto) {
                                        ?>
                                        <li>
                                            <figure class="event-thumb">
                                                <a href="<?= $foto ?>" data-rel="prettyPhoto">
                                                    <img src="<?= $foto ?>"/>
                                                    <div class="overlay icon-zoom-in"></div>
                                                </a>
                                            </figure>
                                        </li>
                                    <?php }
                                } ?>
                            </ol>
                        </aside><!-- /widget -->


                    </div>
                </div>
            </article>

         
            <?php
                $festival->isFestivalLiteratura;
                $literaturas = $festival->getLiteratura();
                ?>
                <article class="post group" style="margin-left: 10px; padding-left: 10px;">
                    <h3> <a href="?p=festivais-literatura"><img src="<?= $imgp ?>" width="50"/></a>
                        <small>Catálogo:</small>
                        <a href="#"> <?= $festival->fesnome ?>. </a>
                        <small>Ano:</small>
                        <a href="#"> <?= trim($festival->fesperiodo) ?> </a>
                        <small> Tema:</small>
                        <a href="#"> <?= $festival->festema ?>.</a></a></h3>
                    <?php
                    $litcategorias = (new LiteraturaCategoria())->getResult();
                    if ($litcategorias): //else
                        ?>
                        <table style="width: 100%">
                            <?php foreach ($litcategorias as $key => $cat):
                                $litcategoria = new LiteraturaCategoria($cat["litcatcodigo"]);
                                $litcatfoto =  "admin/files/literatura/" .$litcategoria->litcatfoto;
                                $literaturascat = [];
                                $possui = false;
                                if ($literaturas) {
                                    foreach ($literaturas as $key => $literatura) {
                                        //var_dump($literatura["humcategoria"]." ==". $litcategoria->codigo);
                                        if ($literatura["litcatcodigo"] == $litcategoria->litcatcodigo) {
                                          
                                            $literaturascat[] = $literatura;
                                            unset($literaturas[$key]);
                                            $possui = true;
                                        }
                                    }
                                    array_values($literaturas);
                                }

                                if (!$possui) continue;
                                ?>
                                    <td widt="400" title=" <?= $litcategoria->litcatnome ?>">
                                        <h1>
                                             <a href="?p=festivais-literatura"><img src="<?= $imgp ?>" width="150"/></a>
                                            <!--img src="<?= $litcatfoto ?>" width="150"/-->
                                            <a href="#"><?= $litcategoria->litcatnome ?></a>
                                        </h1>
                                    </td>
                                <tr>
                                    <td>
                                        <div class="entry-content">
                                            <ol class="tracklisting">
                                                <?php
                                                if ($literaturascat):
                                                    foreach ($literaturascat as $literatura):
                                                        $premio = new FestivalPremio($literatura["fesprecodigo"]);
                                                        $fesprenome = $premio->fesprenome;
                                                        $fesprefoto = "admin/files/festivais/" . $premio->fesprefoto;

                                                        $literatura = new Literatura($literatura["litcodigo"]);
                                                        $paginaLivro = $literatura->getPagina();
                                                        $livro = $paginaLivro->getLivro();
                                                        $litfoto = "admin/files/literatura/paginas/" . trim($literatura->litarquivo);
                                                        $artista = $literatura->getArtista();
                                                        ?>
                                                        <li class="large-4 columns"
                                                            style="margin-top:5px; padding-left: 0px; text-align: center; max-height: 550px; min-height: 350px;">

                                                            <a target="_blank"
                                                               href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                                                               title="Ir para o Catalogo:  <?= $literatura->litnome ?> ">
                                                                <img src="<?= $litfoto ?>" width="200"/><br>
                                                                <img src="<?= $fesprefoto ?>" width="30"/> <?= $fesprenome ?>
                                                            </a>

                                                            <h5 class="list-subtitle"
                                                                style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                                                                <a target="_blank"
                                                                   href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                                                                   title="Ir para o Catalogo:  <?= $literatura->litnome ?> ">
                                                                    <?= $literatura->litnome ?><br>
                                                                </a>
                                                                <a target="_blank"
                                                                   href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                                                                   title="Ir para o Catalogo:  <?= $literatura->litnome ?> ">
                                                                    <small style="color: red; font-size: 16px; font-weight: 400"><?= $literatura->getCategoria()->litnome ?></small>
                                                                </a>

                                                            </h5>
                                                            <table width="100%" border="0"
                                                                   style=" text-align:center; margin-left: 0px;">
                                                                <tr>
                                                                    <td width="50" style=" align:center">
                                                                        <a href="?p=artista-categoria&id=<?= $artista->artcodigo ?>"
                                                                           class="" title="<?= $artista->artusual ?>">
                                                                            <img src="admin/files/artistas/<?= $artista->artfoto ?>"
                                                                                 width="60" alt=""/>
                                                                        </a>
                                                                    </td>

                                                                </tr>
                                                            </table>

                                                            <a href="?p=artista-literatura&id=<?= $artista->artcodigo ?>"
                                                               title="Ir para o ARTISTA:  <?= $artista->artusual ?> ">
                                                                <strong><?= $artista->artusual ?></strong><br>
                                                                <?= $artista->artcidade ?>
                                                                -<strong><?= $artista->artuf ?></strong>

                                                            </a>
                                                        </li>

                                                        <?php
                                                    endforeach;
                                                endif;
                                                //       endforeach;
                                                //     endif;
                                                ?>

                                            </ol>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>

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