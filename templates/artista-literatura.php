<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-12 columns">

            <article class="post group">
                <?php
                $artista = new Artista($_GET['id']);
                $imgp = "admin/files/artistas/" . trim($artista->artfoto);

                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>

                <style>
                    .texted span{
                        margin-right: 5px;
                        font-weight: bold;
                     //   font-weight: 500 bold;
                        font-family: sans-serif;
                        font-style: 12 normal;
                      //  $artusual = strtoupper();
                    }
                </style>

                <header class="entry-top special-top">
                    <h1 class="entry-title page-title">A Arte de <a href="#"><?=  $artista->artusual ?>.</a> Literatura</h1>
                </header>
                <div class="entry-content row">
                    <div class="large-9 columns">
                        <br><br>
                        <ul  style="list-style: none">
                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Nome: <span><?= $artista->artnome ?></span></p>
                            </li>
                            <li >
                                <a class="fa fa-home"></a>
                                <p class="texted">Usual: <span><?= $artista->artusual ?></span></p>
                            </li>
                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Endereço: <span><?= $artista->artendereco ?></span></p>
                            </li>
                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Bairro: <span><?= $artista->artbairro ?></span></p>
                            </li>
                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Cidade: <span><?= $artista->artcidade . "-" . $artista->artuf ?></span></p>
                            </li>

                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Fone: <span><?= $artista->artfone ?></span></p>
                            </li>

                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Celular: <span><?= $artista->artcelular ?></span></p>
                            </li>

                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Email: <span><?= $artista->artemail ?></span></p>
                            </li>

                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Site: <span><a  href="<?= $artista->artsite ?>" target="_blanck" ><?= $artista->artsite ?></a></span></p>
                            </li>

                            <li>
                                <a class="fa fa-home"></a>
                                <p class="texted">Aniversário: <span><?= DataCalendario::date2br($artista->artdatanasc) ?></span></p>
                            </li>

                            <li >
                                <a class="fa fa-home"></a>
                                <h4 class="texted"><span><a href="#">Sobre:</a></span><?=$artista->artbiografia ?></h4>
                            </li>

                        </ul>
                    </div>
                    <div class="large-3 columns sidebar sidebar-1">
                        <aside class="widget group">
                            <ol class="widget-list widget-list-single">
                                <li>
                                    <figure class="event-thumb">
                                        <a href="<?= $imgp ?>" data-rel="prettyPhoto">
                                            <img src="<?= $imgp ?>"/>
                                            <div class="overlay icon-zoom-in"></div>
                                        </a>
                                    </figure>
                                </li>
                            </ol>
                        </aside><!-- /widget -->
    <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    <?php 
                        $gal = new Read();
                        $gal->ExeRead("galeria", "WHERE galartista = :id limit 1", "id=".$_GET['id']);
                        
                        if ($gal->getResult()) {
                            
                         $galeria = $gal->getResult()[0];   
                    ?>
                    
                    <li>
                        <figure class="event-thumb">
                            <a href="?p=gallery&tipo=1&id=<?= $artista->artcodigo ?>">
                                <img src="admin/files/galeria/<?=$galeria['galarquivo']?>" />
                                <div class="overlay icon-camera"></div>								
                            </a>
                        </figure>
                        <h5 class="list-subtitle">Galeria de Fotos</h5>
                    </li>
                    
                    <?php } else {?>
                    <li>
                        <figure class="event-thumb">
                            <a href="?p=gallery&tipo=1&id=<?= $artista->artcodigo ?>">
                                <img src="images/galeria.png" />
                                <div class="overlay icon-camera"></div>								
                            </a>
                        </figure>
                        <h5 class="list-subtitle">Galeria de Fotos</h5>
                    </li>
                    <?php }?>
                </ol>
        <br/>
          <?php 
          $bandas = $artista->getBandas();
            if ($bandas) {
            ?>
            <aside class="widget group">
                <h3 class="widget-title">Grupos</h3>
                <ol class="tracklisting tracklisting-top">
                    <?php foreach ($bandas as $banda) {
                        $imgp = "admin/files/bandas/" . trim($banda->banfoto1);

                        if (!file_exists($imgp) or ! is_file($imgp)):
                            $imgp = 'admin/files/imagem/user.png';
                        endif;
                        ?>
                        <li class="group track">
                            <a href="?p=banda&id=<?= $banda->bancodigo ?>" class="">
                                <table width="100%" border="0">
                                    <tr>
                                        <td  width="65" align="left">
                                            <img src="<?= $imgp ?>" width="50" style="max-height: 50px; margin-left:- 15px;" alt="" />
                                        </td>
                                        <td align="left">
                                            <h5 class="track-title"><?= $banda->bannome ?></h5>
                                        </td>

                                    </tr>
                                </table>
                            </a>
                        </li>
                    <?php }?>
                </ol>
            </aside><!-- /widget --->

            <?php } ?>
                        
                    </div>
                    
                </div>
            </article>

            <article class="post group" style="margin-top:-20px;">
                <?php
                $festival = new Festival();
                $festivais = $festival->getFestivaisLiteratura();
                $fesmostra = $festival->fesmostra;
                $festivaisQueArtistaParticipa = [];
                ?>
                <h3 style="margin-left: 25px;"><a href="#">Festivais</a></h3>
                <?php
                if ($festivais):
                    foreach ($festivais as $festival):
                        $festivalObject = (object)$festival;
                        $festivalObject = new Festival($festivalObject->fescodigo);
                        $artistas = $festivalObject->getArtistas();
                        $participei = false;
                        foreach ($artistas as $artist){

                            if($artist['artcodigo'] == $artista->artcodigo) {
                                $participei = true;
                                break;
                            }
                        }
                        if (!$participei) continue;

                        $festivaisQueArtistaParticipa[$festivalObject->fescodigo] =  $festivalObject->fescodigo;

                        ?>

                        <div class="large-2 columns sidebar sidebar-1">
                            <aside class="widget group" style="padding: 0px;  margin-bottom: 10px;">
                                <ol class="widget-list widget-list-single" > <!--tracklisting tracklisting-top- numeração-->

                                    <li  style="max-height: 200px; min-height: 220px; margin: 0px;">

                                        <table width="100%" border="0">
                                            <tr>
                                                <td  width="65">
                                                    <a href="?p=festival-literatura&id=<?= $festivalObject->fescodigo; ?>" class="" title="<?= $festivalObject->fesnome; ?>"><img src="admin/files/festivais/<?=trim($festivalObject->fesimagem);?>" width="100" alt="" /></a>
                                                </td>

                                            </tr>
                                        </table>
                                        <p style="font-size:14px; margin-top: 0; padding: 0;" class="track-title"><a href="?p=festival-literatura&id=<?= $festivalObject->fescodigo; ?>"><?= $festivalObject->fesnome; ?></a></p>
                                        <small>Tema:</small> <strong><?= $festivalObject->festema ?></strong> - <strong><?= trim($festivalObject->fesperiodo)?></strong>


                                    </li>
                                </ol>


                            </aside>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </article>

            <article class="post group" style="margin-top:-20px;">
                    <div class="entry-content">
                        <h3>Catálogo de Literatura de <a href="#"><?= $artista->artusual ?></a></h3>
                        <?php if ($festivaisQueArtistaParticipa): ?>
                        <table style="width: 100%">
                            <?php foreach ($festivaisQueArtistaParticipa as $litcodigo):
                                $festival = new Festival($litcodigo);
                                $literaturas = $festival->getLiteratura();
                                ?>
                                <tr>
                                    <td style="width:10%;">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td  width="65">
                                                    <a href="?p=festival-detalhe&id=<?= $festival->fescodigo; ?>" class="" title="<?= $festival->fesnome; ?>"><img src="admin/files/festivais/<?=trim($festival->fesimagem);?>" width="100" alt="" /></a>
                                                </td>

                                            </tr>
                                        </table>
                                        <p style="font-size:14px; margin-top: 0; padding: 0;" class="track-title"><a href="?p=festival-detalhe&id=<?= $festival->fescodigo; ?>"><?= $festival->fesnome; ?></a></p>
                                        <small>Tema:</small> <strong><?= $festival->festema ?></strong> - <strong><?= trim($festival->fesperiodo)?></strong>
                                    </td>
                                    <td>
                                        <ol class="tracklisting">
                                            <?php
                                            if ($literaturas):
                                                foreach ($literaturas as $literatura):
                                                    $literatura = new Literatura($literatura["litcodigo"]);
                                                    $paginaLivro = $literatura->getPagina();
                                                    $livro = $paginaLivro->getLivro();
                                                    $litfoto = "admin/files/literatura/paginas/" . trim($literatura->litarquivo);
                                                    $artistaLiteratura = $literatura->getArtista();
                                                    if ($artistaLiteratura->artcodigo != $artista->artcodigo) continue;

                                                    $premio = new FestivalPremio($literatura->fesprecodigo);
                                                    $fesprenome = $premio->fesprenome;
                                                    $fesprefoto = "admin/files/festivais/".$premio->fesprefoto;

                                                    // var_dump($fesmostra);
                                                    ?>
                                                    <li class="large-3 columns"style="margin-top:5px; padding-left: 0px; text-align: center; max-height: 380px; min-height: 350px;" >
                                                        <a target="_blank" href="livro.php?livcodigo=<?=$livro->livcodigo?>#page/<?=$paginaLivro->numero?>"  title="Ir para o Catalogo:  <?= $literatura->litnome ?> ">
                                                            <img src="<?= $litfoto ?>" width="200"/><br>
                                                            <img src="<?= $fesprefoto ?>" width="30"/> <?= $fesprenome?>

                                                        </a>
                                                        <h5 class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                                                            <a target="_blank" href="livro.php?livcodigo=<?=$livro->livcodigo?>#page/<?=$paginaLivro->numero?>"  title="Ir para o Humor:  <?= $literatura->litnome ?> ">
                                                                <?= $literatura->litnome?>
                                                            </a> <br>
                                                            <a target="_blank" href="livro.php?livcodigo=<?=$livro->livcodigo?>#page/<?=$paginaLivro->numero?>"   title="Ir para o Literatura:  <?= $literatura->litnome ?> ">
                                                                <small style="color: red; font-size: 16px; font-weight: 400"><?= $literatura->getCategoria()->litnome?></small>
                                                            </a>
                                                        </h5>
                                                    </li>

                                                    <?php
                                                endforeach;
                                            endif;
                                            //       endforeach;
                                            //     endif;
                                            ?>

                                        </ol>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                        </table>
                        <?php endif;?>
                    </div>
            </article>

        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    function BuscaID(str, id) {
        var pos1 = str.search("users/");
        var pos2 = str.search("&amp;");
        var codigo = str.substring(pos1 + 6, pos2)
        $("#" + id).val(codigo)
    }
</script>