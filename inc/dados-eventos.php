<section class="events-section events-upcoming">
    <h3>Eventos</h3>
    <ol class="widget-list">
        <?php
        $eventos = new Evento(NULL,"ORDER BY evedata DESC");
        if ($eventos->getResult()):

            foreach ($eventos->getResult() as $evento):
                $evento = new Evento($evento['evecodigo']);
                $data = $evento->evedata;
                $data = new DataCalendario($data);
                $imgp = "admin/files/eventos/" . trim($evento->eveimagem1);
                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>
                <li>
                    <table>
                        <tr>
                            <td style="width: 30%; margin-right: 5px;"> 
                                <a href="?p=event&id=<?= $evento->evecodigo ?>">
                                    <figure class="entry-thumb" style="text-align:center;">
                                        <img src="<?= $imgp ?>" alt="" />
                                    </figure>
                                </a>
                            </td>
                            <td>
                                <time class="list-subtitle" ><?= $data->getDia() . " " . substr($data->getMes(), 0, 3) . " " . $data->getAno() ?> </time>
                                <h5 class="list-title"><a href="?p=event&id=<?= $evento->evecodigo ?>"><?= $evento->evenome ?></a></h5>
                                <a href="?p=event&id=<?= $evento->evecodigo ?>" class="action-btn">Mais detalhes ...</a>  
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
