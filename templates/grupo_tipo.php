<?php
$bantipo = new BandaTipo($_GET['id']);
$bantipofoto = "admin/files/banda_tipo/" . trim($bantipo->bantipofoto);
if (!file_exists($bantipofoto) or ! is_file($bantipofoto)):
    $bantipofoto = 'admin/files/images/banda.png';
endif;
?>

<div id="main-wrap" style="padding-top: 20px">
    <div id="main" class="row">
        <div class="large-9 columns">

            <article class="post group">

                <header class="entry-top special-top">
                    <h1 class="entry-title page-title"><?= $bantipo->bantiponome ?></h1>
                </header>	

                <?php
                $bandas = $bantipo->getBandasTipoOrdem();
                ?>
                <div class="entry-content">
                    <h3>Bandas deste Tipo Musical</h3>				
                    <ol class="tracklisting">
                        <?php
                        if ($bandas):
                            foreach ($bandas as $banda):
                                $imgp = "admin/files/bandas/" . trim($bandas->banfoto);
                                if (!file_exists($imgp) or ! is_file($imgp)):
                                    $imgp = 'admin/app/images/user.png';
                                endif;
                                ?>
                                <li class="group track">
                                    <a href="?p=banda&id=<?= $bandas->bantipocodigo ?>" class="">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td  width="65"> 
                                                    <img src="<?= $imgp ?>" width="60" alt="" />
                                                </td>
                                                <td align="left">
                                                    <h4><?= $bandas->banusual ?></h4>
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
                            <a href="<?= $bantipofoto ?>" data-rel="prettyPhoto">
                                <img src="<?= $bantipofoto ?>" />
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
