 <style>
    hr{
        border:1px solid #DDD;
        opacity: 0.5;
    }
</style>
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns">
            <section class="events-section events-upcoming">
                <article class="post group" style="padding-left: 10px; padding-bottom: -10px;">   
                   <header class="entry-top special-top"> 
                    
                    <h1 class="entry-title page-title" style="margin-top:10;">
                        <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp; 
                        <a href="?p=artistas&id=<?= $convidado->arttipocodigo ?>"> Resultado da pesquisa... <?= strtoupper( $_GET['q']) ?>
                        </a>  
                    </h1>
                   </header> 
                </article>
               <article class="post group" style="margin-top:-30px;">   
                   <div class="artistas-container row" style="margin-top: 0px;">
                      <div class="large-10 columns"style="margin-left: 5px;">
                        <table style="margin-bottop: -30px">  
                    <?php
                   
                    $q = $_GET['q'];
                    $tipo = $_GET['case'];
                    // ARTISTA *****************************
                    if ($tipo == 1):
                        echo "<h4>Artista(s)</h4>";
                        $artistas = new Read;
                        $artistas->parseQuery("SELECT * FROM artista WHERE artnome like :q or artusual like :q ORDER BY artnome ASC", "q=%{$q}%");
                         $toart = 0;
                        if ($artistas->getResult()):
                            $cont = 0;
                            $toart = 0;
                            echo "<tr>";
                            foreach ($artistas->getResult() as $artista):
                                $tm = sizeof($artista);
                                $artista = new Artista($artista['artcodigo']);
                                $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/files/imagem/user.png';
                                endif;
                               // echo "<a href='?p=artist&id={$artista->artcodigo}'> <img src='{$imgp}' width='90' height='90' /> &bull; {$artista->artnome} &bull; ({$artista->artusual})...</a></br><hr>";
                               //foreach ($musicos as $key => $artista):
                               if ($cont == 8):
                                   $cont = 0;
                                   echo "</tr><tr>";
                                endif;                                
                                ?>
                                    <td > 
                                       <aside class="widget group" style="width: 130px; height:130px; margin-right: 5px; margin-bottom:20px;"> 
                                           <figure class="event-thumb" style="margin: 0px;">    
                                               <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="Acesse...<?= $artista->artusual ?>"> 
                                                   <img src="admin/files/artistas/<?= $artista->artfoto ?>" alt="" />   
                                               </a>                                           
                                           </figure>          
                                           <a title="Acesse...<?= $artista->artusual ?>" href="?p=artist&id=<?= $artista->artcodigo ?>" class="action-btn"><?= substr($artista->artusual,0,20) ?></a>   
                                       </aside>                                   
                                   </td>  
                               <?php
                               $cont ++;
                               $toart ++;
                              endforeach;
                              if ($cont <= 8 || ($tm % 8 == 0)):
                                  echo "</tr>";
                                  echo "</tr>";
                              endif;
                           else:
                              echo "<p>Nenhum registro encontrado para este ARTISTA ".strtoupper( $_GET['q'])."</p>";
                          endif;
                          echo $toart." ARTISTA(s) encontrados com nome.. ".strtoupper( $_GET['q']);
                           //   echo $tomus." MUSICAS Encontradas com nome.. ".strtoupper( $_GET['q']);
                   // DISO *****************************
                     elseif ($tipo == 2):
                        echo "<h4>Disco(s)</h4>";
                        $discos = new Read;
                        $discos->parseQuery("SELECT * FROM disco WHERE disnome like '%$q%' ORDER BY disnome ASC");
                       
                        $todis = 0;
                        if ($discos->getResult()):
                            $cont = 0;
                            $todis = 0;
                            echo "<tr>";
                            foreach ($discos->getResult() as $disco):
                                $tm = sizeof($disco);
                                $disco = new Disco($disco['discodigo']);
                                $imgp = "admin/files/discos/" . trim($disco->disimagem);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/files/imagem/user.png';
                                endif;
                               // echo "<a href='?p=album&id={$disco->discodigo}'> <img src='{$imgp}' width='90' height='90' /> &bull; {$disco->disnome} ...</a></br><hr>";
                                if ($cont == 8):
                                   $cont = 0;
                                   echo "</tr><tr>";
                                endif;  
                               
                                ?>
                                     <td > 
                                       <aside class="widget group" style="width: 130px; height:130px; margin-right: 5px; margin-bottom:20px;"> 
                                           <figure class="event-thumb" style="margin: 0px;">    
                                               <a href="?p=album&id=<?= $disco->discodigo ?>" title=" Acesse...<?= $disco->disnome ?>"> 
                                                   <img src="<?= $imgp ?>" alt="" />   
                                               </a>                                           
                                           </figure>          
                                           <a title=" Acesse...<?= $disco->disnome ?>" href="?p=album&id=<?= $disco->discodigo ?>" class="action-btn"><?= substr($disco->disnome,0,20) ?></a>   
                                       </aside>                                   
                                   </td>  
                                <?php
                              $cont ++;
                              $todis ++;
                             
                              endforeach;
                              if ($cont <= 8 || ($tm % 8 == 0)):
                                  echo "</tr>";
                              endif;
                              
                           else:
                               echo "<p>Nenhum registro encontrado para este DISCO ".strtoupper( $_GET['q'])."</p>";
                          endif;
                          echo $todis." DISCO(s) encontrados com nome..".strtoupper( $_GET['q']);
                      
                     // MUSICAS *****************************      
                    else:
                        echo "<h4>Música(s)</h4>";
                        $musicas = new Read;
                        // $discos->parseQuery("SELECT * FROM disco WHERE disnome like '%$q%' ORDER BY disnome ASC");
                        $musicas->parseQuery("SELECT * FROM musica WHERE musnome like '%$q%' ORDER BY musnome ASC");
                        //$musicas->parseQuery("SELECT * FROM musica WHERE musnome like :q ORDER BY musnome ASC", "q=%{$q}%");
                        $tomus = 0;
                        if ($musicas->getResult()):
                            $cont = 0;
                            $tomus = 0;
                            echo "<tr>";
                            foreach ($musicas->getResult() as $musica):
                                $musica = new Musica($musica['muscodigo']);
                                $musdisco = new MusicaDisco(null, $musica->muscodigo);
                                $disco = $musdisco->getDisco();
                                $imgp = "admin/files/discos/" . trim($disco->disimagem);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/files/imagem/user.png';
                                endif;
                                //echo "<a href='?p=album&id={$disco->discodigo}'> <img src='{$imgp}' width='90' height='90' />  &bull;  {$musica->musnome} &bull; {$disco->disnome} ...</a></br><hr>";
                                 if ($cont == 6):
                                   $cont = 0;
                                   echo "</tr><tr>";
                                endif; 
                                ?>
                                     <td > 
                                       <aside class="widget group" style="width: 180px; height:180px; margin-right: 5px; margin-bottom:30px;"> 
                                           <figure class="event-thumb" style="margin: 0px;">    
                                               <a href="?p=album&id=<?= $disco->discodigo ?>" title="Acesse...<?= $disco->disnome ?>"> 
                                                   <img src="<?= $imgp ?>" alt="" />   
                                               </a>                                           
                                           </figure>          
                                           <a title="Acesse...<?= $disco->disnome ?>" href="?p=album&id=<?= $disco->discodigo ?>" class="action-btn"><?= substr($disco->disnome,0,35) ?><br>&nbsp;&nbsp;<?= substr($musica->musnome,0,35) ?></a>   
                                       </aside>                                   
                                   </td>  
                                <?php  
                              $cont ++;
                              $tomus ++;
                            endforeach;
                            if ($cont <= 6 || ($tm % 6 == 0)):
                                  echo "</tr>";
                             endif;
                        else:
                             echo "<p>Nenhum registro encontrado para esta MÚSICA ".strtoupper( $_GET['q'])."</p>";
                        endif;
                           echo $tomus." MUSICA(s) encontradas com nome.. ".strtoupper( $_GET['q']);
                    endif;
                      
                    ?>
                      
                      </table>
                    </div>
                    </div>
                </article>    
            </section>
        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->