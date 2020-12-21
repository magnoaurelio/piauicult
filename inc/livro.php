<?php

$livros = $artista->getLivros();
if ($livros) {
?>
<aside class="widget group">
    <h3 class="widget-title">Grupos</h3>
    <ol class="tracklisting tracklisting-top">
        <?php foreach ($livros as $livro) {
            $imgp = "admin/files/livros/" . trim($livro->livfoto);

            if (!file_exists($imgp) or ! is_file($imgp)):
                $imgp = 'admin/files/imagem/user.png';
            endif;
            ?>
            <li class="group track">
                <a href="?p=livro&id=<?= $livro->livcodigo ?>" class="">
                    <table width="100%" border="0">
                        <tr>
                            <td  width="65" align="left">
                                <img src="<?= $imgp ?>" width="50" style="max-height: 50px;" alt="" />
                            </td>
                            <td align="left">
                                <h5 class="track-title"><?= $livro->livnome ?></h5>
                            </td>

                        </tr>
                    </table>
                </a>
            </li>
        <?php }?>
    </ol>
</aside><!-- /widget --->
 <?php } ?>