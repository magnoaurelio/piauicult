
<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-6 columns">
            <section class="events-section events-upcoming">
                <h3>Eventos</h3>
                <ol class="widget-list">
                    <?php
                    $eventos = new Evento();
                    if ($eventos->getResult()):

                        foreach ($eventos->getResult() as $evento):
                            $evento = new Evento($evento['evecodigo']);
                            $data = $evento->evedata;
                            $data = new DataCalendario($data);
                            $imgp = "admin/files/eventos/" . trim($evento->eveimagem1);
                            if (!file_exists($imgp) or ! is_file($imgp)):
                                $imgp = 'admin/files/imagem/user.png';
                            endif;
                            ?>
                            <li>
                                <table>
                                    <tr>
                                        <td style="width: 15%; margin-right: 5px;"> 
                                            <a href="?p=event&id=<?= $evento->evecodigo ?>">
                                                <figure class="entry-thumb" style="text-align:center;">
                                                    <img src="<?= $imgp ?>" alt="" />
                                                </figure>
                                            </a>
                                        </td>
                                        <td>
                                            <time class="list-subtitle" ><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                            <h4 class="list-title"><a href="?p=event&id=<?= $evento->evecodigo ?>"><?= $evento->evenome ?></a></h4>
                                            <a href="?p=event&id=<?= $evento->evecodigo ?>" class="action-btn">Mais detalhes ...</a>  
                                        </td>
                                    </tr>                           
                                </table>

                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ol>
            </section>



        </div>
        <div class="large-3 columns sidebar sidebar-1">

            <?php include 'inc/artistas_compositor_rand.php' ?>
            <!----------------------------
            ** artistas-->
             <?php include 'inc/artistas_produtor_rand.php' ?>
            <!----------------------------
            ** artistas-->
            <?php include 'inc/artistas_arranjador_rand.php' ?>
            <!---------------------------->
           

        </div>
        <div class="large-3 columns sidebar sidebar-2">
            <?php include 'inc/artistas_cantor_rand.php' ?>
            
            <?php include 'inc/artistas_grupo_rand.php' ?>
            
            <!-- ** artistas-->
            <?php include 'inc/artistas_musico_rand.php' ?>
        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
>>