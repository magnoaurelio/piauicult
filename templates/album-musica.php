
<div id="section" style="background:url(images/header.jpg) no-repeat top center">
        <div class="row">
                <div class="large-12 columns">
                        <h3>Discos & Músicas com Detalhes</h3>
                </div> 
        </div> <!--/row -->
</div> <!--/section -->

<?php

$disco = new Disco($_GET['id']);
$musica = new Musica($_GET['muscodigo']);
$id_artista = explode(';', $disco->artcodigo);
$id_artista = $id_artista[0];
$imgp = "admin/files/discos/" . trim($disco->disimagem);
if (!file_exists($imgp) or ! is_file($imgp)):
    $imgp = 'admin/files/imagem/disco.png';
endif;
 // autores
$artista = $disco->getParticipantes()[0];

?>

<div id="main-wrap" style="padding-top: 0px">
    <div id="main" class="row">
        
        
            <article class="post group">
               <div class="large-3 columns"> 
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="?p=album&id=<?= $disco->discodigo ?>" title="Voltar para o DISCO: <?= $disco->disnome ?>">
                                <img src="<?= $imgp ?>" /> <?= $disco->disnome ?>(<?= $artista->artusual ?>)
                                <!--div class="overlay icon-zoom-in"></div-->								
                            </a>
                        </figure>
                        <h5 class="list-subtitle">Clique &nbsp; para  &nbsp;  ampliar</h5>
                    </li>
                </ol>
               </div>
                 <div class="large-12 columns">
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
                                $autores_format  = implode(" , ", $autores_format);
                               

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
                                    <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> &nbsp; 
                                        <a href="?p=estilos&genero=<?= $genero['gencodigo'] ?>"><?= $genero['gennome'] ?></a> 
                                        &nbsp; <?=substr($musica->mussobre,0,120) ?>
                                    </h5>
                                    <h4 class="track-title">
                                            <?= $musica->musnome ?>
                                    </h4><br/>
                                 
                                    <table width="100%" border="0">
                                        <small style="font-size: 20px;">
                                              <img src="/images/icone/star.png" width="20"> 
                                               Autor(es):
                                          </small>
                                           <td  width="150">
                                                  <div class="col-lg-8" style="font-size: 20px;"><small><?= $autores_format ?></small></div> 
                                                <a href="?p=artist&id=<?= $autor->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> ">
                                                    <img src="admin/files/artistas/<?= $autor->artfoto ?>" width="150" alt="" />
                                                </a>
                                             
                                            </td>
                                            <!--
                                           <td  width="90">
                                                <a href="?p=artist&id=<?= $autor->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> "><img src="admin/files/artistas/<?= $autor->artfoto ?>" width="90" alt="" /></a>
                                                <div class="col-lg-8"><small><?= $autores_format ?></small></div> 
                                            </td>
                                           <td  width="90">
                                                <a href="?p=artist&id=<?= $autor->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> "><img src="admin/files/artistas/<?= $autor->artfoto ?>" width="90" alt="" /></a>
                                                <div class="col-lg-8"><small><?= $autores_format ?></small></div> 
                                            </td>
                                            -->
                                     </table>
                                    <table width="100%" border="0">
                                          <small style="font-size: 20px;">
                                              <img src="/images/icone/microfone.png" width="20"> 
                                              Interprete(s):
                                          </small>
                                              <td  width="150">
                                                      <div class="col-lg-8" style="font-size: 20px;"><small><?= $interpretes_format ?></small></div>
                                                <a href="?p=artist&id=<?= $interprete->artcodigo ?>"  title="Ir para o INTÉRPRETE:  <?=  $interprete->artusual ?> ">
                                                    <img src="admin/files/artistas/<?= $interprete->artfoto  ?>" width="150" alt="" />
                                                </a>
                                            </td>
                                      </table>
                                    <table width="100%" border="0">
                                          
                                            <td style="padding-left: 20px; padding-right: 10px;" >

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <small style="font-size: 20px;">
                                                            <img src="/images/icone/music.png" width="20"> 
                                                            Arranjos:
                                                        </small>
                                                    </div>
                                                    <div class="col-lg-8" style="font-size: 20px;"><small><?= $arranjos_format ?></small></div>
                                                     <a href="?p=artist&id=<?= $arranjo->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> ">
                                                    <img src="admin/files/artistas/<?= $arranjo->artfoto ?>" width="150" alt="" />
                                                    </a>
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <small style="font-size: 20px;">
                                                            <img src="/images/icone/star.png" width="20"> 
                                                            Músicos:
                                                        </small> 
                                                            & 
                                                        <small style="font-size: 20px;">
                                                            <img src="/images/icone/guitar.png" width="20"> 
                                                            Instrumentos:
                                                        </small>
                                                    </div>
                                                    <!--div class="col-lg-8"><small><?= $musicos_format ?></small></div-->
                                                    <div class="col-lg-8" style="font-size: 20px;"><small><?= $instrumentos_format ?></small></div>
                                                     <a href="?p=artist&id=<?= $musico->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> ">
                                                    <img src="admin/files/artistas/<?= $musico->artfoto ?>" width="150" alt="" />
                                                     </a>
                                                     <a href="?p=instrumentistas&id=<?= $instrumento["inscodigo"] ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> ">
                                                    <img src="admin/files/instrumento/<?= $instrumento["insfoto"] ?>" width="150" alt="" />
                                                    </a>
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
                                            <a  onclick="Topo()" class="action-btn" style="background-color:#CCC;"><i class="fa fa-book"></i> Cancioneiro/Encarte</a>
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
                                               <img src="/images/icone/letra.fw.png" width="15">&nbsp;Letra
                                           </a>&nbsp;
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
             </ol>

                </div>

            </article><!-- /post -->

             
        </div>

    </div><!-- /main -->
</div><!-- /main-wrap -->
