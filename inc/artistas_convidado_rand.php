﻿    <aside class="widget group">
	<?php
	$artistas = new Read();
	$artistas->ExeRead("artista", "WHERE arttipocodigo = 18  ORDER BY rand() limit 1");
	
	?>
	<ol class="widget-list">
	<h4 class="widget-title"><a href="?p=artists">Convidados Especiais</a></h4>
	
	<?php 
	foreach($artistas->getResult() as $artista):
	$arttipocodigo = $artista['arttipocodigo'];
	$artista_tipos = new ArtistaTipo();
	//var_dump( $tipocodigo);
	foreach ($artista_tipos->getResult() as $artista_tipo):
	$tipocodigo = $artista_tipo['arttipocodigo'];
	$tiponome = $artista_tipo['arttiponome'];
	if($tipocodigo == $arttipocodigo ):
	?>
	
	<h4 class="list-title"><a href="?p=artist&id=<?=$artista['artcodigo']?>"><?= $artista['artusual']?></a></h4>
	<h5 class="list-subtitle"><?=$artista_tipo['arttiponome']?></h5>
	
	<?php
	endif;
	endforeach;
	?>
	
	
	<li>
	<figure class="event-thumb">
	<a  title="Mais sobre... <?=  $artista['artusual']?>" href="?p=artist&id=<?=$artista['artcodigo']?>">
	<?php 
	$artfoto = "admin/files/artistas/" . trim($artista['artfoto']);
	if (!file_exists($artfoto) or !is_file($artfoto)):
	$artfoto = 'admin/files/imagem/user.png';
	endif;
	?>
	
	<img src="<?=$artfoto?>" width="100%" height="100%" alt="" />
	
	<div class="overlay icon-info-sign"></div>
	
	</a>
	</figure>
	<a  href="?p=artist&id=<?=$artista['artcodigo']?>" class="action-btn">Veja Artista</a>
	</li>
	<?php  
	// var_dump($artista['artcodigo']);
	endforeach;?>
	</ol>
	</aside>
