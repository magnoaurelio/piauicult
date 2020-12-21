<div id="main-wrap" style="padding-top: 0;"> 
    <div id="main" class="row">
      
            <h3>Artistas</h3>
     
        <div class="large-12 columns">
            <ul class="list row">
                <?php 
                $artistas =  new Artista();
                foreach ($artistas->getResult() as $artista):
				$arttipocodigo = $artista['arttipocodigo'];
		       // var_dump( $arttipocodigo);
                ?>
                    <li class="large-2 columns">
                        <div class="li-content">
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
                            <h5 class="list-subtitle"></h5>
                            <h5 class="list-title"><a href="?p=artist&id=<?=$artista['artcodigo']?>"><?=$artista['artusual']?></a></h5>
                              <?php  
			   $artista_tipos = new ArtistaTipo();
			   //var_dump( $tipocodigo);
			   foreach ($artista_tipos->getResult() as $artista_tipo):
			    $tipocodigo = $artista_tipo['arttipocodigo'];
			    $tiponome = $artista_tipo['arttiponome'];
				//var_dump( $artista->arttipocodigo);
			    if($tipocodigo == $arttipocodigo ):

		      	 ?>
                        <h5 class="list-subtitle"><?=$tiponome?></h5><br/>
               <?php
			    endif;
               endforeach;
			   ?>
                            <a href="?p=artist&id=<?=$artista['artcodigo']?>" class="action-btn">Detalhes</a>
                        </div>
                    </li>
                <?php 
                    endforeach;
                ?>
            </ul>

            <div id="paging">
                <span class="current">1</span>
            </div><!-- /paging -->

        </div><!-- /large-12 -->
    </div><!-- /main -->
</div><!-- /main-wrap -->
