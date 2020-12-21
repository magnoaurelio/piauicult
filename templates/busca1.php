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
                   <div class="artistas-container row" style="margin-top: 5px;">
                      <div class="large-10 columns"style="margin-left: 5px;">
                        <table>  
                              <td> 
                    <?php
                    $q = $_GET['q'];
                    $tipo = $_GET['case'];
                    // ARTISTA *****************************
                    if ($tipo == 1):
                        echo "<h4>Artista(s)</h4>";
                        $artistas = new Read;
                        $artistas->parseQuery("SELECT * FROM artista WHERE artnome like :q or artusual like :q ORDER BY artnome ASC", "q=%{$q}%");
                        if ($artistas->getResult()):
                            foreach ($artistas->getResult() as $artista):
                                $artista = new Artista($artista['artcodigo']);
                                $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/files/imagem/user.png';
                                endif;
                                echo "<a href='?p=artist&id={$artista->artcodigo}'> <img src='{$imgp}' width='90' height='90' /> &bull; {$artista->artnome} &bull; ({$artista->artusual})...</a></br><hr>";
                            endforeach;
                        else:
                            echo "<p>Nenhum registro encontrado para este Artista</p>";
                        endif;
                    // DISCO *****************************
                    elseif ($tipo == 2):
                        echo "<h4>Disco(s)</h4>";
                        $discos = new Read;
                        $discos->parseQuery("SELECT * FROM disco WHERE disnome like '%$q%' ORDER BY disnome ASC");
                        if ($discos->getResult()):
                            foreach ($discos->getResult() as $disco):
                                $disco = new Disco($disco['discodigo']);
                                $imgp = "admin/files/discos/" . trim($disco->disimagem);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/files/imagem/user.png';
                                endif;
                                echo "<a href='?p=album&id={$disco->discodigo}'> <img src='{$imgp}' width='90' height='90' /> &bull; {$disco->disnome} ...</a></br><hr>";
                            endforeach;
                        else:
                            echo "<p>Nenhum registro encontrado para este Disco</p>";
                        endif;
                    else:
                        echo "<h4>Música(s)</h4>";
                        $musicas = new Read;
                        $musicas->parseQuery("SELECT * FROM musica WHERE musnome like :q ORDER BY musnome ASC", "q=%{$q}%");
                        if ($musicas->getResult()):
                            foreach ($musicas->getResult() as $musica):
                                $musica = new Musica($musica['muscodigo']);
                                $musdisco = new MusicaDisco(null, $musica->muscodigo);
                                $disco = $musdisco->getDisco();
                       
                                $imgp = "admin/files/discos/" . trim($disco->disimagem);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/files/imagem/user.png';
                                endif;
                                echo "<a href='?p=album&id={$disco->discodigo}'> <img src='{$imgp}' width='90' height='90' />  &bull;  {$musica->musnome} &bull; {$disco->disnome} ...</a></br><hr>";
                            endforeach;
                        else:
                            echo "<p>Nenhum registro encontrado para esta Música</p>";
                        endif;
                    endif;
                    ?>
                      </td>
                       </table>
                    </div>
                    </div>
                </article>    
            </section>
        </div>
       
    </div><!-- /main -->
</div><!-- /main-wrap -->
