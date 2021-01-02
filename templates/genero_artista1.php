<?php

    $gencodigo = $_GET['gencodigo'];
    $artcodigo = $_GET['artcodigo'];
    $inscodigo = $_GET['inscodigo'];
     $gencodigo = $_GET['gencodigo'];
    $generos = new Genero(null, "WHERE gencodigo = $gencodigo ORDER BY gencodigo ASC");
    $generoCodigos = [];
    foreach ($generos->getResult() as $genero) {
        $gennome = $genero['gennome'];
    //    $inscodigo = $genero['inscodigo'];
        $artcodigo = $genero['artcodigo'];
            
    }
   $imgart = "admin/files/artista/" . trim($generos->artcodigo);
   if (!file_exists($imgart) or ! is_file($imgart)):
       $imgart = 'admin/files/imagem/instrumento.png';
   endif;
   
?>

<div id="main-wrap">
    <div id="main" class="row" style="margin-top: -20px;">
        <div class="large-12 columns">
            <h4>Artistas do Gênero:<a href="?p=artista-genero&id=<?=$gencodigo ?>"> <?=$gennome ?></a> </h4>
            <?php
               $generos = new Genero($generos->gebcodigo);
               $generos = $generos->getArtista();
            //   $musicas = new MusicaDisco($disco_musica->discodigo);
            //                    $musicas = $musicas->getArtista();
               if ($generos):
                     foreach ($generos as $genero):
                     $partgenero = false; 
                 
                $interpretes = Genero::getArtista($genero['gencodigo']);
                $interpretes_format = [];
                foreach ($interpretes as $interprete):
                    if ($interprete->artcodigo == $genero['artcodigo']):
                        $partgenero = true;
                    endif;
                    $interpretes_format[] = "<a href='?p=artist&id={$interprete->artcodigo}'>" . $interprete->artusual . "</a>";
                endforeach;
                $interpretes_format = implode(" , ", $interpretes_format);

            ?>
            <ul class="list row">
                <li class="large-3 columns">
                    <div class="li-content">
                        <figure class="event-thumb">
                                <a href="?p=artist&id=<?=$artcodigo ?>">
                                        <img src=" <?=$imgart ?>" alt="" />
                                        <div class="col-lg-8"><small><?= $interpretes_format ?></small></div>
                                </a>			
                        </figure>
                        <h4 class="list-title"><a href="?p=artist&id=<?=$artcodigo ?>"><?=$artusual ?></a></h4>
                        <a href="#" class="action-btn">Veja mais...</a>
                    </div>

                </li>
            </ul>
             
            <div id="main" class="row">
                <div class="large-12 columns" >
                     <article class="post group">   
                           <header class="entry-top special-top"> 
                                <div class="entry-content">
                                    <div class="row">
                                        <div class="large-10 columns">
                                            <?= $genero['genorigem']?> 
                                        </div>
                                          
                                         <ul class="list row">
                                            <li class="large-2 columns">
                                                <div class="li-content">
                                                    <figure class="event-thumb">
                                                            <a href="?p=instrumentistas&id=<?= $genero->inscodigo ?>">
                                                                    <img src=" <?=$imgins ?>" alt="" />
                                                                    <!--div class="overlay icon-picture"></div-->
                                                            </a>			
                                                    </figure>
                                                    <h4 class="list-title"><a href="?p=instrumentistas&id=<?= $genero->inscodigo ?>"><?=$insnome ?></a></h4>
                                                    <a href="#" class="action-btn">Veja mais...</a>
                                                </div>

                                            </li>
                                        </ul>
                                              
                                    </div>
                                </div>
                              
                           </header>
                       </article>
                      <div id="paging">
                    <a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><span class="current">5</span><a href="#">6</a>
            </div><!-- /paging -->
                </div>
                

            </div>
            <?php 
                 endforeach; 
             endif;
             
            ?>
          
       </div><!-- /large-12 -->
    </div><!-- /main -->
</div><!-- /main-wrap -->
<!--div id="section" style="background:url(images/header.jpg) no-repeat top center">
	<div class="row">
		<div class="large-12 columns">
                    <h3>Artistas do Gênero:<i style="color:#F9B233; font-size: 50px;"> </i> </h3>
		</div><!-- /large-12 -->
	
        <!-- /row -->

<!-- /section -->