
<br/>    
<div id="main-wrap" style="margin-top: -10px">
     <div id="main" class="row">
         <div class="large-12 columns">
              <article class="post group">   
                <header class="entry-top special-top"> 
                    <div class="large-3 columns" style="margin-top:3px;">  
                          <select class="form-control selecao">
                              <option value="0" >Selecione todos os artistas</option>
                              <?php
                              $artistas = new Artista(null, "ORDER BY artusual ASC");
                              foreach ($artistas->getResult() as $artista) {
                                  $selected = isset($_GET['id']) && $_GET['id'] == $artista['artcodigo'] ? 'selected=selected' : "";
                                  echo "<option {$selected} value={$artista['artcodigo']}>{$artista['artusual']}</option>";
                              }
                              ?>
                          </select>
                      </div>
                    <h1 class="entry-title page-title" style="margin-top:5px;">
                         <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                         <a href="?p=artist&id=<?= $artista->artcodigo ?>"><a href="#">Vídeos & Artistas</a></a>
                     </h1>
            
             </header>   
            </article>
            </div>
   
            <article class="post group" style="margin-top:-30px;">
            <ul class="list row">
                <?php
                $musicas_all = new Musica();
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $musicas = $musicas_all->getResult();
                if ($musicas):
                    foreach ($musicas as $musica):
                        if (empty($musica['musvideo'])):
                            continue;
                        endif;
                        $musica = new Musica($musica['muscodigo']);
                        $encontrou =  false;
                        $data = $musica->musdata;
                       // var_dump($data);
                        if (empty($data)):
                            $data = date("Y-m-d");
                        endif;
                        $data = new DataCalendario($data);
                       
                        //disco
                        $musica_disco = new MusicaDisco(null, $musica->muscodigo);
                        $disco_musica = $musica_disco->getDisco();

                        // interprestes
                        $interpretes = Musica::getInterpretes($musica->muscodigo);
                        $interpretes_format = [];
                        foreach ($interpretes as $interprete):
                            if($interprete->artcodigo == $id) $encontrou = true;
                            $interpretes_format[] = "<a href='?p=artist&id={$interprete->artcodigo}'>" . $interprete->artusual . "</a>";
                        endforeach;
                        $interpretes_format = implode(" , ", $interpretes_format);

                        // autores
                        $autores = Musica::getAutores($musica->muscodigo);
                        $autores_format = [];
                        foreach ($autores as $autor):
                            if($autor->artcodigo == $id) $encontrou = true;
                            $autores_format[] = "<a href='?p=artist&id={$autor->artcodigo}'>" . $autor->artusual . "</a>";
                        endforeach;
                        $autores_format = implode(" , ", $autores_format);

                        if(!$encontrou && $id != null){
                            continue;
                        }

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
                        ?>
                        <li class="large-3 columns" style="margin-top:10px;">
                            <div class="li-content" style="height: 300px;">
                                <figure class="event-thumb">
                                    <a href="<?= $musica->musvideo ?>" data-rel="prettyPhoto">
                                        <img style="min-height: 180px; max-height: 180px; width: 100%;" src="admin/files/discos/<?= $disco_musica->disimagem ?>" alt="" />
                                        <div class="overlay icon-play-sign"></div>
                                    </a>							
                                </figure>
                                <time class="list-subtitle" ><?= $data->getDia() ?> - <?= substr($data->getMes(), 0, 3) ?> - <?= $data->getAno() ?></time>
                                <table width="100%" border="0" style="font-size:12px;">
                                    <tr>
                                        <td colspan="2" align="center" ><strong><a><?= $musica->musnome ?></a></strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>Autor</small><br/>
                                            <small>Interpretes</small><br/>
                                        </td>
                                        <td width="80%" >
                                            <?= $autores_format ?> &nbsp;&nbsp; <br/>
                                            <?= $interpretes_format ?><br/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </li>
                        <?php
                    endforeach;
                endif;
                ?>

            </ul>

<!--			
<div id="paging">
    <a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><span class="current">5</span><a href="#">6</a>
</div> /paging -->

     
        </article>
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    $('.selecao').change(function(e) {
        if (this.value == 0) {
            top.location.href = "?p=videos";
        } else {
            top.location.href = "?p=videos&id=" + this.value;
        }
    });
</script>