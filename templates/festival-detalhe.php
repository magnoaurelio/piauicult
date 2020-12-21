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
                    <h1 class="entry-title page-title">  <a href="?p=festivais-humor"><img src="<?= $imgp ?>" width="80"/></a>
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

            <!--article class="post group">
                <?php $artistas = $festival->getArtistas(); ?>
                <h3 style="margin-left: 25px;">Artistas Participantes</h3>
                 <?php
            //  if ($artistas):
            //    foreach ($artistas as $artista):
            //      $artistaObject = (object)$artista;
            ?>
                   
                    <div class="large-2 columns sidebar sidebar-1">
                        <aside class="widget group" style="padding: 0px;  margin-bottom: 10px;">
                        <ol class="widget-list widget-list-single" > <!--tracklisting tracklisting-top- numeração-->

            <!--li  style="max-height: 150px; min-height: 150px; margin: 0px;">
                                  
                                    <table width="100%" border="0">
                                        <tr>
                                            <td  width="65">
                                                <a href="?p=artista-humor&id=<?= $artista['artcodigo'] ?>" class="" title="<?= $artista['artusual']; ?>">
                                                    <img src="admin/files/artistas/<?= $artista['artfoto']; ?>" width="100" alt="" />
                                                </a>
                                            </td>

                                        </tr>
                                    </table>
                                  <p style="font-size:14px; margin-top: 0; padding: 0;" class="track-title">
                                      <a href="?p=artista-humor&id=<?= $artista['artcodigo'] ?>">
                                          <?= $artista['artusual'] . " - " . $artista['artuf'] ?>
                                      </a>
                                  </p>
                                </li>
                              </ol>
                             
                   
                            </aside>
                      </div>
                       <?php
            //  endforeach;
            //   endif;
            ?>
            </article-->


            <?php
            if ($festival->isFestivalHumor()) {
                $humors = $festival->getHumor();
                ?>
                <article class="post group" style="margin-left: 10px; padding-left: 10px;">
                    <h3><img src="<?= $imgp ?>" width="50"/>
                        <small>Catálogo:</small>
                        <a href="#"> <?= $festival->fesnome ?>. </a>
                        <small>Ano:</small>
                        <a href="#"> <?= trim($festival->fesperiodo) ?> </a>
                        <small> Tema:</small>
                        <a href="#"> <?= $festival->festema ?>.</a></a></h3>
                    <?php
                    $categorias = (new HumorCategoria())->getResult();
                    if ($categorias):
                        ?>
                        <table style="width: 100%">
                            <?php foreach ($categorias as $key => $cat):
                                $categoria = new HumorCategoria($cat["codigo"]);
                                $humcatfoto =  "admin/files/humor/" .$categoria->humcatfoto;
                                $humorscat = [];
                                $possui = false;
                                if ($humors) {
                                    foreach ($humors as $key => $humor) {
                                        //var_dump($humor["humcategoria"]." ==". $categoria->codigo);
                                        if ($humor["humcategoria"] == $categoria->codigo) {
                                          
                                            $humorscat[] = $humor;
                                            unset($humors[$key]);
                                            $possui = true;
                                        }
                                    }
                                    array_values($humors);
                                }

                                if (!$possui) continue;
                                ?>
                                    <td widt="400" title=" <?= $categoria->descricao ?>">
                                        <h1>
                                            <img src="<?= $humcatfoto ?>" width="150"/>
                                            <a href="#"><?= $categoria->descricao ?></a>
                                        </h1>
                                    </td>
                                <tr>
                                    <td>
                                        <div class="entry-content">
                                            <ol class="tracklisting">
                                                <?php
                                                if ($humorscat):
                                                    foreach ($humorscat as $humor):
                                                        $premio = new FestivalPremio($humor["fesprecodigo"]);
                                                        $fesprenome = $premio->fesprenome;
                                                        $fesprefoto = "admin/files/festivais/" . $premio->fesprefoto;

                                                        $humor = new Humor($humor["humcodigo"]);
                                                        $paginaLivro = $humor->getPagina();
                                                        $livro = $paginaLivro->getLivro();
                                                        $fotohumor = "admin/files/livros/paginas/" . trim($humor->humarquivo);
                                                        $artista = $humor->getArtista();
                                                        ?>
                                                        <li class="large-4 columns"
                                                            style="margin-top:5px; padding-left: 0px; text-align: center; max-height: 550px; min-height: 350px;">

                                                            <a target="_blank"
                                                               href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                                                               title="Ir para o Catalogo:  <?= $humor->humnome ?> ">
                                                                <img src="<?= $fotohumor ?>" width="200"/><br>
                                                                <img src="<?= $fesprefoto ?>"
                                                                     width="30"/> <?= $fesprenome ?>
                                                            </a>

                                                            <h5 class="list-subtitle"
                                                                style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                                                                <a target="_blank"
                                                                   href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                                                                   title="Ir para o Catalogo:  <?= $humor->humnome ?> ">
                                                                    <?= $humor->humnome ?><br>
                                                                </a>
                                                                <a target="_blank"
                                                                   href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                                                                   title="Ir para o Catalogo:  <?= $humor->humnome ?> ">
                                                                    <small style="color: red; font-size: 16px; font-weight: 400"><?= $humor->getCategoria()->descricao ?></small>
                                                                </a>

                                                            </h5>
                                                            <table width="100%" border="0"
                                                                   style=" text-align:center; margin-left: 0px;">
                                                                <tr>
                                                                    <td width="50" style=" align:center">
                                                                        <a href="?p=artista-humor&id=<?= $artista->artcodigo ?>"
                                                                           class="" title="<?= $artista->artusual ?>">
                                                                            <img src="admin/files/artistas/<?= $artista->artfoto ?>"
                                                                                 width="60" alt=""/>
                                                                        </a>
                                                                    </td>

                                                                </tr>
                                                            </table>

                                                            <a href="?p=artista-humor&id=<?= $artista->artcodigo ?>"
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
            <?php } else if ($festival->isFestivalLiteratura()) {
                $literaturas = $festival->getLiteratura();
                ?>
                 <article class="post group" style="margin-left: 10px; padding-left: 10px;">
                    <h3><img src="<?= $imgp ?>" width="50"/>
                        <small>Catálogo:</small>
                        <a href="#"> <?= $festival->fesnome ?>. </a>
                        <small>Ano:</small>
                        <a href="#"> <?= trim($festival->fesperiodo) ?> </a>
                        <small> Tema:</small>
                        <a href="#"> <?= $festival->festema ?>.</a></a></h3>
                    <?php
                    $categorias = (new LiteraturaCategoria())->getResult();
                    if ($categorias):
                        ?>
                        <table style="width: 100%">
                            <?php foreach ($categorias as $key => $cat):
                                $litcategoria = new LiteraturaCategoria($cat["litcatcodigo"]);
                                $litcatfoto =  "admin/files/literatura/" .$litcategoria->litcatfoto;
                                $literaturascat = [];
                                $possui = false;
                                if ($literaturas) {
                                    foreach ($literaturas as $key => $literatura) {
                                        //var_dump($humor["humcategoria"]." ==". $categoria->codigo);
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
                                    <td widt="400" title=" <?= $litcategoria->litdescricao ?>">
                                        <h1>
                                          <a href="#">  <img src="<?= $imgp ?>" width="150"/> <?= $litcategoria->litcatnome ?></a>
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
                                                        $fotoliteratura = "admin/files/literatura/paginas/" . trim($literatura->litarquivo);
                                                        $artista = $literatura->getArtista();
                                                        ?>
                                                        <li class="large-4 columns"
                                                            style="margin-top:5px; padding-left: 0px; text-align: center; max-height: 550px; min-height: 350px;">

                                                            <a target="_blank"
                                                               href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                                                               title="Ir para o Catalogo:  <?= $literatura->litnome ?> ">
                                                                <img src="<?= $fotoliteratura ?>" width="200"/><br>
                                                                <img src="<?= $fesprefoto ?>"
                                                                     width="30"/> <?= $fesprenome ?>
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
                                                                    <small style="color: red; font-size: 16px; font-weight: 400"><?= $literatura->getCategoria()->litdescricao ?></small>
                                                                </a>

                                                            </h5>
                                                            <table width="100%" border="0"
                                                                   style=" text-align:center; margin-left: 0px;">
                                                                <tr>
                                                                    <td width="50" style=" align:center">
                                                                        <a href="?p=artista-literatura&id=<?= $artista->artcodigo ?>"
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
              <?php } else if ($festival->isFestivalCinema()) {
                $cinemas = $festival->getCinema();
                ?>
                <article class="post group" style="margin-left: 10px; padding-left: 10px;">
                    <div class="entry-content">
                        <h3><img src="<?= $imgp ?>" width="50"/>
                            <small>Catálogo Cinema:</small>
                            <a href="#"> <?= $festival->fesnome ?>. </a>
                            <small>Ano:</small>
                            <a href="#"> <?= trim($festival->fesperiodo) ?> </a>
                            <small> Tema:</small>
                            <a href="#"> <?= $festival->festema ?>.</a></h3>
                        <ol class="tracklisting">
                            <?php
                            if ($cinemas):
                                foreach ($cinemas as $cinema):
                                    $cinema = new Cinema($cinema["cincodigo"]);
                                    $cinimagem = "./admin/files/cinema/" . trim($cinema->cinimagem);

                                    $premio = new FestivalPremio($cinema->fesprecodigo);
                                    $fesprenome = $premio->fesprenome;
                                    $fesprefoto = "admin/files/festivais/" . $premio->fesprefoto;
                                    ?>
                                    <li class="large-2 columns"
                                        style="margin-top:5px; padding-left: 0px; text-align: center; max-height: 550px; min-height: 350px;">
                                        <a href="?p=cinema-detalhe&id=<?= $cinema->cincodigo ?>"
                                           title="Ir para o Cinema:  <?= $cinema->cinnome ?> ">
                                            <img src="<?= $cinimagem ?>" width="200"/><br>
                                            <img src="<?= $fesprefoto ?>" width="30"/> <?= $fesprenome ?>
                                        </a>
                                        <h5 class="list-subtitle"
                                            style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                                            <a href="?p=cinema-detalhe&id=<?= $cinema->cincodigo ?>"
                                               title="Ir para o Cinema:  <?= $cinema->cinnome ?> ">
                                                <?= $cinema->cinnome ?><br>
                                            </a>
                                            <a href="?p=cinema-detalhe&id=<?= $cinema->cincodigo ?>"
                                               title="Ir para o Cinema:  <?= $cinema->cinnome ?> ">
                                                <small style="color: red; font-size: 16px; font-weight: 400"><?= $cinema->getGenero()->descricao ?></small>
                                            </a>
                                             <br/>
                                              <?php
                                                  $elenco = $cinema->getElenco();
                                                   if ($elenco):
                                                      foreach ($elenco as $artista):
                                                          $artista =  new Artista($artista["artcodigo"]);
                                                  ?>
                                              <a href="?p=artista-cinema&id=<?= $artista->artcodigo ?>" class="" title="Veja detalhe do autor: <?= $artista->artusual ?>">
                                                  <img src="admin/files/artistas/<?= $artista->artfoto ?>" width="50" alt=""/>  <br/> <?= $artista->artusual ?>-<?= $artista->artuf?>
                                              </a>
                                              <?php
                                                 endforeach;
                                             endif;
                                              ?>


                                        </h5>


                                    </li>

                                    <?php
                                endforeach;
                            endif;
                            //       endforeach;
                            //     endif;
                            ?>

                        </ol>
                    </div>
                </article>
            <?php } else { ?>
                <article class="post group">
                    <div class="entry-content">
                        <h3>Músicas Participantes</h3>
                        <ol class="tracklisting">
                            <?php
                            $musicas = $festival->getMusicas();
                            if ($musicas):
                                foreach ($musicas as $musica):
                                    $musica = (object)$musica;
                                    $partmusica = false;

                                    $music = new Musica($musica->muscodigo);
                                    $disco = $music->getAlbum();

                                    // interprestes
                                    $interpretes = Musica::getInterpretes($musica->muscodigo);
                                    $interpretes_format = [];
                                    foreach ($interpretes as $interprete):
                                        $interpretes_format[] = "<a href='?p=artist&id={$interprete->artcodigo}'>" . $interprete->artusual . "</a>";
                                    endforeach;
                                    $interpretes_format = implode(" , ", $interpretes_format);

                                    // autores
                                    $autores = Musica::getAutores($musica->muscodigo);
                                    $autores_format = [];
                                    foreach ($autores as $autor):
                                        $autores_format[] = "<a href='?p=artist&id={$autor->artcodigo}'>" . $autor->artusual . "</a>";
                                    endforeach;
                                    $autores_format = implode(" , ", $autores_format);

                                    // aranjos
                                    $arranjos = Musica::getArranjos($musica->muscodigo);
                                    $arranjos_format = [];
                                    foreach ($arranjos as $arranjo):
                                        $arranjos_format[] = "<a href='?p=artist&id={$arranjo->artcodigo}'>" . $arranjo->artusual . "</a>";
                                    endforeach;
                                    $arranjos_format = implode(" , ", $arranjos_format);

                                    // aranjos
                                    $musicos = Musica::getMusicos($musica->muscodigo);
                                    $musicos_format = [];
                                    foreach ($musicos as $musico):
                                        $musicos_format[] = "<a href='?p=artist&id={$musico->artcodigo}'>" . $musico->artusual . "</a>";
                                    endforeach;
                                    $musicos_format = implode(" , ", $musicos_format);

                                    $audio = "admin/files/musicas/audio/{$musica->musaudio}";


                                    if (!file_exists($audio) or !is_file($audio)):
                                        $audio = "#";
                                    endif;
                                    $gen = new Read;
                                    $genero = [];
                                    $genero['gencodigo'] = NULL;
                                    $genero['gennome'] = "Indefinido";

                                    @$gen->ExeRead('genero', "WHERE gencodigo = :c", "c=$musica->gencodigo");
                                    if ($gen->getRowCount() > 0)
                                        $genero = $gen->getResult()[0];
                                    ?>

                                    <li class="group track">
                                        <?php if ($musica->musativo == "S"): ?>
                                            <a href="<?= $audio ?>" id="<?= $musica->muscodigo ?>"
                                               class="media-btn">Play</a>
                                        <?php else: ?>
                                            <a class="media-btn" style="background-color:#CCC;">Play</a>
                                        <?php endif; ?>
                                        <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> &nbsp; <a
                                                    href="?p=estilos&genero=<?= $genero['gencodigo'] ?>"><?= $genero['gennome'] ?></a>
                                            &nbsp; <?= substr($musica->mussobre, 0, 120) ?></h5>
                                        <h4 class="track-title"><?= $musica->musnome ?></h4><br/>
                                        <table width="100%" border="0">
                                            <tr>
                                                <td width="65">
                                                    <a title="<?= $disco->disnome ?>"
                                                       href="?p=album&id=<?= $disco->discodigo ?>" class=""><img
                                                                src="admin/files/discos/<?= $disco->disimagem ?>"
                                                                width="60" alt=""/></a>
                                                </td>
                                                <td width="70" align="right">
                                                    <small>Autor</small>
                                                    <br/>
                                                    <small>Interpretes</small>
                                                    <br/>
                                                    <small>Arranjos</small>
                                                    <br/>
                                                    <small>Músicos</small>
                                                    <br/>
                                                </td>
                                                <td style=" text-wrap:suppress;">
                                                    <small><?= $autores_format ?> &nbsp;&nbsp;</small>
                                                    <br/>
                                                    <small><?= $interpretes_format ?></small>
                                                    <br/>
                                                    <small><?= $arranjos_format ?></small>
                                                    <br/>
                                                    <small><?= $musicos_format ?></small>
                                                    <br/>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="action-btns">
                                            <?php if ($musica->vidativo == "S"): ?>
                                                <a href="<?= $musica->musvideo ?>" data-rel="prettyPhoto"
                                                   onclick="Topo()"
                                                   class="action-btn">Vídeo</a>
                                            <?php else: ?>
                                                <a data-rel="prettyPhoto" onclick="Topo()" class="action-btn"
                                                   style="background-color:#CCC;">Vídeo</a>
                                            <?php endif; ?>
                                            <?php if ($musica->letativo == "S"): ?>
                                                <a href="admin/files/musicas/letra/<?= $musica->musletra ?>"
                                                   onclick="Topo()" data-rel="prettyPhoto" class="action-btn">Letra</a>
                                            <?php else: ?>
                                                <a data-rel="prettyPhoto" onclick="Topo()"
                                                   style="background-color:#CCC;">Letra</a>
                                            <?php endif; ?>

                                        </div>
                                        <div id="lyrics-1" class="track-lyrics-hold">
                                            <p><img src="admin/files/musicas/letra/<?= $musica->musletra ?>"
                                                    width="auto"
                                                    alt=""/></p>
                                        </div>

                                    </li>

                                    <?php
                                endforeach;
                            endif;
                            //       endforeach;
                            //     endif;
                            ?>

                        </ol>
                    </div>
                </article>
            <?php } ?>
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
     <!--li>
<span>Data: </span><?= substr($festival->fesdata, 8, 2) . "-" . substr($festival->fesdata, 5, 2) . "-" . substr($festival->fesdata, 0, 4) ?>
</li>
<!--li><span>Período:</span> <?= $festival->fesperiodo ?></li>
<li><span>Temática:</span> <?= $festival->festema ?></li-->