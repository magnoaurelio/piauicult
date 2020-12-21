<aside class="widget group">
    <h3 class="widget-title">Dados do Artista</h3>
    <ol class="tracklisting tracklisting-top">
        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Endereço:</h5>
            <h4 class="track-title">&nbsp;<?= $artista->artendereco ?></h4>
        </li>
        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Bairro:</h5>
            <h4 class="track-title">&nbsp;<?= $artista->artbairro ?></h4>
        </li>
        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Cidade:</h5>
            <h4 class="track-title">&nbsp;
             <a href="?p=emissora&id=<?= $artista->artvinculo?>"> <?= $prenome?></a>
             <?= $artista->artcidade . "-" . $artista->artuf ?>
            </h4>
        </li>

        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Fone:</h5>
            <h4 class="track-title">&nbsp;<?= $artista->artfone ?></h4>
        </li>

        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Celular:</h5>
            <h4 class="track-title">&nbsp;<?= $artista->artcelular ?></h4>
        </li>

        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Email:</h5>
            <h4 class="track-meta">&nbsp;<?= $artista->artemail ?></h4>
        </li>

        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Site:</h5>
            <small style="max-width: 100%">&nbsp;<a  href="<?= $artista->artsite ?>" target="_blanck" ><?= $artista->artsite ?></a></small>
        </li>

        <li class="group track">
            <a class="fa fa-home"></a>
            <h5 class="track-meta">Data nascimento:</h5>
            <h4 class="track-title">&nbsp;Data: <?= DataCalendario::date2br($artista->artdatanasc) ?></h4>
        </li>

    </ol>
</aside><!-- /widget -->