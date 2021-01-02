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
                        <li><span>Acessório 1:</span><?= $instrumento->insassessorio1 ?></li>
                        <li><span>Acessório 2:</span><?= $instrumento->insassessorio2 ?></li>
                        <li><span>Acessório 3:</span><?= $instrumento->insassessorio3 ?></li>
                    </ul>
                </header>
                  <div class="large-12 columns" >
                     <article class="post group">   
                           <header class="entry-top special-top"> 
                                <article class="post group" >
                                <h4>Sobre o Instrumento:<a href="?p=artista-genero&id=<?=$gencodigo ?>" title="Voltar Página Gênero"> <?=$instrumento->insnome ?></a> </h4>
                                <div class="entry-content">
                                    <div class="row">
                                      <div class="large-8 columns"></div>
                                    <?= $instrumento->inshistorico?> 
                                    </div>
                                </div>
                               </article>
                           </header>
                       </article>
            </div>

                <?php
                $artistas = $instrumento->getMusicos();
                ?>
                <div class="entry-content">
                 <h4>Artistas do Instrumento:<a href="?p=artista-genero&id=<?=$gencodigo ?>" title="Voltar Página Gênero"> <?=$instrumento->insnome ?></a> </h4>
			
                        
                                <ul class="list row">
                                    <?php
                                    if ($artistas):
                                        foreach ($artistas as $artista):
                                            $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                                            if (!file_exists($imgp) or ! is_file($imgp)):
                                                $imgp = 'admin/app/images/user.png';
                                            endif;
                                    ?>
                                    <li class="large-3 columns">
                                        <div class="li-content">
                                            <figure class="event-thumb">
                                                <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="Veja mais sobre: <?=$artista->artusual ?>">
                                                            <img src=" <?=$imgp ?>" alt="" />
                                                            <div class="overlay icon-info"></div>
                                                    </a>			
                                            </figure>
                                            <h4 class="list-title">
                                                <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="Veja mais sobre: <?=$artista->artusual ?>">
                                               <?=$artista->artusual ?>
                                                </a>
                                            </h4>
                                            <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="Veja mais sobre: <?=$artista->artusual ?>" class="action-btn">Veja mais...</a>
                                        </div>

                                    </li>
                               
                                <?php
                            endforeach;
                        endif;
                        ?>
                         </ul>
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
