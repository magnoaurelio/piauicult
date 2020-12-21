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


<div id="main-wrap" style="padding-top: 20px">
    <div id="main" class="row">
        <div class="large-9 columns">
            <aside class="widget group">
                <h3 class="widget-title">Rádio Online</h3>
                <div class="widget-content">
                    <div class="modal fade" style="margin-top: 10%;" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="background:#262626 ">
                                    <h5 class="modal-title" id="exampleModalLabel"><img src="images/logo.png" style="max-height: 30px;" alt="" /></h5>
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
                    <h1 class="entry-title page-title"><?= $disco->disnome ?>(<?= $artista->artusual ?>)</h1>
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
                                    <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> &nbsp; <a href="?p=estilos&genero=<?= $genero['gencodigo'] ?>"><?= $genero['gennome'] ?></a> &nbsp; <?=substr($musica->mussobre,0,120) ?></h5>
                                    <h4 class="track-title"><?= $musica->musnome ?></h4><br/>
                                    <table width="100%" border="0">
                                        <tr>
                                            <td  width="90"> 
                                                <a href="?p=album&id=<?= $disco_musica->discodigo ?>" class=""><img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="90" alt="" /></a>
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
                                                        <small><img src="/images/icone/star.png" width="16"> Autores:</small>
                                                    </div>
                                                    <div class="col-lg-8"><small><?= $autores_format ?></small></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <small><img src="/images/icone/microphone.png" width="16"> Interpretes:</small>
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


                                    <div class="action-btns">
                                        <?php
                                         $livro = Disco::getLivro($disco_musica->discodigo);
                                          if (!$livro->livtipo){
                                              $livro->livtipo = 2;
                                          }
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

                                <?php
                            endforeach;
                        endif;
                        ?>

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
                        $noticias = new Noticia(null,"WHERE artcodigo = {$id_artista} ORDER BY notid DESC");
                        if ($noticias->getResult()):

                            foreach ($noticias->getResult() as $noticia):
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
                <hr>
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
                    <hr>
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
                <hr>
                <br> <br>
                     <?php include 'inc/dados-artista.php' ?>
            </aside><!-- /widget -->

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
