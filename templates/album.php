<!--
<div id="section" style="background:url(images/header.jpg) no-repeat top center">
        <div class="row">
                <div class="large-12 columns">
                        <h3>Discography</h3>
                </div> /large-12 
        </div> /row 
</div> /section -->

<?php

$disco = new Disco($_GET['id']);
$id_artista = explode(';', $disco->artcodigo);
$id_artista = $id_artista[0];
$imgp = "admin/files/discos/" . trim($disco->disimagem);
if (!file_exists($imgp) or ! is_file($imgp)):
    $imgp = 'admin/files/imagem/disco.png';
endif;
 // autores
$artista = $disco->getParticipantes()[0];

?>

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
        right: 10px;
        bottom: 20px;
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
<div id="main-wrap" style="padding-top: 85px">
    <div id="main" class="row">
        <div class="large-9 columns">

            <aside class="widget group" style="display: none">
                <h3 class="widget-title">Rádio Online</h3>
                <div class="widget-content">
                    <div class="modal fade" style="margin-top: 10%;" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background:#262626 ">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        <img src="images/logo.png" style="max-height: 30px;" alt="" />
                                    </h5>
                                </div>
                                <div class="modal-body" id="body">
                                    <?php include "player/disco.php"?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img style="cursor: pointer"  data-toggle="modal" data-target="#exampleModal" src="images/radio_disco.png">
                </div>
            </aside>
            <article class="post group">

                <header class="entry-top special-top">
                    <h1 class="entry-title page-title"><a href="#"><?= $disco->disnome ?>(<?= $artista->artusual ?>)</a></h1>
                    <ul class="cpt-meta">
                        <li><span>Dt.Lançamento:</span><?= DataCalendario::date2br($disco->disdata) ?></li>
                        <li><span>Título:</span> <?= $disco->disnome ?> </li>
                        <li><span>Gravadora:</span> <?= $disco->disgravadora ?> </li>
                        <li><span>Editora:</span> <?= $disco->diseditoracao ?> </li>
                        <li><span>Mixagem:</span> <?= $disco->dismix ?> </li>
                        <li><span>Masterização:</span> <?= $disco->dismasterizacao ?> </li>
                        <li><span>Quantidade:</span> <?= $disco->disquantidade ?> </li>
                        <li><span>Preço:</span> R$ <?= $disco->dispreco ?> </li>
                        <li><span>Fale com o autor:</span><a href="?p=contato" class="action-btn">Contato</a></li>
                    </ul>
                    <span>Sobre:</span>
                        <div class="entry-content">
                           <?= $disco->dissobre ?>
                        </div>
                </header>

                <?php
                $musicas_disco = new MusicaDisco($disco->discodigo);
                $musicas = $musicas_disco->getMusicas();
                ?>
                <div class="entry-content">
                    <h3>Músicas gravadas</h3>
                    <ol class="tracklisting">
                        <?php
                        if ($musicas):
                            foreach ($musicas as $musica):
                                //disco
                                $musica_disco = new MusicaDisco(null, $musica->muscodigo);
                                $disco_musica = $musica_disco->getDisco();

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

                                // musicos
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

                                $audio = "admin/files/musicas/audio/{$musica->musaudio}";

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
                                    <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> 
                                        &nbsp; <a href="?p=estilos&genero=<?= $genero['gencodigo'] ?>"><?= $genero['gennome'] ?></a> 
                                        &nbsp; <?=substr($musica->mussobre,0,120) ?>
                                    </h5>
                                    <h4 class="track-title"><?= $musica->musnome ?></h4>
                                    <a href="?p=album-musica&id=<?= $disco_musica->discodigo ?>&muscodigo=<?= $musica->muscodigo ?>"> 
                                        &nbsp;<img src="/images/icone/music.png" width="16">
                                    </a>
                                    <br/>
                                    <table width="100%" border="0">
                                        <tr>
                                            <td  width="90">
                                                <small><img src="/images/icone/music.png" width="16"> Disco</small>
                                                <a href="?p=album&id=<?= $disco_musica->discodigo ?>" title="Ir para o DISCO:  <?=  $disco_musica->disnome ?> "class="">
                                                    <img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="90" alt="" />
                                                </a>
                                            </td>
                                              <td  width="90">  <small><img src="/images/icone/star.png" width="16"> Autor</small>
                                                <a href="?p=artist&id=<?= $autor->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> ">
                                                    <img src="admin/files/artistas/<?= $autor->artfoto ?>" width="90" alt="" />
                                                </a>
                                            </td>
                                              <td  width="90">
                                                <small><img src="/images/icone/microfone.png" width="16"> Interprete</small>
                                                <a href="?p=artist&id=<?= $interprete->artcodigo ?>"  title="Ir para o INTÉRPRETE:  <?=  $interprete->artusual ?> ">
                                                    <img src="admin/files/artistas/<?= $interprete->artfoto  ?>" width="90" alt="" />
                                                </a>
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
                                        <a title="Veja o ENCARTE deste DISCO" href="livro.php?livcodigo=<?= $livro->livcodigo ?>" target="_blank"   onclick="Topo()" class="action-btn">
                                            <img src="/images/icone/book.fw.png" width="15">&nbsp;<?=DadosFixos::TipoLivro($livro->livtipo)?>
                                        </a>&nbsp;
                                        <?php else: ?>
                                            <a  onclick="Topo()" class="action-btn" style="background-color:#CCC;">
                                                <i class="fa fa-book"></i> Cancioneiro/Encarte
                                            </a>
                                        <?php endif; ?>
                                         <?php if ($musica->vidativo == "S"): ?>
                                           <a title="Veja o VÍDEO desta MUSICA" href="<?= $musica->musvideo ?>" data-rel="prettyPhoto"   onclick="Topo()" class="action-btn">
                                               <img src="/images/icone/video.fw.png" width="15">&nbsp;Vídeo
                                           </a>&nbsp;
                                        <?php else: ?>
                                         <a data-rel="prettyPhoto"   onclick="Topo()" class="action-btn" style="background-color:#CCC;">Vídeo</a>
                                        <?php endif; ?>
                                          <?php if ($musica->letativo == "S"): ?>
                                           <a title="Veja a LETRA desta MÚSICA" href="admin/files/musicas/letra/<?= $musica->musletra ?>"  onclick="Topo()" data-rel="prettyPhoto" class="action-btn">
                                               <img src="/images/icone/letra.fw.png" width="15">&nbsp;Letras
                                           </a>&nbsp;
                                        <?php else: ?>
                                         <a data-rel="prettyPhoto"   onclick="Topo()" class="action-btn" style="background-color:#CCC;"></a>
                                        <?php endif; ?>
                                         <a title="Veja os DETALHES Completos do DISCO" href="?p=album-musica&id=<?= $disco_musica->discodigo ?>&muscodigo=<?= $musica->muscodigo ?>" onclick="Topo()" class="action-btn"  > 
                                              &nbsp;<img src="/images/icone/music.png" width="13"  >&nbsp;Detalhe
                                         </a>
                                    </div>
                                    

                                </li>

                                <?php
                            endforeach;
                        endif;
                        ?>
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
                                     
                                      <?php
                                      /** @AGUADE 
                                         $arte->artfoto = "";  
                                         if (empty($arte->artcodigo)):
                                             $arte->artfoto = "images/ARTES_GERAL.jpg";
                                          endif;
                                       * 
                                       */
                                      ?>
                                       
                                      <a href="?p=artist&id=<?= $arte->artcodigo ?>"  
                                         title="Ir para o DESING GRÁFICO:  <?=  $arte->artusual ?> ">
                                         <img src="admin/files/artistas/<?= $arte->artfoto  ?>" width="90" alt="" />
                                       </a>
                                      
                                     
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
                        <script>
                            var musica_tocando  =  null;
                            player_tocando = true
                            $('.media-btn').click(function (e) {
                                console.log(e.target.id)
                                if (musica_tocando === e.target.id && player_tocando === false) {
                                    player.play(player.index)
                                    player_tocando = true
                                } else {
                                    player.pause()
                                    player_tocando  = false
                                    musica_tocando = e.target.id
                                }
                            })
                        </script>

                    </ol>

                </div>
