<?php
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
            <h4>Artistas do Gênero:<a href="#"> <?=$gennome ?></a> </h4>
            <?php
                  $artcodigo = $genero['artcodigo'];
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
            <ul class="list row">
                <li class="large-3 columns">
                    <div class="li-content">
                        <figure class="event-thumb">
                                <a href="?p=artist&id=<?=$artcodigo ?>">
                                        <img src=" <?=$imgart ?>" alt="" />
                                        <div class="overlay icon-picture"></div>
                                </a>			
                        </figure>
                        <h4 class="list-title"><a href="?p=artist&id=<?=$artcodigo ?>"><?=$artusual ?></a></h4>
                        <a href="#" class="action-btn">Veja mais...</a>
                    </div>

                </li>
            </ul>
             <?php
              }
            ?>
            <div id="main" class="row">
                <div class="large-12 columns" >
                     <article class="post group">   
                           <header class="entry-top special-top"> 
                                <article class="post group" >

                                <div class="entry-content">
                                    <div class="row">
                                        <div class="large-8 columns"></div>
                            <?= $genero['genorigem']?> 
                                    </div>
                                </div>
                               </article>
                           </header>
                       </article>
                      <div id="paging">
                    <a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><span class="current">5</span><a href="#">6</a>
            </div><!-- /paging -->
                </div>
                

            </div>
                
             
          
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