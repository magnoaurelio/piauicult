<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-9 columns">

            <article class="post group">
                <?php
                $banda = new Banda($_GET['id']);
                $imgp = "admin/files/bandas/" . trim($banda->banfoto1);

                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>

                <header class="entry-top special-top">
                    <h1 class="entry-title page-title"><a href='#'><?= $banda->bannome ?></a> - Participantes.</h1>
                </header>
                <?php
                $participantes = $banda->getParticipantes();
                ?>
                <?php
                if (!empty($participantes)):
                    foreach ($participantes as $participante):
                        $imgp = "admin/files/artistas/" . trim($participante->artfoto);
                        if (!file_exists($imgp) or ! is_file($imgp)):
                            $imgp = 'admin/app/images/user.png';
                        endif;
                        ?>
                        <div class="large-3 columns sidebar sidebar-1">
                            <aside class="widget group" style="padding: 0px;  margin-bottom: 20px;">
                                <ol class="widget-list widget-list-single" >
                                    <li style="max-height: 250px; min-height: 250px; margin: 0px;">
                                        <figure class="event-thumb">
                                            <a   title="Mais sobre... <?= $participante->artusual ?>" href="?p=artist&id=<?= $participante->artcodigo ?>">
                                                <img src="<?= $imgp ?>" alt="" />
                                                <div class="overlay icon-info-sign"></div>
                                            </a>
                                        </figure>
                                        <h4 class="list-subtitle" style="margin-bottom: 5px; letter-spacing: 0.2px; text-align: center;"><a><?= $participante->artusual ?></a></h4>
                                        <hr style="border: 1px dotted #ddd">
                                         <?php
                                        $instrumentos = $participante->getInstrumentos();
                                        if ($instrumentos):
                                            $instrumento = $instrumentos[0];
                                            $imgp = "admin/files/instrumento/" . trim($instrumento->insfoto);
                                            if (!file_exists($imgp) or ! is_file($imgp)):
                                                $imgp = 'admin/app/images/instrumento.png';
                                            endif;
                                            ?>
                                            <a href="?p=instrumentistas&id=<?= $instrumento->inscodigo ?>" class="">
                                                <table width="100%" border="0">
                                                    <tr>
                                                        <td  width="35" align="left"> 
                                                            <img src="<?= $imgp ?>" width="30" style="max-height: 30px;" alt="" />
                                                        </td>
                                                        <td align="left">
                                                            <p><i><?= $instrumento->insnome ?></i></p>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </a>
                                            <?php
                                        endif;
                                        ?>
                                    </li>

                                </ol>
                            </aside><!-- /widget -->
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </article> 

            <article class="post group">
                <?php
                $banda = new Banda($_GET['id']);
                $imgp = "admin/files/bandas/" . trim($banda->banfoto1);

                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>
                <header class="entry-top special-top">
                    <h1 class="entry-title page-title"><a href='#'><?= $banda->bannome ?></a> - Discografia.</h1>
                </header>
                <?php
                $discos = $banda->getDiscos();
                ?>
                <?php
                if (!empty($discos)):
                    foreach ($discos as $disco):
                        ?>
                        <div class="large-3 columns sidebar sidebar-1">
                            <aside class="widget group" style="padding: 0px;">
                                <ol class="widget-list widget-list-single" >
                                    <li style="max-height: 250px; min-height: 250px; margin: 0px;">
                                        <figure class="event-thumb">
                                            <a href="?p=album&id=<?= $disco->discodigo ?>">
                                                <img src="admin/files/discos/<?= $disco->disimagem ?>" alt="" />
                                                <div class="overlay icon-info-sign"></div>
                                            </a>
                                        </figure>
                                        <span class="track-meta" datetime="2016-05-20 22:00"><?= $disco->disdata ?></span>
                                        <h4 class="list-subtitle" style="margin-bottom: 5px; letter-spacing: 0.2px;"><a href="album.html"><?= $disco->disnome ?></a></h4>
                                        <a href="?p=album&id=<?= $disco->discodigo ?>" class="action-btn">Veja o CD</a>
                                    </li>

                                </ol>
                            </aside><!-- /widget -->
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </article> 
            <article class="post group">
                <?php
                $banda = new Banda($_GET['id']);
                $imgp = "admin/files/bandas/" . trim($banda->banfoto1);

                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>
                <header class="entry-top special-top">
                    <h1 class="entry-title page-title"><a href='#'><?= $banda->bannome ?></a> - Show / Espetáculos.</h1>
                </header>
                <?php
                $discos = $banda->getDiscos();
                ?>
                <?php
                if (!empty($discos)):
                    foreach ($discos as $disco):
                        ?>
                        <div class="large-3 columns sidebar sidebar-1">
                            <aside class="widget group" style="padding: 0px;">
                                <ol class="widget-list widget-list-single" >
                                    <li style="max-height: 250px; min-height: 250px; margin: 0px;">
                                        <figure class="event-thumb">
                                            <a href="?p=album&id=<?= $disco->discodigo ?>">
                                                <img src="admin/files/discos/<?= $disco->disimagem ?>" alt="" />
                                                <div class="overlay icon-info-sign"></div>
                                            </a>
                                        </figure>
                                        <span class="track-meta" datetime="2016-05-20 22:00"><?= $disco->disdata ?></span>
                                        <h4 class="list-subtitle" style="margin-bottom: 5px; letter-spacing: 0.2px;"><a href="album.html"><?= $disco->disnome ?></a></h4>
                                        <a href="?p=album&id=<?= $disco->discodigo ?>" class="action-btn">Veja o CD</a>
                                    </li>

                                </ol>
                            </aside><!-- /widget -->
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </article>

            <aside class="widget group" style="margin-top: -30px">
                <ol class="tracklisting tracklisting-top">
                    <article class="post group">
                        <div class="entry-content">
                            <h3><img src="<?= $imgp ?>" width="100" />&nbsp;Vídeos de (<?= $banda->bannome ?>)</h3>
                            <ol class="widget-list">
                                <?php
                                foreach ($banda->getVideos() as $video):
                                    $data = new DataCalendario($video->viddata);
                                    $artista = new Artista($video->artcodigo);
                                    $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                                    $foto = "admin/files/video/" . trim($video->vidfoto);

                                    if (!file_exists($imgp) or ! is_file($imgp)):
                                        $imgp = 'admin/files/images/user.png';
                                    endif;
                                    if (!file_exists($foto) or ! is_file($foto)):
                                        $foto = 'admin/files/video/video.jpg';
                                    endif;
                                    ?>
                                    <li>
                                        <a href="<?= $video->vidurl ?>" data-rel="prettyPhoto">
                                            <table>
                                                <tr>
                                                    <td style="padding-right:10px;">
                                                        <img src="<?= $imgp ?>" width="90" alt="" />
                                                    </td>
                                                    <td style="padding-right:10px;">
                                                        <img src="<?= $foto ?>" width="100" alt="" />
                                                    </td>
                                                    <td>
                                                        <time class="list-subtitle" style="color: #fff;"><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                                        <h4 class="list-title"><?=DadosFixos::TipoVideo($video->vidtipo)?></h4>
                                                        <h4 class="list-subtitle"> <?= $video->viddescricao ?></h4>
                                                    </td>
                                                </tr>
                                            </table>
                                        </a>
                                    </li>
                                <?php
                                endforeach;
                                ?>
                            </ol>
                        </div>

                    </article>
                </ol>
            </aside>

            <article class="post group">
                <?php
                $discos = $banda->getDiscos();
                $musicas = $banda->getMusicas();
                ?>
                <div class="entry-content">
                    <h3>Músicas gravadas</h3>				
                    <ol class="tracklisting">
                        <?php
                        $disco_autor = [];
                        if (!empty($discos)):
                            foreach ($discos as $disco_musica):
                                $musicas = new MusicaDisco($disco_musica->discodigo);
                                $musicas = $musicas->getMusicas();
                                if ($musicas):
                                    foreach ($musicas as $musica):


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
                                        
                                         // instrumento
                                        $instrumentos = Musica::getMusicos($musica->inscodigo);
                                        $instrumentos_format = [];
                                        foreach ($musicos as $musico):
                                            if ($musico instanceof  Artista) {
                                                $mi_instrumentos = $musico->getInstrumentosByMusica($musico->artcodigo, $musica->muscodigo);
                                                $mi_instrus = [];
                                                if ($mi_instrumentos) {
                                                    foreach ($mi_instrumentos as $instrumento) {
                                                        $mi_instrus[] = "<a href='?p=instrumentistas&id={$instrumento["inscodigo"]}'><i>".$instrumento["insnome"]."</i></a>";
                                                    }
                                                }

                                                $mi_instrus_formated = implode(", ", $mi_instrus);

                                                $instrumentos_format[] = "<a href='?p=artist&id={$musico->artcodigo}'>" . $musico->artusual."</a> ( " . $mi_instrus_formated . " )";
                                            }
                                        endforeach;
                                        $instrumentos_format = implode(" , ", $instrumentos_format);

                                        $audio = "admin/files/musicas/audio/{$musica->musaudio}";
                                        
                                        // produtores
                                        $produtores = Disco::getProdutor($disco_musica->discodigo);
                                        $produtores_format = [];
                                        foreach ($produtores as $produtor):
                                            $produtores_format[] = "<a href='?p=artist&id={$produtor->artcodigo}'>" . $produtor->artusual . "</a>";
                                        endforeach;
                                        $produtores_format = implode(" , ", $produtores_format);

                                        // arte
                                        $artes = Disco::getArte($disco_musica->discodigo);
                                        $artes_format = [];
                                        foreach ($artes as $arte):
                                            $artes_format[] = "<a href='?p=artist&id={$arte->artcodigo}'>" . $arte->artusual . "</a>";
                                        endforeach;
                                        $artes_format = implode(" , ", $artes_format);

                                        if (!in_array($disco_musica->discodigo, $disco_autor)):
                                            $disco_autor[] = $disco_musica->discodigo;
                                        else:
                                            break;
                                        endif;

                                        if (!file_exists($audio) or ! is_file($audio)):
                                            $audio = "#";
                                        endif;
                                        
                                        $gen  =  new Read;
                                        $genero = [];
                                        $genero['gencodigo'] = NULL;
                                        $genero['gennome'] = "Indefinido";

                                         @$gen->ExeRead('genero',"WHERE gencodigo = :c","c=$musica->gencodigo");
                                         if($gen->getRowCount()>0)
                                             $genero = $gen->getResult()[0];
                                        ?>

                                <li class="group track">
                                    <?php if ($musica->musativo == "S"): ?>
                                        <a href="<?= $audio ?>" id="<?= $musica->muscodigo ?>"  class="media-btn btn-play">Play</a>
                                    <?php else: ?>
                                        <a id="<?= $musica->muscodigo ?>" class="media-btn" style="background-color:#CCC;">Play</a>
                                    <?php endif; ?>
                                    <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> &nbsp; <a href="?p=estilos&genero=<?= $genero['gencodigo'] ?>"><?= $genero['gennome'] ?></a> &nbsp; <?=substr($musica->mussobre,0,120) ?></h5>
                                    <h4 class="track-title"><?= $musica->musnome ?></h4><br/>
                                    <table width="100%" border="0">
                                        <tr>
                                            <td  width="90">
                                                <small><img src="/images/icone/music.png" width="16"> Disco</small>
                                                <a href="?p=album&id=<?= $disco_musica->discodigo ?>" title="Ir para o DISCO:  <?=  $disco_musica->disnome ?> "class=""><img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="90" alt="" /></a>
                                            </td>
                                              <td  width="90">  <small><img src="/images/icone/star.png" width="16"> Autor</small>
                                                <a href="?p=artist&id=<?= $autor->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> "><img src="admin/files/artistas/<?= $autor->artfoto ?>" width="90" alt="" /></a>
                                            </td>
                                              <td  width="90">
                                                <small><img src="/images/icone/microfone.png" width="16"> Interprete</small>
                                                <a href="?p=artist&id=<?= $interprete->artcodigo ?>"  title="Ir para o INTÉRPRETE:  <?=  $interprete->artusual ?> "><img src="admin/files/artistas/<?= $interprete->artfoto  ?>" width="90" alt="" /></a>
                                            </td>
                                          <td width="10" align="right">
                                                <small></small><br/>
                                                <small></small><br/>
                                                <small></small><br/>
                                                <small></small><br/>
                                                <small></small><br/>
                                                <small></small><br/>
                                                <small></small>
                                            </td>
                                            <td style="padding-left: 20px; padding-right: 10px;" >
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <small><img src="/images/icone/star.png" width="16"> Autor(es):</small>
                                                    </div>
                                                    <div class="col-lg-8"><small><?= $autores_format ?></small></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <small><img src="/images/icone/microphone.png" width="16"> Interprete(s):</small>
                                                    </div>
                                                    <div class="col-lg-8"><small><?= $interpretes_format ?></small></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <small><img src="/images/icone/music.png" width="16"> Arranjos:</small>
                                                    </div>
                                                    <div class="col-lg-8"><small><?= $arranjos_format ?></small></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <small><img src="/images/icone/star.png" width="16"> Músicos:</small> & <small><img src="/images/icone/guitar.png" width="16"> Instrumentos:</small>
                                                    </div>
                                                    <!--div class="col-lg-8"><small><?= $musicos_format ?></small></div-->
                                                    <div class="col-lg-8"><small><?= $instrumentos_format ?></small></div>
                                                </div>

                                                <!--div class="row">
                                                    <div class="col-lg-4">
                                                        <small><img src="/images/icone/guitar.png" width="16"> Instrumentos:</small>
                                                    </div>
                                                    <div class="col-lg-8"><small><?= $instrumentos_format ?></small></div>
                                                </div-->


                                            </td>
                                        </tr>
                                    </table>


                                    <div class="action-btns">
                                        <?php
                                         $livro = Disco::getLivro($disco_musica->discodigo);
                                       //   if (!$livro->livtipo){
                                        //      $livro->livtipo = 2;
                                        //  }
                                         if ($musica->livativo == "S" && $livro): ?>
                                            <a href="livro.php?livcodigo=<?= $livro->livcodigo ?>" target="_blank"   onclick="Topo()" class="action-btn"><?=DadosFixos::TipoLivro($livro->livtipo)?></a>
                                        <?php else: ?>
                                            <a  onclick="Topo()" class="action-btn" style="background-color:#CCC;">Cancioneiro/Encarte</a>
                                        <?php endif; ?>
                                         <?php if ($musica->vidativo == "S"): ?>
                                           <a href="<?= $musica->musvideo ?>" data-rel="prettyPhoto"   onclick="Topo()" class="action-btn">Vídeo</a>
                                        <?php else: ?>
                                         <a data-rel="prettyPhoto"   onclick="Topo()" class="action-btn" style="background-color:#CCC;">Vídeo</a>
                                        <?php endif; ?>
                                          <?php if ($musica->letativo == "S"): ?>
                                           <a href="admin/files/musicas/letra/<?= $musica->musletra ?>"  onclick="Topo()" data-rel="prettyPhoto" class="action-btn">Letra</a>
                                        <?php else: ?>
                                         <a data-rel="prettyPhoto"   onclick="Topo()" class="action-btn" style="background-color:#CCC;">Letra</a>
                                        <?php endif; ?>

                                    </div>
                                    <div id="lyrics-1" class="track-lyrics-hold">
                                        <p><img src="admin/files/musicas/letra/<?= $musica->musletra ?>" width="auto"  alt="" /></p>
                                    </div>

                                </li>
                                      <header class="entry-top special-top">
                                                <br>
                                          <h5 class="track-title" style="padding-left: 120px; padding-right: 0px;">Produção & Designer Gráfico</h5>
                                          <div class="row">
                                              <table width="100%" border="0">
                                                <tr>
                                                    <td  width="100" width="100" style="margin-left: 50px; padding-right: -10px;">
                                                        <small><img src="/images/icone/music.png" width="16"> Disco</small>
                                                        <a href="?p=album&id=<?= $disco_musica->discodigo ?>" title="Ir para o DISCO:  <?=  $disco_musica->disnome ?> "class=""><img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="90" alt="" /></a>
                                                    </td>
                                                     <td  width="90">  <small><img src="/images/icone/lightbulb.png" width="16"> Produtor</small>
                                                          <a href="?p=artist&id=<?= $produtor->artcodigo ?>"  title="Ir para o PRODUTOR:  <?=  $produtor->artusual ?> "><img src="admin/files/artistas/<?= $produtor->artfoto ?>" width="90" alt="" /></a>
                                                     </td>
                                                     <td  width="90">
                                                          <small><img src="/images/icone/write.png" width="16"> Arte</small>
                                                          <a href="?p=artist&id=<?= $arte->artcodigo ?>"  title="Ir para o DESING GRÁFICO:  <?=  $arte->artusual ?> "><img src="admin/files/artistas/<?= $arte->artfoto  ?>" width="90" alt="" /></a>
                                                     </td>

                                                      <td style="padding-left: 50px; padding-right: 10px;" >
                                                         <div class="row">
                                                            <div class="col-lg-4">
                                                                    <small><img src="/images/icone/lightbulb-off.png" width="16"> Produtores:</small>
                                                            </div>
                                                            <div class="col-lg-8"><small><?= $produtores_format ?></small></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <small><img src="/images/icone/write.png" width="16"> Artes:</small>
                                                            </div>
                                                            <div class="col-lg-8"><small><?= $artes_format ?></small></div>
                                                        </div>
                                                   </td>
                                              </tr>
                                              </table>
                                          </div>
                                    </header>

                                        <?php
                                    endforeach;
                                endif;

                            endforeach;
                        endif;
                        ?>

                    </ol>
                    <h3>Sobre  - <?= $banda->bannome ?></h3>
                    <p>
                        <?= $banda->bandetalhe ?>
                    </p>
                </div>

            </article><!-- /post -->

        </div>
        <div class="large-3 columns sidebar sidebar-1">
            <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgp ?>" data-rel="prettyPhoto[gal_cc]">
                                <img src="<?= $imgp ?>" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                            <figcaption>
                                <table>
                                    <tr>
                                        <?php
                                        for ($index = 2; $index < 6; $index++):
                                            $var = "banfoto" . $index;
                                            $imgp = "admin/files/bandas/" . trim($banda->$var);
                                            if (!file_exists($imgp) or ! is_file($imgp)):
                                                $imgp = 'admin/files/imagem/user.png';
                                            endif;
                                            ?>
                                            <td> <a href="<?= $imgp ?>" data-rel="prettyPhoto[gal_cc]"> <img src="<?= $imgp ?>" /></a></td>
                                        <?php endfor; ?>
                                    </tr>
                                </table>
                            </figcaption>
                        </figure>
                    </li>
                </ol>
            </aside><!-- /widget -->
            <aside class="widget group">
                <h3 class="widget-title">Dados da Banda</h3>
                <ol class="tracklisting tracklisting-top">
                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Endereço:</h5>
                        <h4 class="track-title">&nbsp;<?= $banda->banedereco ?></h4>
                    </li>
                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Bairro:</h5>
                        <h4 class="track-title">&nbsp;<?= $banda->banbairro ?></h4>
                    </li>
                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">CEP:</h5>
                        <h4 class="track-title">&nbsp;<?= $banda->bancep ?></h4>
                    </li>
                     <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Cidade-UF:</h5>
                        <h4 class="track-title">&nbsp;<?= $banda->bancidade ?>-<?= $banda->banuf ?></h4>
                    </li>
                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Contato:</h5>
                        <h4 class="track-title">&nbsp;<?= $banda->bancontato ?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Email:</h5>
                        <h4 class="track-meta">&nbsp;<?= $banda->banemail ?></h4>
                    </li>

                    <li class="group track">
                        <a class="fa fa-home"></a>
                        <h5 class="track-meta">Responsável:</h5>
                        <h4 class="track-title">&nbsp;<?= $banda->banresponsavel ?></h4>
                    </li>

                </ol>
            </aside><!-- /widget -->

            <!-- ** instrumento-->

        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
