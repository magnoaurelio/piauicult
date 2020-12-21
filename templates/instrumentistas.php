<?php
$instrumento = new Instrumento($_GET['id']);
$insfoto = "admin/files/instrumento/" . trim($instrumento->insfoto);
if (!file_exists($insfoto) or ! is_file($insfoto)):
    $insfoto = 'admin/files/images/instrumento.png';
endif;
?>

<div id="main-wrap" style="padding-top: 100px">
    <div id="main" class="row">
        <div class="large-9 columns">

            <article class="post group">

                <header class="entry-top special-top">
                    <h1 class="entry-title page-title"> <img src="<?= $insfoto ?>" width="80" height="80" /><?= $instrumento->insnome ?></h1>
                    <ul class="cpt-meta">
                        <li><span>Histórico. :</span><?= $instrumento->inshistorico?></li>
                        <li><span>Acessório 1:</span><?= $instrumento->insassessorio1 ?></li>
                        <li><span>Acessório 2:</span><?= $instrumento->insassessorio2 ?></li>
                        <li><span>Acessório 3:</span><?= $instrumento->insassessorio3 ?></li>
                      

                    </ul>
                </header>	

                <?php
                $artitas = $instrumento->getMusicos();
                ?>
                <div class="entry-content">
                    <h3>Artistas deste instrumento</h3>				
                    <ol class="tracklisting">
                        <?php
                        if ($artitas):
                            foreach ($artitas as $artista):
                                $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/app/images/user.png';
                                endif;
                                ?>
                                <li class="group track">
                                    <a href="?p=artist&id=<?= $artista->artcodigo ?>" class="">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td  width="65"> 
                                                    <img src="<?= $imgp ?>" width="60" alt="" />
                                                </td>
                                                <td align="left">
                                                    <h4><?= $artista->artusual ?></h4>
                                                </td>

                                            </tr>
                                        </table>
                                    </a>
                                </li>
                                <?php
                            endforeach;
                        endif;
                        ?>

                    </ol>

                </div>


            </article><!-- /post -->

        </div>
        <div class="large-3 columns sidebar sidebar-1">
            <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $insfoto ?>" data-rel="prettyPhoto">
                                <img src="<?= $insfoto ?>" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                        </figure>
                        <h5 class="list-subtitle">Clique &nbsp; para  &nbsp;  ampliar</h5>
                    </li>
                </ol>

            </aside><!-- /widget -->


        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
