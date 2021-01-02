<?php
    $gencodigo = $_GET['gencodigo'];
    $inscodigo = $_GET['inscodigo'];
    $generos = new Genero(null, "WHERE gencodigo = $gencodigo ORDER BY gencodigo ASC");
    $generoCodigos = [];
    foreach ($generos->getResult() as $genero) {
        $gennome = $genero['gennome'];
        $genorigem = $genero['genorigem'];
        $artcodigo = $genero['artcodigo'];
            
    }
   $imgins = "admin/files/instrumento/" . trim($generos->inscodigo);
   if (!file_exists($imgins) or ! is_file($imgins)):
       $imgins = 'admin/files/imagem/instrumento.png';
   endif;

?>
<!--div id="section" style="background:url(images/header.jpg) no-repeat top center">
	<div class="row">
            <div class="large-12 columns" style="margin-top: 50px;">
                    <h3>Instrumentos do Gênero:<i style="color:#F9B233; font-size: 50px;"> <?=$gennome ?></i> </h3>
		</div><!-- /large-12 -->
	<!--/div--><!-- /row -->
<!--/div><!-- /section -->
	

<div id="main-wrap">
    <div id="main" class="row">

        <div class="large-12 columns">
           
                <?php
                 $instrumentos = new Instrumento(null, null, "WHERE inscodigo = $inscodigo ORDER BY insnome ASC");
                 $instruCodigos = [];
                 foreach ($instrumentos->getResult() as $instrumento) {
                     $instfoto = $instrumento['insfoto'];
                     $insnome = $instrumento['insnome'];
                     $inshistorico = $instrumento['inshistorico'];
                     $instruCodigos[] = $instrumento['inscodigo'];

               $imgins = "admin/files/instrumento/" . trim($instrumento['insfoto']);
                 if (!file_exists($imgins) or ! is_file($imgins)):
                     $imgins = 'admin/files/imagem/artista.png';
                 endif;

            ?>
             <h4>Instrumentos do Gênero:<a href="?p=artista-genero&id=<?=$gencodigo ?>" title="Voltar Página Gênero"> <?=$gennome ?></a> </h4>
            <ul class="list row">
                <li class="large-3 columns">
                    <div class="li-content">
                        <figure class="event-thumb">
                            <a href="?p=instrumentistas&id=<?=$inscodigo ?>" title="Veja mais sobre: <?=$insnome ?>">
                                        <img src=" <?=$imgins ?>" alt="" />
                                        <div class="overlay icon-info"></div>
                                </a>			
                        </figure>
                        <h4 class="list-title">
                            <a href="?p=instrumentistas&id=<?=$inscodigo ?>" title="Veja mais sobre: <?=$insnome ?>">
                           <?=$insnome ?>
                            </a>
                        </h4>
                        <a href="?p=instrumentistas&id=<?=$instcodigo ?>" title="Veja mais sobre: <?=$insnome ?>" class="action-btn">Veja mais...</a>
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
                                <h4>Histórico do Genero:<a href="?p=artista-genero&id=<?=$gencodigo ?>" title="Voltar Página Gênero"> <?=$gennome ?></a> </h4>
                                <div class="entry-content">
                                    <div class="row">
                                      <div class="large-8 columns"></div>
                                    <?= $genorigem?> 
                                    </div>
                                </div>
                               </article>
                           </header>
                       </article>
            </div>
            <div id="paging">
                    <!--a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><span class="current">5</span><a href="#">6</a-->
            </div><!-- /paging -->

       </div><!-- /large-12 -->
    </div><!-- /main -->
</div><!-- /main-wrap -->
