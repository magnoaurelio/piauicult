<?php
$local = new EventoLocal($_GET['id']);
$imgp = "admin/files/local/" . trim($local->locimagem);
if (!file_exists($imgp) or ! is_file($imgp)):
    $imgp = 'admin/files/imagem/user.png';
endif;
?>
<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-9 columns" style="margin-top:-40px;">
            <h4 class="widget-title">Local</h4>
            <section class="events-section">
              <!--   <article class="post group">
                    
                    <header class="entry-top special-top">
                        <h1 class="entry-title page-title" style="text-align:center;"><?= $local->locnome ?></h1>
                        <ul class="cpt-meta">
                            <li>
                                <figure class="entry-thumb" style="text-align:center;">
                                    <img src="<?= $imgp ?>" alt="" />
                                </figure>

                            </li>
                            <li><span>Endereço:</span><?= $local->locnome ?> - <?= $local->locendereco ?>, <?= $local->locbairro ?> <?= $local->loccidade ?></li>
                            <li><span>Complemento:</span> <?= $local->loccomplemento ?></li>
                            <li><span>Responsável:</span><?= $local->locresponsavel ?></li>
                            <li><span>Contato:</span><?= $local->locfone . " / " . $local->loccelular ?></li>
                            <li><span>Cordenadas:</span> <?= $local->locsobre ?></li>

                        </ul>
                    </header>
                    <br><br><br>

                </article>/post -->
                <section class="events-section">
                <article class="post group">
                    <header class="entry-top special-top">
                        <h1 class="entry-title page-title"><?= $local->locnome ?></h1>
                        <ul class="cpt-meta">                           
                           <li>
                             <?php
                            for ($i = 1; $i <= 1; $i++) {
                                    $var = 'locimagem' . $i;
                                    $file = "admin/files/local//{$local->$var}";
                                    if ($local->$var):
                                            echo " <a  data-rel='prettyPhoto[pp_gal]' href='{$file}'>";
                                            echo "<img class='image' src='{$file}' style='max-height:450px;max-width:500px; margin:5px; border-radius:6px;'></a>";
                                    endif;
                            }
                            ?>                           
                            </li>
                            <li><span>Endereço:</span><?= $local->locnome ?> - <?= $local->locendereco ?>, <?= $local->locbairro ?> <?= $local->loccidade ?></li>
                            <li><span>Complemento:</span> <?= $local->loccomplemento ?></li>
                            <li><span>Responsável:</span><?= $local->locresponsavel ?></li>
                            <li><span>Contato:</span><?= $local->locfone . " / " . $local->loccelular ?></li>
                            <li><span>Sobre:</span> <?= $local->locsobre ?></li>
                        </ul>
                    </header>
                    <br><br><br>
                    <?php
                    if ($local->locimagem1): ?>
                        <div class="panel panel-default" style="float: left;width: 98%; margin: 0 auto;">
                            <div class="panel-heading" style="border-top: 1px solid;">
                                <time style="text-align: center" class="list-subtitle">Fotos Relacionadas</time>
                            </div>
                            <div class="panel-body">
                                <table class="table fotos-relacionadas">
                                    <tr>
                                        <?php
                                        for ($i = 2; $i <= 6; $i++) {
                                            $var = 'locimagem' . $i;
                                            $file = "admin/files/local/{$local->$var}";
                                            if ($local->$var):
                                                echo " <a  data-rel='prettyPhoto[pp_gal]' href='{$file}'>";
                                                echo "<img class='image' src='{$file}' style='max-height:80px;max-width:100px; margin:5px; border-radius:6px;'></a>";
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
                        ['<h2><?= $local->locnome ?></h2><h4><?= $local->locendereco ?>, <?= $local->locbairro ?></h4><p><?= $data ?> - <?= $local->loccidade ?></p>', x, y],
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


            <aside class="widget group">
                <h4 class="widget-title"><a href="?p=locais">Locais</a></h4>
                <ol class="widget-list">

                    <?php
                    $eventos = new EventoLocal();
                    foreach ($eventos->getResult() as $local):
                        $local = new EventoLocal($local['loccodigo']);
                        ?>
                        <li>
                            <figure class="event-thumb">
                                <a href="?p=local&id=<?= $local->loccodigo ?>">
                                    <img src="admin/files/local/<?= $local->locimagem1 ?>" alt="" />
                                    <div class="overlay icon-info-sign"></div>
                                </a>
                            </figure>
                            <h4 class="list-title"><a href="?p=local&id=<?= $local->loccodigo ?>"><?= $local->locnome ?></a></h4>
                            <a href="?p=local&id=<?= $local->loccodigo ?>" class="action-btn">Detalhes</a>
                    </li> 
                    <?php
                    endforeach;
                    ?>

                </ol>
            </aside><!-- /widget -->

        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
