<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-9 columns" >
            <!--DISCOS -->
             
            <article class="post group">
                <?php
                $artista = new Artista($_GET['id']);
                $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                $artvinculo = $artista->artvinculo;

                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>
                 <?php
                $prefeitura = new Read();
                $prefeitura->ExeRead("prefeitura", "WHERE precodigo =  $artvinculo ");
                 foreach($prefeitura->getResult() as $prefeitura){
                    $prenome = $prefeitura['prenome'];
                 }
                ?> 
                <header class="entry-top special-top">
                    <h1 class="entry-title page-title"><img src="<?= $imgp ?>" width="120" />
                        &nbsp;A Arte de <a href="#"> <?= $artista->artusual ?></a> - Discografia.
                       <figure class="event-thumb">
                            <!--a href="<?= $imgp ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgp ?>" width="100" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a-->
                           <a href="?p=emissora&id=<?= $artvinculo?>"> <?= $prenome?></a>
                           
                       </figure>
                    </h1>
                </header>
                <?php
                $discos = $artista->getDiscos();
                ?>
                <?php
                if (!empty($discos)):
                    foreach ($discos as $disco):
                        ?>
                        <div class="large-3 columns sidebar sidebar-1">
                            <aside class="widget group" style="margin-bottom: -10px;">
                                <ol class="widget-list widget-list-single" >
                                    <li style="max-height: 250px; min-height: 250px; margin-bottom: 20px;">
                                        <figure class="event-thumb">
                                            <a href="?p=album&id=<?= $disco->discodigo ?>">
                                                <img src="admin/files/discos/<?= $disco->disimagem ?>" alt="" />
                                                <div class="overlay icon-info-sign"></div>
                                            </a>
                                        </figure>
                                        <span class="track-meta" datetime=""><?= DataCalendario::date2br($disco->disdata) ?></span>
                                        <h4 class="list-subtitle" style="margin-bottom: 5px; letter-spacing: 0.2px;">
                                            <a href="?p=album&id=<?= $disco->discodigo ?>"><?= $disco->disnome ?></a>
                                        </h4>
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
           
             <!--MUSICAS GRAVADAS -->
            <article class="post group" style="margin-top: -30px">
                <?php $musicas = $artista->getMusicas();
                ?>
                <div class="entry-content">
                    <h3><img src="images/piauicult.jpg" width="80" alt="" />Músicas gravadas (<?=$artista->artusual?>)&nbsp;<img src="<?= $imgp ?>" width="80" alt="" /></h3>
                    <ol class="tracklisting">
                        <?php
                        $disco_autor = [];
                        if (!empty($discos)):
                            foreach ($discos as $disco_musica):
                                $musicas = new MusicaDisco($disco_musica->discodigo);
                                $musicas = $musicas->getMusicas();
                                if ($musicas):
                                    foreach ($musicas as $musica):

                                        $partmusica = false;

                                        // interprestes
                                        $interpretes = Musica::getInterpretes($musica->muscodigo);
                                        $interpretes_format = [];
                                        foreach ($interpretes as $interprete):
                                            if ($interprete->artcodigo == $artista->artcodigo):
                                                $partmusica = true;
                                            endif;
                                            $interpretes_format[] = "<a href='?p=artist&id={$interprete->artcodigo}'>" . $interprete->artusual . "</a>";
                                        endforeach;
                                        $interpretes_format = implode(" , ", $interpretes_format);

                                        // autores
                                        $autores = Musica::getAutores($musica->muscodigo);
                                        $autores_format = [];
                                        $TAutor = null;
                                        foreach ($autores as $autor):
                                            $TAutor = !$TAutor ? $autor : $TAutor;
                                            if ($autor->artcodigo == $artista->artcodigo):
                                                $partmusica = true;
                                            endif;
                                            $autores_format[] = "<a href='?p=artist&id={$autor->artcodigo}'>" . $autor->artusual . "</a>";
                                        endforeach;
                                        $autores_format = implode(" , ", $autores_format);

                                        // aranjos
                                        $arranjos = Musica::getArranjos($musica->muscodigo);
                                        $arranjos_format = [];
                                        foreach ($arranjos as $arranjo):
                                            if ($arranjo->artcodigo == $artista->artcodigo):
                                                $partmusica = true;
                                            endif;
                                            $arranjos_format[] = "<a href='?p=artist&id={$arranjo->artcodigo}'>" . $arranjo->artusual . "</a>";
                                        endforeach;
                                        $arranjos_format = implode(" , ", $arranjos_format);

                                        // musicos
                                        $musicos = Musica::getMusicos($musica->muscodigo);
                                        $musicos_format = [];
                                        foreach ($musicos as $musico):
                                            if ($musico->artcodigo == $artista->artcodigo):
                                                $partmusica = true;
                                            endif;
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

                                        if (!$partmusica):
                                            continue;
                                        endif;

                                        if (!in_array($disco_musica->discodigo, $disco_autor)):
                                            $disco_autor[] = $disco_musica->discodigo;
                                        else:
                                            break;
                                        endif;

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
                                            <h5 class="track-meta">&nbsp;<?= $musica->musduracao ?> &nbsp; <a href="?p=estilos&genero=<?= $genero['gencodigo'] ?>"><?= $genero['gennome'] ?></a> 
                                                &nbsp; <?=substr($musica->mussobre,0,120) ?>
                                            </h5>
                                            <h4 class="track-title"><?= $musica->musnome ?></h4><br/>
                                            <table width="100%" border="0">
                                                <tr>
                                                   <td  width="100" width="100" style="margin-left: 50px; padding-right: -10px;"> 
                                                        <small><img src="/images/icone/music.png" width="16"> Disco</small>
                                                        <a href="?p=album&id=<?= $disco_musica->discodigo ?>" title="Ir para o DISCO:  <?=  $disco_musica->disnome ?> "class="">
                                                            <img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="90" alt="" />
                                                        </a>
                                                    </td>
                                                   <td  width="90"> 
                                                       <small><img src="/images/icone/star.png" width="16"> Autor</small>
                                                       <a href="?p=artist&id=<?= $TAutor->artcodigo ?>"  title="Ir para o AUTOR:  <?=  $TAutor->artusual ?> ">
                                                           <img src="admin/files/artistas/<?= $TAutor->artfoto ?>" width="90" alt="" /></a>
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
                                                if ($livro instanceof Livro) {
                                                    if (!$livro->livtipo) {
                                                        $livro->livtipo = 2;
                                                    }
                                                }
                                            if ($musica->livativo == "S" && $livro): ?>
                                               <a title="Veja o ENCARTE deste DISCO" href="livro.php?livcodigo=<?= $livro->livcodigo ?>" target="_blank"   onclick="Topo()" class="action-btn">
                                                <img src="/images/icone/book.fw.png" width="15">&nbsp;<?=@DadosFixos::TipoLivro($livro->livtipo)?>
                                               </a>&nbsp;
                                              <?php else: ?>
                                                <a  onclick="Topo()" class="action-btn" style="background-color:#CCC;">Cancioneiro/Encarte</a>
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
                                              <a data-rel="prettyPhoto"   onclick="Topo()"  style="background-color:#CCC;">
                                                  Letra
                                              </a>
                                             <?php endif; ?>
                                       
                                            </div>
                                            <div id="lyrics-1" class="track-lyrics-hold">
                                                <p><img src="admin/files/musicas/letra/<?= $musica->musletra ?>" width="auto"  alt="" /></p>
                                            </div>

                                        </li>

                                        <?php
                                    endforeach;
                                endif;

                            endforeach;
                        endif;
                        ?>

                    </ol>
                </div>

            </article>
            <aside class="widget group" style="margin-top: -30px">
                <ol class="tracklisting tracklisting-top">
                    <article class="post group">
                        <div class="entry-content">
                            <h3><img src="<?= $imgp ?>" width="100" />&nbsp;Vídeos de (<?=$artista->artusual?>)</h3>
                            <ol class="widget-list">
                                <?php
                                foreach ($artista->getVideos() as $video):
                                    $data = new DataCalendario($video->viddata);
