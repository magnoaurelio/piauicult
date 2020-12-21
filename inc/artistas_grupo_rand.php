﻿<aside class="widget group" style="margin-top: -30px">
    <?php
    $artistas = new Read();
    $artistas->ExeRead("artista", "WHERE arttipocodigo = 12 or arttipocodigo = 13 ORDER BY rand() limit 1");
    
    ?>
    <ol class="widget-list">
     <h4 class="widget-title"><a href="?p=artists">Grupos</a></h4>
     
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
         <figure class="event-thumb">
              <h4 class="list-title"><a href="?p=artist&id=<?=$artista['artcodigo']?>"><?= $artista['artusual']?></a></h4>
           <h5 class="list-subtitle"><?=$artista_tipo['arttiponome']?></h5>
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
         <a  href="?p=artist&id=<?=$artista['artcodigo']?>" class="action-btn" title="Mais sobre... <?=  $artista['artusual']?>">Veja o Grupo</a>
    </li>
     <?php  
      endif;
       endforeach;
    // var_dump($artista['artcodigo']);
     endforeach;?>
    </ol>
 </aside>
 
<!--aside class="widget widget_ci_twitter_widget group">
    <h3 class="widget-title">Twitter</h3>
    <div class="twitter_update_list">
        <ul class="widget-list">
            <li>
                <span>This is the twitter feed!</span>
                <a class="twitter-time" href="#">about 12 hours ago</a>
            </li>

            <li>
                <span>Great, I will prepare a few things this weekend so we have something to discuss!</span>
                <a class="twitter-time" href="#">about 11 hours ago</a>
            </li>

            <li>
                <span>thanx, always a work in progress :) btw i'm going to write down a few ideas about the regional meetup!</span>
                <a class="twitter-time" href="#">about 5 hours ago</a>
            </li>
        </ul>
    </div>
</aside-->