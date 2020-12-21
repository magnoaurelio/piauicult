<style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700");

    .player .head .front, .player .head .infos, .player .timeline .volume, .player .timeline .controllers, .player .timeline .controllers .back, .player .timeline .controllers .play, .player .timeline .controllers .forward {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .radio-fixed {
        border-radius: 0;
        color: #232323;
        display: inline-block;
        font-size: 1rem;
        height: auto;
        line-height: 50px;
        outline: none;
        position: fixed;
        right: 5px;
        bottom: 15px;
        text-align: center;
        z-index: 50000;
        width: auto;
        -webkit-transition-property: right; /* Safari */
        -webkit-transition-duration: 2s; /* Safari */
        transition-property: right;
        transition-duration: 2s;
        /* Hover styles,
        media queries */
    }


</style>
<div id="main-wrap"  style="margin-top: 30px">
    <div id="main" class="row">
        <div class="large-6 columns">
           

            <aside class="widget group" style="margin-top: 0px;">
                <h3 class="widget-title widget-title-pos"><a href="#">Notícias (<small>do Portal</small>)</a></h3> </h3>
                <?php
                $noticias = new Noticia(null, "ORDER BY notid DESC");
                if ($noticias->getResult()) :

                    // var_dump($noticias);

                    foreach ($noticias->getResult() as $noticia):
                        $home = $noticia['home'];
                        if ($home == 1) :
                            $noticia = new Noticia($noticia['notid']);
                            $data = DataCalendario::date2us($noticia->notdata);
                            $data = new DataCalendario($data);
                            $imgp = "admin/files/noticias/" . trim($noticia->notfoto);
                            if (!file_exists($imgp) or !is_file($imgp)):
                                $imgp = 'admin/files/imagem/user.png';
                            endif;
                            ?>
                            <article class="post group">
                                <header class="entry-top">
                                    <time datetime="<?= $noticia->notdata ?>"><?= $data->getDia() ?>
                                        <span><?= substr($data->getMes(), 0, 3) ?></span></time>
                                    <h2 class="entry-title"><a
                                                href="?p=single&id=<?= $noticia->notid ?>"><?= $noticia->nottitulo ?></a>
                                    </h2>
                                    <div class="entry-meta">
                                        <!--     Postado: <a href="#">Eventos</a> <span>&bull;</span>
                                                 <a class="comments-link" href="#">Nﾃ｣o hﾃ｡ Comentﾃ｡rios</a>-->
                                    </div>
                                </header>
                                <a href="?p=single&id=<?= $noticia->notid ?>">
                                    <figure class="entry-thumb" style="text-align:center;">
                                        <img src="<?= $imgp ?>" alt=""/>
                                    </figure>
                                </a>
                                <div class="entry-content">
                                    <div style="max-height: 100px; display: block; overflow: hidden">
                                        <?= $noticia->notnoticia ?>
                                    </div>
                                    <a href="?p=single&id=<?= $noticia->notid ?>" class="read-more">Veja mais</a>
                                </div>
                            </article><!-- /post -->
                        <?php
                        endif;
                    endforeach;
                endif;
                ?>
            </aside>
            <aside class="widget group">
                <h3 class="widget-title"><a href="#">Rádio Online (<small>Músicas no ar</small>)</a></h3>
                <div class="widget-content">
                    <div class="modal fade" style="margin-top: 10%;" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background:#262626 ">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        <img src="images/logo.png" style="max-height: 30px;" alt=""/>
                                    </h5>
                                </div>
                                <div class="modal-body" id="body">
                                    <?php include "player/index.php" ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img class="img-radio" data-toggle="modal" data-target="#exampleModal" src="images/radioplay.png">
                </div>

            </aside>
        </div>


        <div id="radiofixed" class="radio-fixed">
            <span  id="fecharmodal" class="close"></span>
            <div class="player">
                <div class="head">
                    <div class="back"></div>
                    <div class="front">
                        <div class="avatar"><img id="avatar-artista" src="nada"/></div>
                        &nbsp;
                        <div class="infos">
                            <div class="titulo_song" id="titulo_song"></div><br>
                            <!--div class="titulo_disco" id="titulo_disco"></div-->
                            <!-- <div class="duracao_song"><i class="fa fa-clock-o">Total time 45:12</i></div>-->
                            <div class="tags" id="tags"></div>
                        </div>
                        <img style="float: right" id="avatar-disco" src="nada" width="100" />

                    </div>
                </div>
                <div class="timeline">
                    <div class="soundline"></div>
                    <div class="controllers active">
                        <div id="_previous" class="back"></div>
                        <div id="_player" class="play"></div>
                        <div id="_pause" class="pause"></div>
                        <div id="_next" class="forward"></div>
                    </div>
                </div>
            </div>
            <div class="rotation"></div>
        </div>

        <script>
                function atualizar() {
                    $("#avatar-artista").attr("src", MUSICAS[player.index].artista.foto);
                    $("#avatar-disco").attr("src", MUSICAS[player.index].disco.imagem);
                    $("#titulo_song").text(MUSICAS[player.index].title);
                    $("#tags").html("<span>" + MUSICAS[player.index].artista.artusual + "</span>");
                    $("#_player").hide()
                    $("#_pause").show()
                }

                atualizar();
                var fechado = false
                $('#fecharmodal').click(function (e) {
                    if (fechado) {
                        $('#radiofixed').removeClass("fecharmodal")
                        fechado = false;
                    }else {
                        $('#radiofixed').addClass("fecharmodal")
                        fechado = true;
                    }
                });

                $('#_player').click(function (e) {
                    $("#_player").hide()
                    $("#_pause").show()
                    player.play(player.index)
                })

                $('#_pause').click(function (e) {
                    $("#_pause").hide()
                    $("#_player").show()
                    player.pause()
                })

                $('#_previous').click(function (e) {
                    player.skip("prev");
                    atualizar();
                })

                $('#_next').click(function (e) {
                    player.skip("next");
                    atualizar();
                })

        </script>
      
        <div class="large-3 columns sidebar sidebar-1">
             <aside class="widget group">
                <?php
                $musicas = new Read();
                $musicas->ExeRead("musica", "WHERE muslanca = 'S' ORDER BY mustocada desc limit 4");
                ?>
                <figure class="event-thumb">
                    <a href="?p=disco" title="Veja mais DISCOS">
                        <img src="images/radioplay2.png" width="300px;" height="50px;" alt=""/>
                        <div class="overlay icon-info-sign"></div>
                    </a>
                </figure>
                <h3 class="widget-title"><a href="#">Lançamentos PIAUICult</a></h3>
                <div class="twitter_update_list">

                    <ol class="tracklisting">

                        <?php
                        foreach ($musicas->getResult() as $musica):
                            $musica = new Musica($musica['muscodigo']);
                            //disco
                            $musica_disco = new MusicaDisco(null, $musica->muscodigo);
                            $disco_musica = $musica_disco->getDisco();
                            //var_dump($musica_disco);
                            //$disnome = $disco_musica['disnome'];

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
                            ?>

                            <li class="group track">
                                <a href="admin/files/musicas/audio/<?= $musica->musaudio ?>"
                                   id="<?= $musica->muscodigo ?>" class="media-btn">Play</a>
                                <a title="<?= $disco_musica->disnome ?>"
                                   href="?p=album&id=<?= $disco_musica->discodigo ?>" class=""><img
                                            src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="30" alt=""/>&nbsp;<small><?= $disco_musica->disnome ?></small>
                                </a>
                                <h5 class="track-meta">&nbsp;<?= $interpretes_format ?></h5>
                                <h4 class="track-title"><?= $musica->musnome ?></h4>
                            </li>

                        <?php
                        endforeach;
                        ?>

                        <script>
                            var musica_tocando = null;
                            player_tocando = true
                            $('.media-btn').click(function (e) {
                                if (musica_tocando === e.target.id && player_tocando === false) {
                                    player.play(player.index)
                                    player_tocando = true
                                } else {
                                    player.pause()
                                    player_tocando = false
                                    musica_tocando = e.target.id
                                }
                            })
                        </script>

                    </ol>
                </div>
            </aside>
            <aside class="widget widget_ci_social_widget group">
                <h3 class="widget-title"><a href="#">Rede Social</a></h3>
                <div class="widget-content">
                    <!--                    <a href="#" class="icn rss" title="Subscribe to our RSS feed.">Subscribe to our RSS feed.</a>-->
                    <a href="https://www.facebook.com/PiauíCult-288245738509481" target="_blank" class="icn facebook"
                       title="Nos encontre no Facebook">Nos encontre no Facebook</a>
                    <a href="https://www.instagram.com/piauicult/" target="_blank" class="icn instagram">Instagram</a>
                    <a href="https://twitter.com/CultPiaui" target="_blank" class="icn twitter"
                       title="Siga-nos no twitter.">Siga-nos no twitter.</a>
                    <!--                    <a href="#" class="icn dribbble" title="See our Dribbble shots.">See our Dribbble shots.</a>-->
                    <!--                    <a href="#" class="icn behance">Behance</a>-->
                    <!--                    <a href="#" class="icn lastfm">Last.FM</a>-->
                    <!--                    <a href="#" class="icn soundcloud">SoundCloud</a>-->
                    <!--                    <a href="#" class="icn tumblr">Tumblr</a>-->
                    <!--                    <a href="#" class="icn pinterest">Pinterest</a>-->
                    <!--                    <a href="#" class="icn skype">Skype</a>-->
                    <!--                    <a href="#" class="icn gtalk">Gtalk</a>-->
                </div>
            </aside>


            <aside class="widget group">
                <?php
                $musicas = new Read();
                $musicas->ExeRead("musica", "ORDER BY mustocada desc limit 10");
                ?>
                <figure class="event-thumb">
                    <a href="?p=disco" title="Veja mais DISCOS">
                        <img src="images/piaui_cult_1.jpg" width="300px;" alt=""/>
                        <div class="overlay icon-info-sign"></div>
                    </a>
                </figure>
                <h3 class="widget-title"><a href="#">As 10 + Tocadas Aqui!</a></h3>
                <div class="twitter_update_list">

                    <ol class="tracklisting">

                        <?php
                        foreach ($musicas->getResult() as $musica):
                            $musica = new Musica($musica['muscodigo']);
                            //disco
                            $musica_disco = new MusicaDisco(null, $musica->muscodigo);
                            $disco_musica = $musica_disco->getDisco();
                            //var_dump($musica_disco);
                            //$disnome = $disco_musica['disnome'];

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
                            ?>

                            <li class="group track">
                                <a href="admin/files/musicas/audio/<?= $musica->musaudio ?>"
                                   id="<?= $musica->muscodigo ?>" class="media-btn">Play</a>
                                <a title="<?= $disco_musica->disnome ?>"
                                   href="?p=album&id=<?= $disco_musica->discodigo ?>" class=""><img
                                            src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="30" alt=""/>&nbsp;<small><?= $disco_musica->disnome ?></small>
                                </a>
                                <h5 class="track-meta">&nbsp;<?= $interpretes_format ?></h5>
                                <h4 class="track-title"><?= $musica->musnome ?></h4>
                            </li>

                        <?php
                        endforeach;
                        ?>

                        <script>
                            var musica_tocando = null;
                            player_tocando = true
                            $('.media-btn').click(function (e) {
                                if (musica_tocando === e.target.id && player_tocando === false) {
                                    player.play(player.index)
                                    player_tocando = true
                                } else {
                                    player.pause()
                                    player_tocando = false
                                    musica_tocando = e.target.id
                                }
                            })
                        </script>

                    </ol>
                </div>
            </aside>
            <!----------------------------
            ** artistas-->
            <?php include 'inc/artistas_compositor_rand.php' ?>
            <!----------------------------
           ** artistas-->
            <?php include 'inc/artistas_cantor_rand.php' ?>
            <!----------------------------
    ** artistas-->
            <?php include 'inc/artistas_arranjador_rand.php' ?>
            <!----------------------------
                       ** artistas-->
            <?php include 'inc/artistas_musico_rand.php' ?>
            <!----------------------------artistas-->
            <?php //include 'inc/artistas_grupo_rand.php' ?>

            <!-- ** artistas-->
            <?php include 'inc/artistas_produtor_rand.php' ?>

            <?php include 'inc/artistas_grupo_rand.php' ?>
            <?php include 'inc/projeto_rand.php' ?>
            <?php include 'inc/video_rand.php' ?>
            <!--aside class="widget group">
                <h4 class="widget-title">Videos</h4>
                <ol class="widget-list">
                    <li>
                        <figure class="event-thumb">
                            <a href="?p=videos">
                                <img src="demo/album06.jpg" alt="" />
                                <div class="overlay icon-play-sign"></div>
                            </a>
                        </figure>
                        <time class="list-subtitle" datetime="2016-05-20 22:00"><?= date("d/m/Y") ?></time>
                        <h4 class="list-title"><a href="video.php">VÍDEOS DIVERSOS</a></h4>
                    </li>

                </ol>
            </aside><!-- /widget -->
            <!----------------------------
            ** artistas-->

            <aside class="widget group">
                <?php
                $discos = new Read();
                $discos->ExeRead("disco", "ORDER BY rand() limit 1");
                //"WHERE arttipocodigo = 5", "ORDER BY rand limit 1"
                ?>

                <h4 class="widget-title"><a href="?p=disco">Discos Gravados</a></h4>
                <ol class="widget-list widget-list-single">

                    <?php

                    foreach ($discos->getResult() as $disco):
                        ?>
                        <li>
                            <figure class="event-thumb">
                                <a href="?p=album&id=<?= $disco['discodigo'] ?>">
                                    <img src="admin/files/discos/<?= $disco['disimagem'] ?>" alt=""/>
                                    <div class="overlay icon-info-sign"></div>
                                </a>
                            </figure>
                            <h5 class="list-title" style="margin-bottom: 5px; letter-spacing: 0.1px;"><a
                                        href="?p=album&id=<?= $disco['discodigo'] ?>"><?= $disco['disnome'] ?></a></h5>
                            <? //$date =  date($disco['disdata'],'d-m-Y');

                            ?>

                            <span class="track-meta" datetime="2016-05-20 22:00"><?= $disco['disdata'] ?></span>
                            <a href="?p=album&id=<?= $disco['discodigo'] ?>" class="action-btn">Veja o CD</a>
                        </li>
                    <?php
                    endforeach;
                    ?>

                </ol>
            </aside>
            <aside class="widget group">
                <?php
                $livros = new Read();
                $livros->ExeRead("livro", "ORDER BY rand() limit 1");
                //"WHERE arttipocodigo = 5", "ORDER BY rand limit 1"
                ?>

                <h4 class="widget-title"><a href="?p=disco">Cancioneiro/Encarte</a></h4>
                <ol class="widget-list widget-list-single">

                    <?php

                    foreach ($livros->getResult() as $livro):
                        ?>
                        <li>
                            <figure class="event-thumb">
                                <a target="_blank" href="livro.php?livcodigo=<?= $livro['livcodigo'] ?>">
                                    <img src="admin/files/livros/<?= $livro['livfoto'] ?>" alt=""/>
                                    <div class="overlay icon-info-sign"></div>
                                </a>
                            </figure>
                            <h5 class="list-title" style="margin-bottom: 5px; letter-spacing: 0.1px;">
                                <a target="_blank" href="livro.php?livcodigo=<?= $livro['livcodigo'] ?>"><?= $livro['livnome'] ?></a>
                            </h5>
                            <? //$date =  date($disco['disdata'],'d-m-Y');

                            ?>
                        </li>
                    <?php
                    endforeach;
                    ?>

                </ol>
            </aside>
            
              <?php include 'inc/humor_rand.php' ?>
            
            <aside class="widget group">
                <?php
                $cinemas = new Read();
                $cinemas->ExeRead("cinema", "ORDER BY rand() limit 2");
                //"WHERE arttipocodigo = 5", "ORDER BY rand limit 1"
                ?>

                <h4 class="widget-title"><a href="?p=festivais-cinema">Cinema</a></h4>
                <ol class="widget-list widget-list-single">

                    <?php
                  
                    foreach ($cinemas->getResult() as $cinema):
                        $cinema = new Cinema($cinema["cincodigo"]);
                        $paginaLivro =  $humor->getPagina();
                        $livro = $paginaLivro->getLivro();
                        
                        $artista = $cinema->getArtista('$id');
                        $artusual = $artista->artusual;
                       // var_dump($artusual);

                        $premio = new FestivalPremio($cinema->fesprecodigo);
                        $fesprenome = $premio->fesprenome;
                        $fesprefoto = "admin/files/festivais/" . $premio->fesprefoto;

                        ?>
                        <li>
                            <figure class="event-thumb">
                                <a  href="?p=cinema-detalhe&id=<?=$cinema->cincodigo ?>" title="Assista ao Filme:  <?= $cinema->cinnome ?> ">
                                    <img src="admin/files/cinema/<?= $cinema->cinimagem ?>" alt=""/>
                                    
                                    <div class="overlay icon-info-sign"></div>
                                </a>
                            </figure>
                            
                            <img src="<?= $fesprefoto ?>" width="40"/> <?= $fesprenome ?> 
                            
                            <h5 class="list-subtitle"
                                style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                                <a href="?p=cinema-detalhe&id=<?=$cinema->cincodigo ?>" title="Assista ao Filme:  <?= $cinema->cinnome ?> ">
                                    <?= $cinema->cinnome?><br>
                                </a>
                                <a href="?p=cinema-detalhe&id=<?=$cinema->cincodigo ?>" title="Assista ao Filme:  <?= $cinema->cinnome ?> ">
                                    <small style="color: red; font-size: 16px; font-weight: 400"><?= $cinema->getGenero()->descricao ?></small>
                                </a>
                                  <?php
                                    $elenco = $cinema->getElenco();
                                     if ($elenco):
                                        foreach ($elenco as $artista):
                                            $artista =  new Artista($artista["artcodigo"]);
                                    ?>
                                <a href="?p=artista-cinema&id=<?= $artista->artcodigo ?>" class="" title="Veja detalhe do autor: <?= $artista->artusual ?>">
                                    <img src="admin/files/artistas/<?= $artista->artfoto ?>" width="50" alt=""/> <?= $artista->artusual ?>-<?= $artista->artuf?>
                                </a>
                                <?php
                                   endforeach;
                               endif;
                                ?>

                            </h5>
                            <? //$date =  date($disco['disdata'],'d-m-Y');

                            ?>
                        </li>
                        <?php
                    endforeach;
                    ?>

                </ol>
            </aside>

        </div><!-- /sidebar-1 -->

        <div class="large-3 columns sidebar sidebar-2">

            <!--** eventos-->
            <?php include 'inc/eventos.php' ?>


        </div><!-- /sidebar-2 -->
    </div><!-- /main -->
</div><!-- /main-wrap -->
