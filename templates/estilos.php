<?php
$gen  =  new Read;
$genero = [];
$genero['gencodigo'] = NULL;
$genero['gennome'] = "Indefinido";

@$gen->ExeRead('genero',"WHERE gencodigo = :c","c=".$_GET['genero']);

if($gen->getRowCount()>0)
   $genero = $gen->getResult()[0];
   $imgp = "admin/files/instrumento/" . trim($genero['geninstrumento']);
    if (!file_exists($imgp) or ! is_file($imgp)):
        $imgp = 'admin/files/imagem/instrumento.jpg';
    endif;
?>
<div id="main-wrap" >
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

                <div class="large-12 columns" >
                    <article class="post group" style="width: 100%; padding: 0px 20px 20px 20px; margin-top:0px; ">
                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <div class="col-lg-12 cabeca">
                                    <header class="entry-top special-top">
                                        <h1 class="entry-title page-title">Músicas do gênero<a href="?p=instrumentistas&id=<?= $genero['gencodigo'] ?>"> <?=strtoupper($genero['gennome'])?> 
                                         &nbsp;&nbsp;  <img src="<?= $imgp ?>" width="80" height="80"  alt="instrumento" /></a>
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
                                                    }&cod={$genero['gencodigo']}");
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
                                                        <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> &nbsp; <?= $genero['gennome'] ?></h5>
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
            top.location.href = "?p=artistas";
        } else {
            top.location.href = "?p=artista&id=" + this.value;
        }
    });
</script>