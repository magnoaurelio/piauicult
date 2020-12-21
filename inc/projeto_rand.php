 <aside class="widget group">
      <h4 class="widget-title"><a href="?p=projetos">Projetos</a></h4>
        <ol class="widget-list">
       
        <?php
        $projetos =  new Projetos();
        $projetos->ExeRead("projeto", "ORDER BY rand() limit 1");
        foreach ($projetos->getResult() as $projeto):
          //$evelocal =  $evento['evelocal'];
        ?>
         <li>
            <figure class="event-thumb">
                <a  title="Mais sobre... <?=  $projeto['pronome']?>" href="?p=projeto&id=<?= $projeto['procodigo'] ?>">
                <img src="admin/files/projetos/<?= $projeto['proimagem'] ?>" alt="" />
                <div class="overlay icon-info-sign"></div>
                </a>
            </figure>
            <h5 class="list-title" style="margin-bottom: 5px; letter-spacing: 0.1px;"><a href="?p=projeto&id=<?= $projeto['procodigo'] ?>"><?=$projeto['pronome'] ?></a></h5>
              
         <?php
        endforeach;
        ?>
        
    </ol>
  </aside><!-- /widget -->
