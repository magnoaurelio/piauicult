       
       
<aside class="widget group">
      <h4 class="widget-title"><a href="?p=events">Eventos</a></h4>
        <ol class="widget-list">
       
        <?php
        $mes =  date('m');
        $eventos =  new Evento(null,"WHERE evehome != 1 ORDER BY evedata DESC"); //AND  MONTH(evedata) = {$mes} 
        //var_dump($eventos);
        foreach ($eventos->getResult() as $evento):
          $evelocal =  $evento['evelocal'];
        ?>
         <li>
            <figure class="event-thumb">
                <a href="?p=event&id=<?= $evento['evecodigo'] ?>">
                <img src="admin/files/eventos/<?= $evento['eveimagem1'] ?>" alt="" />
                <div class="overlay icon-info-sign"></div>
                </a>
            </figure>
            <h5 class="list-title" style="margin-bottom: 5px; letter-spacing: 0.1px;"><a href="?p=event&id=<?= $evento['evecodigo'] ?>"><?=$evento['evenome'] ?></a></h5>
            
					
            <time class="list-subtitle" datetime="20-05-2016 22:00">Data: <?= DataCalendario::date2br($evento['evedata']) ?> Horário: <?=$evento['evehorario']?></time>
           
                <?php
                 $eventos_local =  new EventoLocal();
                 foreach ( $eventos_local->getResult() as  $evento_local):
                     if($evelocal == $evento_local['loccodigo']):
                 ?>
                    <a href="?p=local&id=<?= $evento_local['loccodigo'] ?>"><img src="admin/files/local/<?= $evento_local['locimagem1'] ?>" alt="" />  </a>
                    <h4 class="list-title"><a href="?p=local&id=<?= $evento_local['loccodigo'] ?>"><?= $evento_local['locnome'] ?></a></h4>
                    <a href="?p=local&id=<?= $evento_local['loccodigo'] ?>" class="action-btn">Informações</a>
               <?php
                  endif;
               endforeach;
               ?>
         </li> 
        <?php
        
        endforeach;
        ?>
        
    </ol>
  </aside><!-- /widget -->
                 