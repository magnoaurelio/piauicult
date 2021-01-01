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
<br/>    
<div id="main-wrap" style="margin-top: -20px">
    <div id="main" class="row">
        
         <div class="large-12 columns">
            <article class="post group">   
                <header class="entry-top special-top"> 
                    
                    <div class="large-3 columns" >
                        
                    <select class="form-control selecao">
                        <option value="0">Selecione um Gênero Musical</option>
                        <?php
                          
                            class Total{
                                private $valor;
                                public function __construct()
                                {
                                    $this->valor = 0;
                                }
                                 function soma($valor){
                                    $this->valor += $valor;
                                    return $valor;
                                }
                                 function getValor(){
                                    return $this->valor;
                                }
                            }

                        $total = new Total();
                      //  $generos = new Read();
                      //  $generos->ExeRead("genero", "ORDER BY gennome ASC" );
                        $generos = new Genero(null, "ORDER BY gennome ASC");
                        $generoCodigos = [];
                        foreach ($generos->getResult() as $genero) {
                            $generoCodigos[] = $genero['gencodigo'];
                            $selected = isset($_GET['id']) && $_GET['id'] == $genero['gencodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$genero['gencodigo']}>{$genero['gennome']}-{$genero['gencodigo']}</option>";
                        }
                        ?>
                    </select>
                  </div>
                  <h1 class="entry-title page-title">
                      <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                      <a href="?p=artista-genero&ID=<?= $genero->gencodigo ?>">
                          Musicas & Generos 
                      </a>
                  </h1>
                </header>   
            </article>
         </div>
             <div class="large-12 columns" >
                    <article class="post group" style="width: 100%; padding: 0px 20px 20px 20px; margin-top:0px; ">
                        <div>
                            <?php
                             $id = isset($_GET['id']) ? $_GET['id'] : array_rand($generoCodigos, 1);
                             $genero = new Genero($id);
                             
                            $imgins = "admin/files/instrumento/" . trim($genero->geninstrumento);
                            if (!file_exists($imgins) or ! is_file($imgins)):
                                $imgins = 'admin/files/imagem/instrumento.png';
                            endif;
                            
                            ?>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <div class="col-lg-12 cabeca">
                                   
                                    <header class="entry-top special-top">
                                        <h1 class="entry-title page-title">Sobre:&nbsp;&nbsp; <a href="#">
                                            <?=strtoupper($genero->gennome)?> 
                                            </a>
                                            &nbsp;<i style="font-size:20px;">Instrumentos:</i>&nbsp;&nbsp; 
                                            <a href="?p=genero_instrumento&gencodigo=<?= $genero->gencodigo ?>" title="Aprenda mais sobre o instrumento: <?= $genero->gennome ?> "> 
                                               <?php 
                                                if (!file_exists($imgins) or ! is_file($imgins)):
                                                    $imgins = 'admin/files/imagem/instrumento.png';
                                                else:
                                               ?>  
                                                <img src="<?= $imgins ?>" width="90px" height="90"  alt="instrumento" /> 
                                                <?php 
                                                endif;
                                               ?> 
                                            </a>
                                            &nbsp;<i style="font-size:20px;">Nomes:</i>&nbsp;&nbsp; 
                                            <?php
                                                    $artcodigo = $genero->artcodigo;
                                                    if($artcodigo === null):
                                                     ?> 
                                                    <img src="admin/files/imagem/ARTISTA_ARTISTA.jpg" width="90px" height="90"  alt="artista" />
                                                    <?php    
                                                    else:
                                                     
                                                    $artista = new Artista(null, "WHERE artcodigo = $artcodigo ORDER BY artcodigo ASC");
                                                    foreach ($artista->getResult() as $artista) {
                                                        $artfoto = $artista['artfoto'];
                                                        $artnome = $artista['artnome'];
                                                        $artusual = $artista['artusual'];


                                                   $imgart = "admin/files/artistas/" .trim($artista['artfoto']);
                                                   if (!file_exists($imgart) or ! is_file($imgart)):
                                                       $imgart = 'admin/files/imagem/artista.png';
                                                   endif;
                                                   
                                                   ?> 
                                            
                                             <a href="?p=genero_artista&gencodigo=<?= $genero->gencodigo ?>" title=" Artista: <?=$artusual ?>">
                                              <img src="<?= $imgart ?>" width="90px" height="90"  alt="artista" /> <br>
                                           </a>
                                            <?php   }
                                            endif;
                                            ?> 
                                        </h1>
                                         <?= substr($genero->genorigem,0,400)?> ...<a href="?p=genero_artista&gencodigo=<?= $genero->gencodigo ?>">Aprenda mais</a>
                                        <h1 class="entry-title page-title">Músicas do gênero:&nbsp;&nbsp;<a href="?p=genero_artista&gencodigo=<?= $genero->gencodigo ?>">
                                            <?=strtoupper($genero->gennome)?> 
                                            </a>
                                        </h1>
                                        
                                         
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
                                            $musicas = new Read;
                                            $musicas->ExeRead("musica", "WHERE  SUBSTRING(musnome,1,1) = :letra and gencodigo = :cod  ORDER BY musnome", "letra={$letra
                                                    }&cod={$genero->gencodigo}");
                                            if ($musicas->getResult()):
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

                                                    // aranjos
                                                    $musicos = Musica::getMusicos($musica->muscodigo);
                                                    $musicos_format = [];
                                                    foreach ($musicos as $musico):
                                                        $musicos_format[] = "<a href='?p=artist&id={$musico->artcodigo
                                                                }'>" . $musico->artusual . "</a>";
                                                    endforeach;
                                                    $musicos_format = implode(" , ", $musicos_format);

                                                    $audio = "admin/files/musicas/audio/{$musica->musaudio
                                                            }";

                                                    if (!file_exists($audio) or ! is_file($audio)):
                                                        $audio = "#";
                                                    endif;
                                                    ?>

                                                    <li class="group track">
                                                        <?php if ($musica->musativo == "S"): ?>
                                                            <a href="<?= $audio ?>" id="<?= $musica->muscodigo ?>"  class="media-btn">Play</a>
                                                        <?php else: ?>
                                                            <a class="media-btn" style="background-color:#CCC;">Play</a>
                                                        <?php endif; ?>
                                                        <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> &nbsp; <?= $genero->gennome ?></h5>
                                                        <h4 class="track-title"><?= $musica->musnome ?></h4><br/>
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td  width="65">
                                                                    <a href="?p=album&id=<?= $disco_musica->discodigo ?>" class="" title="<?= @$disco_musica->disnome ?>"><img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="80" alt="" /></a>
                                                                </td>
                                                                <td width="70" align="right">
                                                                    <small>Autor</small><br/>
                                                                    <small>Interpretes</small><br/>
                                                                    <small>Arranjos  </small><br/>
                                                                    <small>Músicos  </small>
                                                                </td>
                                                                <td style=" text-wrap:suppress;" >
                                                                    <?= $autores_format ?> &nbsp;&nbsp; <br/>
                                                                    <?= $interpretes_format ?><br/>
                                                                    <?= $arranjos_format ?><br/>
                                                                    <?= $musicos_format ?>
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
        <!-- /large-12 -->
    </div>
    <!-- /main -->
</div>
<!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=artista-genero";
        } else {
            top.location.href = "?p=artista-genero&id=" + this.value;
        }
    });
</script>