//                                    $artista = new Artista($video->artcodigo);
                                   // $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                                    $foto = "admin/files/video/" . trim($video->vidfoto);

//                                    if (!file_exists($imgp) or ! is_file($imgp)):
//                                        $imgp = 'admin/files/images/user.png';
//                                    endif;
//                                    if (!file_exists($foto) or ! is_file($foto)):
//                                        $foto = 'admin/files/video/video.jpg';
//                                    endif;
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
            
            <article class="post group" style="margin-top: -80px">
                <?php  $discos = $artista->getDiscos();
                ?>
                <div class="entry-content">
                    <h3>Músicas gravadas (<?=$artista->artusual?>) no PIAUÍCult.&nbsp;<img src="<?= $imgp ?>" width="80" alt="" /></h3>
                    <ol class="tracklisting tracklisting-top">
                        <?php
                        if (!empty($discos)):
                            foreach ($discos as $disco_musica):
                                $musicas = new MusicaDisco($disco_musica->discodigo);
                                $musicas = $musicas->getMusicas();
                                if ($musicas):
                                    foreach ($musicas as $musica):
                                        $partmusica = false;
                                        $tipo_participacao = "";

                                        // interprestes
                                        $interpretes = Musica::getInterpretes($musica->muscodigo);
                                         foreach ($interpretes as $interprete):
                                            if ($interprete->artcodigo == $artista->artcodigo && $disco_musica->participaDisco($interprete->artcodigo) ){
                                                $tipo_participacao .= "<a href='?p=artistas&id=5' class='action-btn'>Interprete </a>&nbsp;";
                                                $partmusica = true;
                                                break;
                                            }
                                        endforeach;

                                        // autor
                                        $autors = Musica::getAutores($musica->muscodigo);
                                        foreach ($autors as $autor):
                                            if ($autor->artcodigo == $artista->artcodigo && $disco_musica->participaDisco($autor->artcodigo) ){
                                                $tipo_participacao .= " <a href='?p=artistas&id=1' class='action-btn'>Autor </a>&nbsp; ";
                                                $partmusica = true;
                                                break;
                                            }
                                        endforeach;

                                        // musicos
                                        $musicos = Musica::getMusicos($musica->muscodigo);
                                        foreach ($musicos as $musico):
                                            if ($musico->artcodigo == $artista->artcodigo && $disco_musica->participaDisco($musico->artcodigo) ){
                                                $tipo_participacao .= " <a href='?p=artistas&id=2' class='action-btn'>Músico </a> &nbsp;";
                                                $partmusica = true;
                                                break;
                                            }
                                        endforeach;

                                        // arranjos
                                        $arranjos = Musica::getArranjos($musica->muscodigo);
                                        foreach ($arranjos as $arranjo):
                                            if ($arranjo->artcodigo == $artista->artcodigo && $disco_musica->participaDisco($arranjo->artcodigo) ){
                                                $tipo_participacao .= " <a href='?p=artistas&id=3' class='action-btn'>Arranjo </a>&nbsp; ";
                                                $partmusica = true;
                                                break;
                                            }
                                        endforeach;


                                        if(!$partmusica)continue;

                                            // autores
                                        $autores = Musica::getAutores($musica->muscodigo);
                                        $autores_format = [];
                                        foreach ($autores as $autor):
                                            if ($autor->artcodigo == $artista->artcodigo):
                                                $partmusica = true;
                                            endif;
                                            $autores_format[] = "<a href='?p=artist&id={$autor->artcodigo}'>" . $autor->artusual . "</a>";
                                        endforeach;
                                        $autores_format = implode(" , ", $autores_format);


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

                                        <li class="" style="max-height: 75px !important;">
                                            <h4 class="track-meta"><span style="padding-left: 50px;"><?=$tipo_participacao?></span></h4>
                                            <h4 class="track-meta"><a title=" Disco:&nbsp;<?= $disco_musica->disnome ?>" href="?p=album&id=<?= $disco_musica->discodigo ?>" class=""><img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="50" alt="" />|&nbsp; &nbsp;<?= $disco_musica->disnome ?> </a>&nbsp; |&nbsp;Música:&nbsp;<em style="color:#000;"> <?= $musica->musnome ?></em> &nbsp;|Autor: &nbsp;<?= $autores_format ?> &nbsp;&nbsp; <h5>

                                        </li>

                                        <?php
                                    endforeach;
                                endif;

                            endforeach;
                        endif;
                        ?>

                    </ol>
                    <h3>Biografia de (<?=$artista->artusual?>).&nbsp;<img src="<?= $imgp ?>" width="80" alt="" /></h3>
                    <p>
                        <?= $artista->artbiografia ?>
                    </p>
                </div>

            </article>

        </div>
        <div class="large-3 columns sidebar sidebar-1">
            <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgp ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgp ?>" />
                                <div class="overlay icon-zoom-in"></div>								
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
                </ol>
            </aside><!-- /widget -->
            <aside class="widget group">
               <h3 class="widget-title">Redes Sociais</h3>
                 <ol class="widget-list widget-list-single">
                   <img src="<?= $imgp ?>" alt="artista"  />
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
         
            <?php
            $bandas = $artista->getBandas();
            if ($bandas) {
            ?>
               <aside class="widget group">
                    <h3 class="widget-title">Grupos Culturais</h3>(participante)
                <ol class="tracklisting tracklisting-top">
                    <?php foreach ($bandas as $banda) {
                        $imgp = "admin/files/bandas/" . trim($banda->banfoto1);

                        if (!file_exists($imgp) or ! is_file($imgp)):
                            $imgp = 'admin/files/imagem/user.png';
                        endif;
                        ?>
                    
                        <li class="group track">
                            <a href="?p=banda&id=<?= $banda->bancodigo ?>" class="">
                                <table width="100%" border="0">
                                    <tr>
                                        <td  width="65" align="left">
                                            <img src="<?= $imgp ?>" width="50" style="max-height: 50px;" alt="" />
                                        </td>
                                        <td align="left">
                                            <h5 class="track-title"><?= $banda->bannome ?></h5>
                                        </td>

                                    </tr>
                                </table>
                            </a>
                        </li>
                    <?php }?>
                </ol>
            </aside><!-- /widget --->

            <?php } ?>
            <!--** livros-->
            <?php //include 'inc/livro.php' ?>
            <!-- /livros -->
             <aside class="widget group">
                  <h3 class="widget-title">Galeria: Fotos & Imagens</h3>
                <ol class="widget-list widget-list-single">
                    <?php 
                        $gal = new Read();
                        $gal->ExeRead("galeria", "WHERE galartista = :id limit 1", "id=".$_GET['id']);
                        
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
           
              <?php include 'inc/dados-artista.php' ?>
          

            <!-- ** instrumento-->
            <?php include 'inc/instrumento.php' ?>
            <section class="events-section events-upcoming">
                <h3>Eventos</h3>
                <ol class="widget-list">
                    <?php
                    $eventos = new Evento(NULL,"WHERE artcodigo = {$artista->artcodigo} ORDER BY evedata DESC");
                    if ($eventos->getResult()):

                        foreach ($eventos->getResult() as $evento):
                            $evento = new Evento($evento['evecodigo']);
                            $data = $evento->evedata;
                            $data = new DataCalendario($data);
                            $imgp = "admin/files/eventos/" . trim($evento->eveimagem1);
                            if (!file_exists($imgp) or ! is_file($imgp)):
                                $imgp = 'admin/files/imagem/user.png';
                            endif;
                            ?>
                            <li>
                                <table>
                                    <tr>
                                        <td style="width: 30%; margin-right: 5px;">
                                            <a href="?p=event&id=<?= $evento->evecodigo ?>">
                                                <figure class="entry-thumb" style="text-align:center;">
                                                    <img src="<?= $imgp ?>" alt="" />
                                                </figure>
                                            </a>
                                        </td>
                                        <td>
                                            <time class="list-subtitle" ><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                            <h5 class="list-title"><a href="?p=event&id=<?= $evento->evecodigo ?>"><?= $evento->evenome ?></a></h5>
                                            <a href="?p=event&id=<?= $evento->evecodigo ?>" class="action-btn">Mais detalhes ...</a>
                                        </td>
                                    </tr>
                                </table>

                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ol>
            </section>
            <br>
            <section class="events-section events-upcoming">
                <h3>Notícias</h3>
                <ol class="widget-list">
                    <?php
                    $noticias = new Noticia(null,"WHERE artcodigo = {$artista->artcodigo} ORDER BY notid DESC");
                    if ($noticias->getResult()):

                        foreach ($noticias->getResult() as $noticia):
                            $noticia = new Noticia($noticia['notid']);
                            $data = DataCalendario::date2us($noticia->notdata);
                            $data = new DataCalendario($data);
                            $imgp = "admin/files/noticias/" . trim($noticia->notfoto);
                            if (!file_exists($imgp) or ! is_file($imgp)):
                                $imgp = 'admin/files/imagem/user.png';
                            endif;
                            ?>
                            <li>
                                <table>
                                    <tr>
                                        <td style="width: 25%; margin-right: 5px;">
                                            <a href="?p=single&id=<?= $noticia->notid ?>">
                                                <figure class="entry-thumb" style="text-align:center;">
                                                    <img src="<?= $imgp ?>" alt="" />
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
                </ol>
            </section>

        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    function BuscaID(str,id) {
      var pos1 = str.search("users/");
      var pos2 = str.search("&amp;");
      var codigo = str.substring(pos1+6,pos2)
      $("#"+id).val(codigo)
    }
</script>