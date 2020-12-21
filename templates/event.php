<?php
$evento = new Evento($_GET['id']);
$imgp = "admin/files/eventos/" . trim($evento->eveimagem1);
if (!file_exists($imgp) or ! is_file($imgp)):
    $imgp = 'admin/files/imagem/user.png';
endif;
$data = DataCalendario::date2br($evento->evedata);
$local = new EventoLocal($evento->evelocal);
$artista = new Artista($evento->artcodigo);
?>
<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-9 columns" style="margin-top:-40px;">
               <h4 class="widget-title">Eventos Culturais</h4>
            <section class="events-section">
                <article class="post group">
                    
               
                    <header class="entry-top special-top">
                        <h1 class="entry-title page-title"><?= $evento->evenome ?></h1>
                        <div class="entry-meta">
                            Acesse o(s) Artista(s):
                            <?php
                            $artistas = $evento->getArtistas();
                            $artistas_format = [];

                            foreach ($artistas as $artista):
                                $artista = new Artista($artista["artcodigo"]);
                                $artistas_format[] = "<a href='?p=artist&id={$artista->artcodigo}'>" . $artista->artusual . "</a>";
                            endforeach;
                            $artistas_format = implode(" <span>&bull;</span> ", $artistas_format);
                            echo $artistas_format;
                            ?>
                         </div>
                         <figure class="entry-thumb">
                            <a data-rel='prettyPhoto[pp_gal]'  href="<?= $imgp ?>" >  <img  src="<?= $imgp ?>" alt="" /></a>
                         </figure>
                        <ul class="cpt-meta">
                            <li><span>Data evento:</span> <?= $data ?></li>
                            <li><span>Local:</span><?= $local->locnome ?> - <?= $local->locendereco ?>, <?= $local->locbairro ?></li>
                            <li><span>Horário:</span> <?= $evento->evehorario ?></li>
                        </ul>
                             <div class="entry-content">
                                   <?= $evento->evedetalhe ?>
                              </div>
                    </header>
                    
                    <br><br><br>
                    <?php
                    if ($evento->eveimagem1): ?>
                        <div class="panel panel-default" style="float: left;width: 98%; margin: 0 auto;">
                            <div class="panel-heading" style="border-top: 1px solid;">
                                <time style="text-align: center" class="list-subtitle">Fotos Relacionadas</time>
                            </div>
                            <div class="panel-body">
                                <table class="table fotos-relacionadas">
                                    <tr>
                                        <?php
                                        for ($i = 2; $i <= 6; $i++) {
                                            $var = 'eveimagem' . $i;
                                            $file = "admin/files/eventos/{$evento->$var}";
                                            if ($evento->$var):
                                                echo " <a onclick='Topo()'  data-rel='prettyPhoto[pp_gal]' href='{$file}'>";
                                                echo "<img class='image' src='{$file}' style='max-height:80px; margin:5px; border-radius:6px;'></a>";
                                            endif;
                                        }
                                        ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php
                    endif;
                    ?>
                   
                </article><!-- /post -->
                      

                <div class="events-content">
                    <div class="panel-heading">
                        <h4 style="text-align: center" class="list-subtitle">Localização</h4>
                    </div>
                    <div id="map" class="events-map"></div>
                </div>	
                <?php
                $cordenadas = explode(",", $local->loccordenadas);
                $x = $cordenadas[0];
                $y = $cordenadas[1];
               
                ?>
                <script type="text/javascript">
                    var x = parseFloat("<?= $x ?>")
                    var y = parseFloat("<?= $y ?>")
                    

                    var locations = [
                        ['<h2><?= $local->locnome ?></h2><h4><?= $local->locendereco ?>, <?= $local->locbairro ?></h4><p><?= $data ?> - <?= $evento->evehorario ?></p>', x, y],
                    ];

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 18,
                        center: new google.maps.LatLng(x, y),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    var infowindow = new google.maps.InfoWindow();

                    var marker, i;
                    var image = 'admin/files/discos/piaui_cult_icon.png';
                    for (i = 0; i < locations.length; i++) {
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            map: map,
                            icon: image,
                        });
                        
                        google.maps.event.addListener(marker, 'click', (function (marker, i) {
                            return function () {
                                infowindow.setContent(locations[i][0]);
                                infowindow.open(map, marker);
                            }
                        })(marker, i));
                    }
                </script>
            </section>



        </div>
        <div class="large-3 columns sidebar sidebar-1">
             
           <!--** eventos-->
             <?php include 'inc/dados-eventos.php' ?>

        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
