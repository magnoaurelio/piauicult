
<div id="main-wrap" style="margin-top: -10px">
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
                                        <h1 class="entry-title page-title"><a href="#">Músicas de A - Z</a></h1> 
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
                                            //disco
                                        //   $musica_disco = new MusicaDisco(null, $musica->muscodigo);
                                        //     $disco_musica = $musica_disco->getDisco();
                                            // musicas
                                            $musicas = new Read;
                                            $musicas->ExeRead("musica", "WHERE  SUBSTRING(musnome,1,1) = :letra  ORDER BY musnome", "letra={$letra}");                                           if ($musicas->getResult()):
                                                foreach ($musicas->getResult() as $musica):
                                                    $musica = new Musica($musica['muscodigo']);
                                                    $musica_disco = new MusicaDisco(null, $musica->muscodigo);
                                                    $disco_musica = $musica_disco->getDisco();

                                                    // interprestes
                                                    $interpretes = Musica::getInterpretes($musica->muscodigo);
                                                    $interpretes_format = [];
                                                    foreach ($interpretes as $interprete):
                                                        $interpretes_format[] = "<a href='?p=artist&id={$interprete->artcodigo
                                                                }'>" . $interprete->artusual . "</a>";
                                                    endforeach;
                                                    $interpretes_format = implode(" , ", $interpretes_format);

                                                    // autores
                                                    $autores = Musica::getAutores($musica->muscodigo);
                                                    $autores_format = [];
                                                    foreach ($autores as $autor):
                                                        $autores_format[] = "<a href='?p=artist&id={$autor->artcodigo
                                                                }'>" . $autor->artusual . "</a>";
                                                    endforeach;
                                                    $autores_format = implode(" , ", $autores_format);

                                                    // aranjos
                                                    $arranjos = Musica::getArranjos($musica->muscodigo);
                                                    $arranjos_format = [];
                                                    foreach ($arranjos as $arranjo):
                                                        $arranjos_format[] = "<a href='?p=artist&id={$arranjo->artcodigo
                                                                }'>" . $arranjo->artusual . "</a>";
                                                    endforeach;
                                                    $arranjos_format = implode(" , ", $arranjos_format);

                                                    // musicos
                                                    $musicos = Musica::getMusicos($musica->muscodigo);
                                                    $musicos_format = [];
                                                    foreach ($musicos as $musico):
                                                        $musicos_format[] = "<a href='?p=artist&id={$musico->artcodigo
                                                                }'>" . $musico->artusual . "</a>";
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

                                                    $audio = "admin/files/musicas/audio/{$musica->musaudio
                                                            }";

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
                                                            <a href="<?= $audio ?>" id="<?= $musica->muscodigo ?>"  class="media-btn">Play</a>
                                                        <?php else: ?>
                                                            <a class="media-btn" style="background-color:#CCC;">Play</a>
                                                        <?php endif; ?>
                                                        <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?>&nbsp; <a href="?p=estilos&genero=<?= $genero['gencodigo'] ?>"><?= $genero['gennome'] ?></a></h5>
                                                        <h4 class="track-title"><?= $musica->musnome ?></h4><br/>
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                
                                                                <td  width="100" width="100" style="margin-left: 50px; padding-right: -10px;"> 
                                                                    <small><img src="/images/icone/music.png" width="16"> Disco</small>
                                                                    <a href="?p=album&id=<?= $disco_musica->discodigo ?>" title="Ir para o DISCO:  <?=$disco_musica->disnome ?> "class=""><img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="90" alt="" /></a>
                                                                </td>
                                                                <td  width="90">  
                                                                   <small><img src="/images/icone/star.png" width="16"> Autor</small>
                                                                   <a href="?p=artist&id=<?= $autor->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $autor->artusual ?> "><img src="admin/files/artistas/<?= $autor->artfoto ?>" width="90" alt="" /></a>
                                                                </td>
                                                                <td  width="90"> 
                                                                    <small><img src="/images/icone/microfone.png" width="16"> Interprete</small>
                                                                    <a href="?p=artist&id=<?= $interprete->artcodigo ?>"  title="Ir para o INTÉRPRETE:  <?=  $interprete->artusual ?> "><img src="admin/files/artistas/<?= $interprete->artfoto  ?>" width="90" alt="" /></a>
                                                                </td>
                                                                <!--td  width="90">  <small><img src="/images/icone/lightbulb.png" width="16"> Produtor</small>
                                                                    <a href="?p=artist&id=<?= $produtor->artcodigo ?>"  title="Ir para o PRODUTOR:  <?=  $produtor->artusual ?> "><img src="admin/files/artistas/<?= $produtor->artfoto ?>" width="90" alt="" /></a>
                                                               </td>
                                                               <td  width="90"> 
                                                                    <small><img src="/images/icone/write.png" width="16"> Arte</small>
                                                                    <a href="?p=artist&id=<?= $arte->artcodigo ?>"  title="Ir para o DESING GRÁFICO:  <?=  $arte->artusual ?> "><img src="admin/files/artistas/<?= $arte->artfoto  ?>" width="90" alt="" /></a>
                                                               </td-->
                                           
                                                                
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
                                                                       <small><img src="/images/icone/music.png" width="16"> Disco</small>
                                                                       <a href="?p=album&id=<?= $disco_musica->discodigo ?>" title="Ir para o DISCO:  <?=$disco_musica->disnome ?> "class=""><strong><?=$disco_musica->disnome ?></strong> </a>
                                                                     </div>
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <small><img src="/images/icone/star.png" width="16"> Autor(es):</small>
                                                                        </div>
                                                                        <div class="col-lg-8" style="margin-left:20px;"><small><?= $autores_format ?></small></div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <small><img src="/images/icone/microphone.png" width="16"> Interprete(s):</small>
                                                                        </div>
                                                                        <div class="col-lg-8" style="margin-left:20px;"><small><?= $interpretes_format ?></small></div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <small><img src="/images/icone/music.png" width="16"> Arranjos:</small>
                                                                        </div>
                                                                        <div class="col-lg-8" style="margin-left:20px;"><small><?= $arranjos_format ?></small></div>
                                                                    </div>

                                                                   <div class="row">
                                                                       <div class="col-lg-4">
                                                                            <small><img src="/images/icone/star.png" width="16"> Músicos:</small> & <small><img src="/images/icone/guitar.png" width="16"> Instrumentos:</small>
                                                                        </div>
                                                                        <!--div class="col-lg-8"><small><?= $musicos_format ?></small></div-->
                                                                        <div class="col-lg-8" style="margin-left:20px;"><small><?= $instrumentos_format ?></small></div>
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
                                                                        <div class="col-lg-8" style="margin-left:20px;"><small><?= $produtores_format ?></small></div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            <small><img src="/images/icone/write.png" width="16"> Artes:</small>
                                                                        </div>
                                                                        <div class="col-lg-8" style="margin-left:20px;"><small><?= $artes_format ?></small></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <div class="action-btns">
                                                            <?php if ($musica->musvideo != ""): ?>
                                                               <a href="<?= $musica->musvideo ?>" data-rel="prettyPhoto"   onclick="Topo()" class="action-btn">Vídeo</a>
                                                            <?php else: ?>
                                                                 <a style="background-color:#CCC;" class="action-btn">Vídeo</a>
                                                            <?php endif; ?>
                                                           
                                                            <a href="admin/files/musicas/letra/<?= $musica->musletra ?>"  onclick="Topo()" data-rel="prettyPhoto" class="action-btn">Letra</a>
                                                        </div>
                                                        <div id="lyrics-1" class="track-lyrics-hold">
                                                            <p><img src="admin/files/musicas/letra/<?= $musica->musletra ?>" width="auto"  alt="" /></p>
                                                        </div>

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
            top.location.href = "?p=disco";
        } else {
            top.location.href = "?p=disco&id=" + this.value;
        }
    });
</script>