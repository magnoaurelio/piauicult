   <aside class="widget group">
                <?php
                $discos = new Read();
                $discos->ExeRead("disco", "ORDER BY rand() limit 1");
                //"WHERE arttipocodigo = 5", "ORDER BY rand limit 1"
                ?>

                <h4 class="widget-title"><a href="?p=disco">Discos Gravados</a></h4>
                <ol class="widget-list widget-list-single">

                    <?php
                    foreach ($discos->getResult() as $disco):
                        ?>
                        <li>
                            <figure class="event-thumb">
                                <a  title="Mais sobre... <?=$disco['disnome']?>" href="?p=album&id=<?= $disco['discodigo'] ?>">
                                    <img src="admin/files/discos/<?= $disco['disimagem'] ?>" alt="" />
                                    <div class="overlay icon-info-sign"></div>
                                </a>
                            </figure>
                            <h5 class="list-title" style="margin-bottom: 5px; letter-spacing: 0.1px;"><a href="?p=album&id=<?= $disco['discodigo'] ?>"><?= $disco['disnome'] ?></a></h5>
                            <span class="track-meta" datetime=""><?= DataCalendario::date2br($disco['disdata']) ?> </span>
                            <a href="?p=album&id=<?= $disco['discodigo'] ?>" class="action-btn">Veja o CD</a>
                        </li> 
    <?php
endforeach;
?>

                </ol>
            </aside>