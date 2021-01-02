<?php
    $gencodigo = $_GET['gencodigo'];
    $generos = new Genero(null, "WHERE gencodigo = $gencodigo ORDER BY gencodigo ASC");
    $generoCodigos = [];
    foreach ($generos->getResult() as $genero) {
        $gennome = $genero['gennome'];
        $inscodigo = $genero['inscodigo'];
        $artcodigo = $genero['artcodigo'];
            
    }
   $imgins = "admin/files/instrumento/" . trim($generos->inscodigo);
   if (!file_exists($imgins) or ! is_file($imgins)):
       $imgins = 'admin/files/imagem/instrumento.png';
   endif;

?>
<div id="section" style="background:url(images/header.jpg) no-repeat top center">
	<div class="row">
		<div class="large-12 columns">
                    <h3>Instrumentos do Gênero:<i style="color:#F9B233; font-size: 50px;"> <?=$gennome ?></i> </h3>
		</div><!-- /large-12 -->
	</div><!-- /row -->
</div><!-- /section -->
	

<div id="main-wrap">
    <div id="main" class="row">

        <div class="large-12 columns">
             <?php
             $instrumentos = $genero->getInstrumentos();
             $imgins = "admin/files/instrumento/" . trim($instrumento->insfoto);
             ?>
            <ul class="list row">
                <li class="large-3 columns">
                    <div class="li-content">
                        <figure class="event-thumb">
                                <a href="#">
                                        <img src=" <?=$imgins ?>" alt="" />
                                        <div class="overlay icon-picture"></div>
                                </a>			
                        </figure>
                            
                        <h4 class="list-title"><a href="gallery.html">GALERIA DE FOTOS</a></h4>
                        <a href="#" class="action-btn">Veja mais...</a>
                    </div>
                </li>
            </ul>

            <div id="paging">
                    <a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><span class="current">5</span><a href="#">6</a>
            </div><!-- /paging -->

       </div><!-- /large-12 -->
    </div><!-- /main -->
</div><!-- /main-wrap -->
