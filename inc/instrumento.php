<aside class="widget group">

<?php
$instrumentos = $artista->getInstrumentos();
?>
<h3 class="widget-title">Instrumentos</h3>
<ol class="tracklisting tracklisting-top">
    <?php
    if ($instrumentos):
        foreach ($instrumentos as $instrumento):
            $imgp = "admin/files/instrumento/" . trim($instrumento->insfoto);
            if (!file_exists($imgp) or ! is_file($imgp)):
                $imgp = 'admin/app/images/instrumento.png';
            endif;
            ?>
            <li class="group track">
                <a href="?p=instrumentistas&id=<?= $instrumento->inscodigo ?>" class="">
                    <table width="100%" border="0">
                        <tr>
                            <td  width="65" align="left"> 
                                <img src="<?= $imgp ?>" width="50" style="max-height: 50px;" alt="" />
                            </td>
                            <td align="left">
                                <h5 class="track-title"><?= $instrumento->insnome ?></h5>
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
</aside>
