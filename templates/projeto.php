<?php
$projeto = new Projetos($_GET['id']);
$imgp = "admin/files/projetos/" . trim($projeto->proimagem);
if (!file_exists($imgp) or ! is_file($imgp)):
    $imgp = 'admin/files/imagem/user.png';
endif;
?>
<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-9 columns" style="margin-top:-40px;">

            <section class="events-section">
                <h3>Projetos</h3>
                <article class="post group">
                    <header class="entry-top special-top">
                        <h1 class="entry-title page-title" style="text-align:center;">
                            <img src="admin/files/projetos/<?= $projeto->prologo ?>" width="60" alt="" /> &nbsp;&nbsp;
                            <?= $projeto->pronome ?></h1>
                        <ul class="cpt-meta">
                            <li>
                                <figure class="entry-thumb" style="text-align:center;">
                                    <img src="<?= $imgp ?>" alt="" />
                                </figure>
                            </li>
                            <li><span>Cidade:</span><?= $projeto->procidade ?></li>
                            <li><span>Esfera:</span><?= $projeto->proesfera ?></li>
                            <li><span>Secretaria:</span><?= $projeto->proorgao ?></li>
                            <li><span>Endereço:</span><?= $projeto->proendereco ?>, <?= $projeto->probairro ?></li>
                            <li><span>Complemento:</span> <?= $projeto->procomplemento ?></li>
                            <li><span>Responsável:</span><?= $projeto->proresponsavel ?></li>
                            <li><span>Contato:</span><?= $projeto->profone . " / " . $projeto->procelular ?></li>
                        </ul>
                        <h4 style="text-align: center">Sobre:</h4>
                        <p><?= $projeto->prosobre ?>  </p>    
                    </header>

                <?php
                $discos = new Read;
                $discos->ExeRead('disco', "WHERE procodigo = :procodigo", "procodigo={$projeto->procodigo}")
                ?>
                    <h4 style="text-align: center">Discos:</h4>
                <?php
                if (!empty($discos->getResult())): 
                    foreach ($discos->getResult() as $disco):
                     $disco =  new Disco($disco['discodigo']);
                        ?>
                      
                        <div class="large-3 columns sidebar sidebar-1">
                            <aside class="widget group" style="padding: 0px;">
                                <ol class="widget-list widget-list-single" >
                                    <li style="max-height: 180px; min-height:180px; margin: 0px;">
                                        <figure class="event-thumb">
                                            <a href="?p=album&id=<?= $disco->discodigo ?>">
                                                <img src="admin/files/discos/<?= $disco->disimagem ?>" alt="" />
                                                <div class="overlay icon-info-sign"></div>
                                            </a>
                                        </figure>
                                        <h4 class="list-subtitle" style="margin-bottom: 5px; letter-spacing: 0.2px;"><?= $disco->disnome ?></h4>
                                        <a href="?p=album&id=<?= $disco->discodigo ?>" class="action-btn">Veja o CD</a>
                                    </li>

                                </ol>
                            </aside><!-- /widget -->
                        </div>
                        <?php
                    endforeach;
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
                $cordenadas = explode(",", $projeto->procordenadas);
                $x = $cordenadas[0];
                $y = $cordenadas[1];
                ?>
                <script type="text/javascript">
                    var x = parseFloat("<?= $x ?>")
                    var y = parseFloat("<?= $y ?>")


                    var locations = [
                        ['<h2><?= $projeto->locnome ?></h2><h4><?= $projeto->locendereco ?>, <?= $projeto->locbairro ?></h4>', x, y],
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
                <h4 class="widget-title"><a href="?p=projetos">Projetos</a></h4>
                <ol class="widget-list">

                    <?php
                    $projetos = new Projetos();
                    foreach ($projetos->getResult() as $projeto):
                        $projeto = new Projetos($projeto['procodigo']);
                        ?>
                        <li>
                            <figure class="event-thumb">
                                <a href="?p=projeto&id=<?= $projeto->procodigo ?>">
                                    <img src="admin/files/projetos/<?= $projeto->proimagem ?>" alt="" />
                                    <div class="overlay icon-info-sign"></div>
                                </a>
                            </figure>
                            <h4 class="list-title"><a href="?p=projeto&id=<?= $projeto->procodigo ?>"><?= $projeto->pronome ?></a></h4>
                            <a href="?p=projeto&id=<?= $projeto->procodigo ?>" class="action-btn">Detalhes</a>
                        </li> 
                        <?php
                    endforeach;
                    ?>

                </ol>
            </aside><!-- /widget -->

        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
