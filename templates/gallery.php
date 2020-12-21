<div id="main-wrap" style="margin-top: -5px;">
    <div id="main" class="row">
        <?php
        $read = new Read;
        if (!isset($_GET['tipo']) or ! isset($_GET['id'])):
            echo "<script>top.location.href='?p=videos'</script>";
        endif;

        $tipo = $_GET['tipo'];
        $id = $_GET['id'];

        if ($tipo == 1):
            $read->ExeRead("galeria", "WHERE galartista = :id", "id={$id}");
            $artista = new Artista($id);
            echo "<h3>Galeria de fotos do artista &bull; <a href='?p=artist&id={$artista->artcodigo}'>{$artista->artusual}</a></h3>";
        else:
            $read->ExeRead("galeria", "WHERE galdisco = :id", "id={$id}");
            $disco = new Disco($id);
            echo "<h3>Galeria de fotos do disco &bull; <a href='?p=album&id={$disco->discodigo}'>{$disco->disnome}</a></h3>";
        endif
        ?>
        <div class="large-12 columns">
            <ul class="list row">

                <?php
                if (!empty($read->getResult())):
                    foreach ($read->getResult() as $galeria):
                        ?>    
                        <li class="large-3 columns">
                            <div class="li-content" >
                                <figure class="event-thumb" style="max-height: 250px;">
                                    <a href="admin/files/galeria/<?=$galeria['galarquivo']?>" data-rel="prettyPhoto[pp_gal]">
                                        <img src="admin/files/galeria/<?=$galeria['galarquivo']?>" style="max-height: 220px;" width="100%" alt="" />
                                        <div class="overlay icon-zoom-in"></div>
                                    </a>			
                                </figure>
                                  <h5 class="list-subtitle"><?=$galeria['galcaption']?></h5>
                            </div>
                        </li>
                        <?php
                    endforeach;
                endif;
                ?>
            </ul>

        </div><!-- /large-12 -->
    </div><!-- /main -->
</div><!-- /main-wrap -->
