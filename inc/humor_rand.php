
<aside class="widget group">
    <?php
    $humors = new Read();
    $humors->ExeRead("humor", "ORDER BY rand() limit 3");
    //"WHERE arttipocodigo = 5", "ORDER BY rand limit 1"
    ?>

    <h4 class="widget-title"><a href="?p=festivais-humor">Humor</a></h4>
    <ol class="widget-list widget-list-single">

        <?php

        foreach ($humors->getResult() as $humor):
            $humor = new Humor($humor["humcodigo"]);
            $paginaLivro =  $humor->getPagina();
            $livro = $paginaLivro->getLivro();
            $artista = $humor->getArtista();

            $premio = new FestivalPremio($humor->fesprecodigo);
            $fesprenome = $premio->fesprenome;
            $fesprefoto = "admin/files/festivais/" . $premio->fesprefoto;

            ?>
            <li>
                <figure class="event-thumb">
                    <a target="_blank" href="livro.php?livcodigo=<?=$paginaLivro->livcodigo ?>#page/<?= $paginaLivro->numero ?>">
                        <img src="admin/files/livros/paginas/<?= $humor->humarquivo ?>" alt=""/>
                        <div class="overlay icon-info-sign"></div>
                    </a>
                </figure>
           
           
                <img src="<?= $fesprefoto ?>"width="40"/> <?=trim($fesprenome) ?> 
            
            
                <h5 class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.05px; font-size: 16px !important; font-weight: 600 !important;">
                    <a target="_blank" href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                       title="Ir para o Catalogo:  <?= $humor->humnome ?> ">
                        <?= $humor->humnome ?><br>
                    </a>
                    <a target="_blank" href="livro.php?livcodigo=<?= $livro->livcodigo ?>#page/<?= $paginaLivro->numero ?>"
                       title="Ir para o Catalogo:  <?= $humor->humnome ?> ">
                        <small style="color: red; font-size: 16px; font-weight: 400"><?= $humor->getCategoria()->descricao ?></small>
                    </a>
                    <a href="?p=artista-humor&id=<?= $artista->artcodigo ?>" class="" title="<?= $artista->artusual ?>">
                        <img src="admin/files/artistas/<?= $artista->artfoto ?>" width="50" alt=""/><?= $artista->artusual ?>-<?= $artista->artuf?>
                    </a>

                </h5>
                <? //$date =  date($disco['disdata'],'d-m-Y');

                ?>
            </li>
            <?php
        endforeach;
        ?>

    </ol>
</aside>