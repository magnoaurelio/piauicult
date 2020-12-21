<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-6 columns">
            <section class="events-section events-upcoming">
                <h3>Notícias</h3>
                <ol class="widget-list">
                    <?php
                    $noticias = new Noticia(null,"ORDER BY notid DESC");
                    if ($noticias->getResult()):

                        foreach ($noticias->getResult() as $noticia):
                            $noticia = new Noticia($noticia['notid']);
                            $data = DataCalendario::date2us($noticia->notdata);
                            $data = new DataCalendario($data);
                            $imgp = "admin/files/noticias/" . trim($noticia->notfoto);
                            if (!file_exists($imgp) or ! is_file($imgp)):
                                $imgp = 'admin/files/imagem/user.png';
                            endif;
                            ?>
                            <li>
                                <table>
                                    <tr>
                                        <td style="width: 25%; margin-right: 5px;"> 
                                            <a href="?p=single&id=<?= $noticia->notid ?>">
                                                <figure class="entry-thumb" style="text-align:center;">
                                                    <img src="<?= $imgp ?>" alt="" />
                                                </figure>
                                            </a>
                                        </td>
                                        <td>
                                            <time class="list-subtitle" ><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                            <h4 class="list-title"><a href="?p=single&id=<?= $noticia->notid ?>"><?= $noticia->nottitulo ?></a></h4>
                                            <a href="?p=single&id=<?= $noticia->notid ?>" class="action-btn">Mais detalhes ...</a>  
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
              <?php include 'inc/projeto_rand.php' ?>
           

        </div>
        <div class="large-3 columns sidebar sidebar-2">
            <?php include 'inc/artistas_cantor_rand.php' ?>
            
            <?php include 'inc/artistas_grupo_rand.php' ?>
            
            <!-- ** artistas-->
            <?php include 'inc/artistas_musico_rand.php' ?>
            
              <?php include 'inc/artistas_grupo_rand.php' ?>
        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
