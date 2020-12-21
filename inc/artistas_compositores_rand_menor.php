﻿<aside class="widget group">
<?php
$artistas = new Read();
$artistas->ExeRead("artista", "WHERE arttipocodigo = 1 or arttipocodigo = 9 or arttipocodigo = 10 ORDER BY rand() limit 1");

?>
<ol class="widget-list">
 <h4 class="widget-title"><a href="?p=artists">Compositores</a></h4>
 
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
 
<li>
     <h4 class="list-title"><a href="?p=artist&id=<?=$artista['artcodigo']?>"><?= $artista['artusual']?></a></h4>
   <h5 class="list-subtitle"><?=$artista_tipo['arttiponome']?></h5>
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
     <a  href="?p=artist&id=<?=$artista['artcodigo']?>" class="action-btn">Veja o Compositor</a>
</li>
<?php
    endif;
   endforeach;
    
// var_dump($artista['artcodigo']);
 endforeach;?>
</ol>
<!--  mostra outros compositores menoires-->
 <?php
$artistas = new Read();
$artistas->ExeRead("artista", "WHERE arttipocodigo = 1 or arttipocodigo = 9 or arttipocodigo = 10 ORDER BY rand() limit 5");

?>
<ol class="widget-list">
 <!--h4 class="widget-title"><a href="?p=artists">Compositores</a></h4*-->
 
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
    
<li style="paddin-left: 10px;">
    <figure class="event-thumb" >
         <h4 class="list-title"><a href="?p=artist&id=<?=$artista['artcodigo']?>"><?= $artista['artusual']?></a></h4>
                <h5 class="list-subtitle"><?=$artista_tipo['arttiponome']?></h5>
              
        <a  title="Mais sobre o Compositor... <?=  $artista['artusual']?>" href="?p=artist&id=<?=$artista['artcodigo']?>">
            <?php 
                 $artfoto = "admin/files/artistas/" . trim($artista['artfoto']);
                 if (!file_exists($artfoto) or !is_file($artfoto)):
                     $artfoto = 'admin/files/imagem/user.png';
                 endif;
              ?>
                
            
            <tr width="200"><img src="<?=$artfoto?>" width="35%" height="35%" alt="" /></tr>          
            <div class="overlay icon-info-sign"></div>
              
        </a>
    </figure>
     <a  href="?p=artist&id=<?=$artista['artcodigo']?>" title="Mais sobre o Compositor... <?=  $artista['artusual']?>" class="action-btn">Veja o Compositor</a>
</li>
 <?php
    endif;
   endforeach;
// var_dump($artista['artcodigo']);
 endforeach;?>

</ol>
</aside>
