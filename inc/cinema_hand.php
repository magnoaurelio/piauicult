<aside class="widget group">
           <?php
           $cinemas = new Read();
           $cinemas->ExeRead("cinema", "ORDER BY rand() limit 2");
           //"WHERE arttipocodigo = 5", "ORDER BY rand limit 1"
           ?>

           <h4 class="widget-title"><a href="?p=disco">Cinema</a></h4>
           <ol class="widget-list widget-list-single">

               <?php

               foreach ($cinemas->getResult() as $cinema):
                   $cinema = new Cinema($cinema["cincodigo"]);
                   $artista = $cinema->getArtista();

                   $premio = new FestivalPremio($humor->fesprecodigo);
                   $fesprenome = $premio->fesprenome;
                   $fesprefoto = "admin/files/festivais/" . $premio->fesprefoto;

                   ?>
                   <li>
                       <figure class="event-thumb">
                           <a target="_blank" href="?p=cinema-detalhe&id=<?=$cinema->cincodigo ?>">
                               <img src="admin/files/cinema/<?= $cinema->cinimagem ?>" alt=""/>

                               <div class="overlay icon-info-sign"></div>
                           </a>
                       </figure>
                       <p>  <img src="<?= $fesprefoto ?>" width="30"/> <?= $fesprenome ?></p>
                       <h5 class="list-subtitle"
                           style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                           <a target="_blank"
                              href="?p=cinema-detalhe&id=<?=$cinema->cincodigo ?>"
                              title="Ir para o Catalogo:  <?= $cinema->cinnome ?> ">
                               <?= $cinema->cinnome?><br>
                           </a>
                           <a target="_blank"
                              href="?p=cinema-detalhe&id=<?=$cinema->cincodigo ?>"
                              title="Ir para o Catalogo:  <?= $cinema->cinnome ?> ">
                               <small style="color: red; font-size: 16px; font-weight: 400"><?= $cinema->getGenero()->descricao ?></small>
                           </a>
                           <a href="?p=artista-cinema&id=<?= $artista->artcodigo ?>"
                              class="" title="<?= $artista->artusual ?>">
                               <img src="admin/files/artistas/<?= $artista->artfoto ?>"
                                    width="40" alt=""/>
                           </a>

                       </h5>
                       <? //$date =  date($disco['disdata'],'d-m-Y');

                       ?>
                   </li>
                   <?php
               endforeach;
               ?>

           </ol>
       </aside>