<!--                    --><?php //include 'inc/cliente.php' ?>



            </article><!-- /post -->
            <article class="post group">
                <header class="entry-top special-top">
                    <h1 class="entry-title page-title">Notícias</h1>
                </header>
                <div class="entry-content">
                    <ul style="list-style: none">
                        <?php
                        $artista = new Artista($id_artista);
                        $noticias =  $artista->getNoticias();
                        if ($noticias):
                            foreach ($noticias as $noticia):
                                $noticia = new Noticia($noticia['notid']);
                                $data = DataCalendario::date2us($noticia->notdata);
                                $data = new DataCalendario($data);
                                $imgnot = "admin/files/noticias/" . trim($noticia->notfoto);
                                if (!file_exists($imgnot) or ! is_file($imgnot)):
                                    $imgnot = 'admin/files/imagem/user.png';
                                endif;
                                ?>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 25%; margin-right: 5px;">
                                                <a href="?p=single&id=<?= $noticia->notid ?>">
                                                    <figure class="entry-thumb" style="text-align:center;">
                                                        <img src="<?= $imgnot ?>" alt="" />
                                                    </figure>
                                                </a>
                                            </td>
                                            <td>
                                                <time class="list-subtitle" ><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                                <h4 class="list-title"><a href="?p=single&id=<?= $noticia->notid ?>"><?= $noticia->nottitulo ?></a></h4>
                                                <a href="?p=single&id=<?= $noticia->notid ?>" class="action-btn">Mais detalhes ...</a>
                                            </td>
                                        </tr>
                                    </table>

                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>

            </article>

                <div id="main" class="row">
              <div class="large-12 columns">


              </div>
              </div>
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
                            <div class="titulo_song" id="titulo_song"></div>
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
        <div class="large-3 columns sidebar sidebar-1" >
            <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgp ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgp ?>" /> <?= $disco->disnome ?>(<?= $artista->artusual ?>)
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                        </figure>
                        <h5 class="list-subtitle">Clique &nbsp; para  &nbsp;  ampliar</h5>
                    </li>
                </ol>
            </aside>
          
            <aside class="widget group">
                <?php
                $artista = new Artista($id_artista);
                $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>

                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="?p=artist&id=<?= $artista->artcodigo ?>">
                                <img src="<?= $imgp ?>" /> <?= $artista->artusual ?>
                                <div class="overlay icon-info"></div>								
                            </a>

                            <?php
                            $artista_tipos = new ArtistaTipo();

                            foreach ($artista_tipos->getResult() as $artista_tipo):
                                $tipocodigo = $artista_tipo['arttipocodigo'];
                                $tiponome = $artista_tipo['arttiponome'];
                                if ($tipocodigo == $artista->arttipocodigo):
                                    ?>
                                </figure>
                                <h5 class="list-subtitle"><?= $artista_tipo['arttiponome'] ?></h5>

                                <?php
                            endif;
                        endforeach;
                        ?>

                    </li>
                     <?php 
                        $gal = new Read();
                        $gal->ExeRead("galeria", "WHERE galartista = :id limit 1", "id=".$artista->artcodigo);
                        
                        if ($gal->getResult()) {
                            
                         $galeria = $gal->getResult()[0];   
                    ?>
                    
                    <li>
                        <figure class="event-thumb">
                            <a href="?p=gallery&tipo=1&id=<?= $artista->artcodigo ?>">
                                <img src="admin/files/galeria/<?=$galeria['galarquivo']?>" />
                                <div class="overlay icon-camera"></div>								
                            </a>
                        </figure>
                        <h5 class="list-subtitle">Galeria de Fotos</h5>
                    </li>
                    
                    <?php } else {?>
                    <li>
                        <figure class="event-thumb">
                            <a href="?p=gallery&tipo=1&id=<?= $artista->artcodigo ?>">
                                <img src="images/galeria.png" />
                                <div class="overlay icon-camera"></div>								
                            </a>
                        </figure>
                        <h5 class="list-subtitle">Galeria de Fotos</h5>
                    </li>
                    <?php }?>
                </ol>
                     
            </aside><!-- /widget -->
              <aside class="widget group">
               <h3 class="widget-title">Redes Sociais</h3>
                 <ol class="widget-list widget-list-single">
                     <a href="?p=artist&id=<?= $artista->artcodigo ?>">
                          <img src="<?= $imgp ?>" /> <?= $artista->artusual ?>
                          <div class="overlay icon-info"></div>								
                     </a>
                  
                    <aside class="widget group"> 
                  <nav id="nav">
                     <span style="color:#001a35; text-align: left;"><?= trim($artista->artusual) ?></span>
                      <ul id="navigation" class="group" style="margin-bottom: 100px;">
                      <li>
                         <a href="<?= $artista->artfacebook ?>" target="_blank" class="" title="Siga <?= trim($artista->artusual) ?> no Facebook.  ">
                             <img class="par" width="25" height="25" src="images/facebook1.png"/>
                         </a>
                      </li>
                      <li>
                         <a href="<?= $artista->artinstagram ?>" target="_blank" class="" title="Siga  <?= trim($artista->artusual) ?> no Instagram.">
                              <img class="par" width="25" height="25" src="images/instagram1.png"/>
                         </a>
                      </li>
                      <li>
                         <a href="<?= $artista->arttwitter ?>" target="_blank" class="" title="Siga <?= trim($artista->artusual) ?> no Twitter." >
                              <img class="par" width="25" height="25" src="images/twitter1.png"/>
                         </a>
                      </li>
                      <li>
                         <a href="<?= $artista->artyuotube ?>" target="_blank" class="" title="Siga  <?= trim($artista->artusual) ?> no Yuo Tube.">
                              <img class="par" width="25" height="25" src="images/yuotube1.png"/>
                         </a>
                       </li>
                      <li>
                         <a href="<?= $artista->artwhatsapp ?>" target="_blank" class="" title="Siga <?= trim($artista->artusual) ?> no WhatsApp.">
                            <img class="par" width="25" height="25" src="images/whatsapp1.png"/>
                         </a>
                       </li>
                  
                      <li>
                        <a href='<?= $artista->artsoundcloud ?>'  target="_blank" title="Siga <?= trim($artista->artusual) ?> no SoundCloud." >
                            <img class="par" width="25" height="25" src="images/soudcloud.png"/> 
                       </a>
                          
                       </li>
                    </ul>
                 </nav>
                    </aside> 
                          
                 <li>
                        <figure class="event-thumb">
                            <?php 
                             //  if ($artista->artsound): ?>
                                  <!--iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/users/<?=$artista->artsound?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe-->
                            <?php //endif; ?>
                        </figure>
                 </li>
                  </ol>
               
            </aside><!-- /widget -->
            
            <aside class="widget group">
                <?php include 'inc/dados-artista.php' ?>
            </aside>
            <aside class="widget group">

                <?php
                $participantes = $disco->getParticipantes();
                ?>
                <h3 class="widget-title">Participantes</h3>
                <ol class="tracklisting tracklisting-top">
                    <?php
                    if ($participantes):
                        foreach ($participantes as $participante):
                            $imgp = "admin/files/artistas/" . trim($participante->artfoto);
                            if (!file_exists($imgp) or ! is_file($imgp)):
                                $imgp = 'admin/app/images/user.png';
                            endif;
                            ?>
                            <li class="group track">
                                <a href="?p=artist&id=<?= $participante->artcodigo ?>" class="">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td  width="65" align="left"> 
                                                <img src="<?= $imgp ?>" width="50" style="max-height: 50px;" alt="" />
                                            </td>
                                            <td align="left">
                                                <h5 class="track-meta"><?= $participante->artusual ?></h5>
                                            </td>
                                   </tr>
                                    </table>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>

                </ol>
            </aside>


            <!-- ** instrumento-->
            <?php //include 'inc/instrumento.php' ?>

        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
