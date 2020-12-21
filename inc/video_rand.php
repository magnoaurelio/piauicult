<aside class="widget group">
<?php
$videos = new Read();
$videos->ExeRead("videos", "ORDER BY rand() limit 1");

?>
<ol class="widget-list">
 <h4 class="widget-title"><a href="?p=artists">Vídeos</a></h4>
 
<?php 
   foreach($videos->getResult() as $video):
       $artista = new Artista($video['artcodigo']);
   ?>
<li>
     <figure class="event-thumb">
        <a  title="<?=  $video['viddescricao'] ?>" href="?p=artist&id=<?=$artista->artcodigo?>">
       <?php
           $imgp = "admin/files/artistas/" . trim($artista->artfoto);
           $foto = "admin/files/video/" . trim($video['vidfoto']);
           if (!file_exists($imgp) or ! is_file($imgp)):
               $imgp = 'admin/files/images/user.png';
           endif;
           if (!file_exists($foto) or ! is_file($foto)):
               $foto = $imgp;
           endif;
         ?>
          
        <img src="<?=$foto?>" width="100%" height="100%" alt="" />
       
        <div class="overlay icon-info-sign"></div>
      
        </a>
    </figure>
     <a  href="?p=artist&id=<?=$artista->artcodigo?>" class="action-btn">Veja Artista</a>
</li>
 <?php  
// var_dump($artista['artcodigo']);
 endforeach;?>
</ol>
</aside>