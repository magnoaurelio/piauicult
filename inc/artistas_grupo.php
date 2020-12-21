 <aside class="widget group">
    <h4 class="widget-title"><a href="?p=artists">Grupos</a></h4>
    <ol class="widget-list">
    <?     
	$artistas =  new Artista();
	foreach ($artistas->getResult() as $artista):
	   $arttipocodigo = $artista['arttipocodigo'];
	   if($arttipocodigo=='12' or $arttipocodigo=='13'  ):
	?>
        <li>
            <figure class="event-thumb">
					<a href="?p=artist&id=<?=$artista['artcodigo']?>">
                   <?php $artfoto = "admin/files/artistas/" . trim($artista['artfoto']);
                        if (!file_exists($artfoto) or !is_file($artfoto)):
                            $artfoto = 'admin/files/imagem/user.png';
                        endif;
                     ?>
                    <img src="<?=$artfoto?>" width="100%" height="100%" alt="" />
                    <div class="overlay icon-info-sign"></div>
                </a>
            </figure>
           
            <h4 class="list-title"><a href="../templates/artist.php"><?= $artista['artusual']?></a></h4>
              <?php  
			   $artista_tipos = new ArtistaTipo();
			   //var_dump( $tipocodigo);
			   foreach ($artista_tipos->getResult() as $artista_tipo):
			    $tipocodigo = $artista_tipo['arttipocodigo'];
			    $tiponome = $artista_tipo['arttiponome'];
			    if($tipocodigo == $arttipocodigo ):
		  	 ?>
            <h5 class="list-subtitle"><?=$artista_tipo['arttiponome']?></h5>
               <?php
			    endif;
               endforeach;
			   ?>
            <a href="../templates/artist.php" class="action-btn">Veja Artista</a>
        </li>
       <?php
	       endif;
         endforeach;
      
	   ?>
    </ol>
</aside><!-- /widget -->
