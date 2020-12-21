
<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-8 columns">
            <?php
            $noticia = new Noticia($_GET['id']);
            
            $data = DataCalendario::date2us($noticia->notdata);
            $data = new DataCalendario($data);
            $imgp = "admin/files/noticias/" . trim($noticia->notfoto);
            if (!file_exists($imgp) or ! is_file($imgp)):
                $imgp = 'admin/files/imagem/user.png';
            endif;
            $artista = new Artista($noticia->artcodigo);
            //var_dump($artista);
            ?>

            <article class="post group" style="padding: 0px 20px 20px 20px;">
                <header class="entry-top">
                    <time datetime="<?= $noticia->notdata ?>"><?= $data->getDia() ?> <span><?= substr($data->getMes(), 0, 3) ?></span></time>
                    <h1 class="entry-title"><?= $noticia->nottitulo ?></h1>
                    <div class="entry-meta">					
                        Acesse o(s) Artista(s):
                       <?php
                        $artistas = $noticia->getArtistas();
                        $artistas_format = [];

                        foreach ($artistas as $artista):
                            $artista = new Artista($artista["artcodigo"]);
                            $artistas_format[] = "<a href='?p=artist&id={$artista->artcodigo}'>" . $artista->artusual . "</a>";
                        endforeach;
                        $artistas_format = implode(" <span>&bull;</span> ", $artistas_format);
                        echo $artistas_format;
                        ?>


                    </div>
                </header>	

                <figure class="entry-thumb">
                    <a data-rel='prettyPhoto[pp_gal]'  href="<?= $imgp ?>" >  <img  src="<?= $imgp ?>" alt="" /></a>
                </figure>

                <div class="entry-content">
                    <?= $noticia->notnoticia ?>
                </div>
                <?php if ($noticia->notfoto1): ?>
                    <div class="panel panel-default" style="float: left;width: 98%; margin: 0 auto;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Fotos Relacionadas</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table fotos-relacionadas">
                                <tr>
                                    <?php
                                    for ($i = 1; $i <= 6; $i++) {
                                        $var = 'notfoto' . $i;
                                        $file = "admin/files/noticias/{$noticia->$var}";
                                        if ($noticia->$var):
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
              <section class="widget group">
              
                <ol class="tracklisting tracklisting-top">
                    <?php
                    $notid = $_GET['id'];
                    $noticias = new Noticia(null,"WHERE notid <> $notid ORDER BY notid DESC LIMIT 5");
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
                                        <td style="width: 40%; margin-right: 5px;"> 
                                            <a href="?p=single&id=<?= $noticia->notid ?>">
                                                <figure class="entry-thumb" style="text-align:center;">
                                                    <img src="<?= $imgp ?>" alt="" />
                                                </figure>
                                            </a>
                                        </td>
                                        <td>
                                            <time class="list-subtitle" ><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                            <p class="list-title"><a href="?p=single&id=<?= $noticia->notid ?>"><?= $noticia->nottitulo ?></a></p>
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
        <div class="large-4 columns sidebar sidebar-4">
            <section class="widget group">
              
                <ol class="tracklisting tracklisting-top">
                    <?php
                    $notid = $_GET['id'];
                    $noticias = new Noticia(null,"WHERE notid <> $notid ORDER BY notid DESC LIMIT 10");
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
                                        <td style="width: 50%; margin-right: 5px;"> 
                                            <a href="?p=single&id=<?= $noticia->notid ?>">
                                                <figure class="entry-thumb" style="text-align:center;">
                                                    <img src="<?= $imgp ?>" alt="" />
                                                </figure>
                                            </a>
                                        </td>
                                        <td>
                                            <time class="list-subtitle" ><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                            <p class="list-title"><a href="?p=single&id=<?= $noticia->notid ?>"><?= $noticia->nottitulo ?></a></p>
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

    </div><!-- /main -->
</div><!-- /main-wrap -->
