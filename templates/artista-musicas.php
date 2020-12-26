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
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        
        <div class="large-12 columns">
            <article class="post group">   
                <header class="entry-top special-top"> 
                    
                    <div class="large-3 columns" style="margin-top:3px;">
                        
                    <select class="form-control selecao">
                        <option value="0">Selecione um Artista</option>
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
                        $artistas = new Artista(null, "ORDER BY artusual ASC");
                        $artistaCodigos = [];
                        foreach ($artistas->getResult() as $artista) {
                            $artistaCodigos[] = $artista['artcodigo'];
                            $selected = isset($_GET['id']) && $_GET['id'] == $artista['artcodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$artista['artcodigo']}>{$artista['artusual']}</option>";
                        }
                        ?>
                    </select>
                  </div>
                  <h1 class="entry-title page-title" style="margin-top:-5px;"><img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                      <a href="?p=artist&id=<?= $artista->artcodigo ?>"> Artista & Musicas

                      </a>
                  </h1>
                </header>   
            </article>
            </div>

            <article class="post group" style="margin-top:-30px;">
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : array_rand($artistaCodigos, 1);
                $artista = new Artista($id);

                $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                if (!file_exists($imgp) or ! is_file($imgp)): $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>
                <?php $discos = $artista->getDiscos(); ?>

                <div class="artistas-container row"  style="margin-top: 5px;">
                    <div class="large-2 columns">
                        <aside class="widget group" style="width: 190px; height:190px; margin-top:5px;">
                            <figure class="event-thumb" style="margin: 0px">
                                <a href="?p=artist&id=<?= $artista->artcodigo ?>">
                                    <img src="<?= $imgp ?>" alt="" />
                                    <div class="overlay icon-info-sign"></div>
                                </a>
                            </figure>
                            <a href="?p=artist&id=<?= $artista->artcodigo ?>" class="action-btn"><?= $artista->artusual ?></a>
                        </aside>
                            <img src="images/estrela.png" width="20" height="20" alt="estrela" /> &nbsp;Artistas: <strong> <?=$total->soma((new Artista())->getRowCount())?></strong>  <br/>
                            <img src="images/play.png" width="20" height="20" alt="disco" /> &nbsp;Discos: &nbsp;<strong>  <?=$total->soma((new Disco())->getRowCount())?></strong> <br/>
                            <img src="images/nota.png" width="20" height="20" alt="musica" /> &nbsp;Musicas: <strong> <?=$total->soma((new Musica())->getRowCount())?></strong>

                    </div>
                    <div class="large-10 columns" style="margin-top: 5px;">
                        <div class="entry-content">
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
                                               <div>
                                                <li class="" style="max-height: 100px ">
                                                    <h4 class="track-meta"><span style="padding-left: 50px;"><?=$tipo_participacao?></span></h4>
                                                    <h5 class="track-meta"><a title=" Disco:&nbsp;<?= $disco_musica->disnome ?>" href="?p=album&id=<?= $disco_musica->discodigo ?>" class=""><img src="admin/files/discos/<?= $disco_musica->disimagem ?>" width="50" alt="" />|&nbsp;<?= $disco_musica->disnome ?> </a>
                                                        &nbsp;<img src="/images/icone/music.png" width="15">&nbsp;Música:&nbsp;<em style="color:#000;"> <?= $musica->musnome ?></em>
                                                        &nbsp;<img src="/images/icone/star.png" width="15"> &nbsp;Autor: &nbsp;<?= $autores_format ?> 
                                                        &nbsp;<img src="/images/icone/microphone.png" width="15"> &nbsp;Intérprete: &nbsp;<?= $interpretes_format ?>
                                                    </h5>

                                                </li>
                                             </div> 
                                            <?php
                                            endforeach;
                                        endif;

                                    endforeach;
                                endif;
                                ?>

                            </ol>
                        </div>
                    </div>
                </div>

            </article>
        <!-- /large-12 -->
    </div>
    <!-- /main -->
</div>
<!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=artista-musicas";
        } else {
            top.location.href = "?p=artista-musicas&id=" + this.value;
        }
    });
</script>