
<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-6 columns">
             <section class="events-section events-upcoming">
                <h3>Apresentações</h3>
                <style>
                    .list-subtitle{
                        letter-spacing: 1px;
                    }
                    table:hover  .list-title, .list-subtitle{
                       color:#0085CC;
                    }
                </style>
                 <aside class="widget group">
                <ol class="tracklisting tracklisting-top">
                <!--ol class="widget-list"-->
                    <?php
                    $videos = new Read();
                    $videos->ExeRead("videos", "WHERE vidtipo = 3 and vidliberado = 1");
                    if ($videos->getResult()):

                        foreach ($videos->getResult() as $video):
                            $data = new DataCalendario($video['vidpublica']);
                            $artista = new Artista($video['artcodigo']);
                            $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                            $foto = "admin/files/video/" . trim($video['vidfoto']);
                           // var_dump($video['vidpublica']);
                            if (!file_exists($imgp) or ! is_file($imgp)):
                                $imgp = 'admin/files/images/user.png';
                            endif;
                             if (!file_exists($foto) or ! is_file($foto)):
                                $foto = 'admin/files/video/video.jpg';
                            endif;
                            ?>
                            <li>
                                    <a href="?p=artist&id=<?=$artista->artcodigo?>"><h5 class="list-title"><?= $artista->artusual ?></h5></a>
                                    <a href="<?= $video['vidurl'] ?>" data-rel="prettyPhoto">
                                   
                                    <table>
                                        <tr>
                                            <td style="padding-right:10px;">
                                                <img src="<?= $imgp ?>" width="90" alt="" />
                                            </td>
                                             <td style="padding-right:10px;">
                                                 <img src="<?= $foto ?>" width="100" alt="" />
                                            </td>
                                            
                                         
                                            <td>
                                                <time><?= date( 'd/m/Y', strtotime($video['vidpublica']))?></time>
                                                <!--time class="list-subtitle" style="color: #fff;"><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time-->
                                                <p class="list-subtitle" style="font-weight: 400 "> <?= $video['viddescricao'] ?></p>
                                            </td>

                                          
                                        </tr>                           
                                    </table>
                               </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                <!--/ol-->
                </ol>
                </aside>
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
             <!-- ** artistas-->
            <?php include 'inc/artistas_poeta_rand.php' ?>
        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
