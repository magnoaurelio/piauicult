<aside class="widget group">
    
       
        <h4 class="widget-title"><a href="?p=disco">Discos Gravados</a></h4>
        <ol class="widget-list widget-list-single">
       
        <?php
        $discos =  new Disco();
        foreach ($discos->getResult() as $disco):
        ?>
         <li>
            <figure class="event-thumb">
                <a title="Mais sobre... <?=$disco['disnome']?>" href="?p=album&id=<?= $disco['discodigo'] ?>">
                <img src="admin/files/discos/<?= $disco['disimagem'] ?>" alt="" />
                <div class="overlay icon-info-sign"></div>
                </a>
            </figure>
            <h5 class="list-title" style="margin-bottom: 5px; letter-spacing: 0.1px;"><a href="album.php"><?= $disco['disnome'] ?></a></h5>
              <? //$date =  date($disco['disdata'],'d-m-Y');
			 
			   ?>
					
            <span class="track-meta" datetime="2016-05-20 22:00"><?= $disco['disdata'] ?></span>
            <a href="../templates/album.php" class="action-btn">Veja o CD</a>
         </li> 
        <?php
        endforeach;
        ?>
        
    </ol>
</aside>
   
	



