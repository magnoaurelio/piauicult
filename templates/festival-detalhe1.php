<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-12 columns">

            <article class="post group">
                <?php
                $festival = new Festival($_GET['id']);
                $imgp = "admin/files/festivais/" . trim($festival->fesimagem);

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




                ?>
                <header class="entry-top special-top">
                    <h1 class="entry-title page-title">Festival (<?= $festival->fesnome ?>).</h1>
                </header>
                <div class="entry-content row">
                    <div class="large-9 columns">
                    <ul class="cpt-meta">
                        <li><span>Data: </span><?= $festival->fesdata ?></li>
                        <li><span>Período:</span> <?= $festival->fesperiodo ?></li>
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

            <article class="post group">
                <?php $artistas = $festival->getArtistas(); ?>
                <h3 style="margin-left: 25px;">Artistas Participantes</h3>
                 <?php
                        if ($artistas):
                            foreach ($artistas as $artista):
                                $artistaObject = (object)$artista;
                                ?>
                   
                    <div class="large-2 columns sidebar sidebar-1">
                        <aside class="widget group" style="padding: 0px;  margin-bottom: 10px;">
                        <ol class="widget-list widget-list-single" > <!--tracklisting tracklisting-top- numeração-->
                       
                                <li  style="max-height: 150px; min-height: 150px; margin: 0px;">
                                  
                                    <table width="100%" border="0">
                                        <tr>
                                            <td  width="65">
                                                <a href="?p=artist&id=<?= $artista['artcodigo']; ?>" class="" title="<?= $artista['artusual']; ?>"><img src="admin/files/artistas/<?= $artista['artfoto']; ?>" width="100" alt="" /></a>
                                            </td>

                                        </tr>
                                    </table>
                                  <p style="font-size:14px; margin-top: 0; padding: 0;" class="track-title"><a href="?p=artist&id=<?= $artista['artcodigo']; ?>"><?= $artista['artusual']; ?></a></p>
                                </li>
                              </ol>
                             
                   
                            </aside>
                      </div>
                       <?php
                            endforeach;
                        endif;
                        ?>
            </article>

            <article class="post group">
                <?php
                if ($festival->getFestivaisHumor()){
                    $humors = $festival->getHumor();
                ?>
                    <div class="entry-content">
                        <h3>Catálogo de Humor</h3>
                        <ol class="tracklisting">
                            <?php
                            if ($humors):
                                foreach ($humors as $humor):
                                    $humor = new Humor($humor["humcodigo"]);
                                    $paginaLivro = $humor->getPagina();
                                    $livro = $paginaLivro->getLivro();
                                    $fotohumor = "admin/files/livros/paginas/" . trim($humor->humarquivo);
                                    $artista = $humor->getArtista();
                            ?>
                                    <li class="large-2 columns"style="margin-top:5px; padding-left: 0px; text-align: center; max-height: 350px; min-height: 350px;" >
                                        <img src="<?= $fotohumor ?>" width="200"/>
                                            <h5 class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                                                <a target="_blank" href="livro.php?livcodigo=<?=$livro->livcodigo?>#page/<?=$paginaLivro->numero?>"  title="Ir para o Humor:  <?= $humor->humnome ?> ">
                                                    <?= $humor->humnome?>
                                                </a> <br>
                                                <a target="_blank" href="livro.php?livcodigo=<?=$livro->livcodigo?>#page/<?=$paginaLivro->numero?>"   title="Ir para o Humor:  <?= $humor->humnome ?> ">
                                                    <small style="color: red; font-size: 16px; font-weight: 400"><?= $humor->getCategoria()->descricao?></small>
                                                </a>
                                            </h5>
                                            <a class="action-btn" href="?p=artista-humor&id=<?= $artista->artcodigo ?>"  title="Ir para o ARTISTA:  <?=  $artista->artusual ?> ">
                                                <?= $artista->artusual?>-<?=$artista->artuf?>
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
                <?php } else {?>


                <div class="entry-content">
                    <h3>Músicas Participantes</h3>
                    <ol class="tracklisting">
                        <?php
                        if ($musicas):
                            foreach ($musicas as $musica):
                                $musica = (object)$musica;
                                $partmusica = false;
                                
                                $music =  new Musica($musica->muscodigo);
                                $disco =  $music->getAlbum();
                                
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
                                             <td  width="65"> 
                                                        <a title="<?= $disco->disnome ?>" href="?p=album&id=<?= $disco->discodigo ?>" class=""><img src="admin/files/discos/<?= $disco->disimagem ?>" width="60" alt="" /></a>
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
                                            <a href="<?= $musica->musvideo ?>" data-rel="prettyPhoto" onclick="Topo()"
                                               class="action-btn">Vídeo</a>
                                        <?php else: ?>
                                            <a data-rel="prettyPhoto" onclick="Topo()" class="action-btn"
                                               style="background-color:#CCC;">Vídeo</a>
                                        <?php endif; ?>
                                        <?php if ($musica->letativo == "S"): ?>
                                            <a href="admin/files/musicas/letra/<?= $musica->musletra ?>"
                                               onclick="Topo()" data-rel="prettyPhoto" class="action-btn">Letra</a>
                                        <?php else: ?>
                                            <a data-rel="prettyPhoto" onclick="Topo()" style="background-color:#CCC;">Letra</a>
                                        <?php endif; ?>

                                    </div>
                                    <div id="lyrics-1" class="track-lyrics-hold">
                                        <p><img src="admin/files/musicas/letra/<?= $musica->musletra ?>" width="auto"
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

                <?php } ?>

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