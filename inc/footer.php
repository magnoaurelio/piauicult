 <?php include 'inc/link.php'; ?>
<div id="footer-wrap">
    <div class="row">
        <div class="large-12 columns">
            <footer class="row footer">
                <?php
                $rodapes = new Rodape();
                $total = $rodapes->getRowCount();
                if (!isset($_SESSION['footer'])) {
                    $R1 = 1;
                    $R2 = 4;
                    $_SESSION['footer'] = [$R1, $R2];
                } else {
                    $R1 = $_SESSION['footer'][0];
                    $R2 = $_SESSION['footer'][1];
                    $R3 = $R2 + 4;
                    $diferenca = $R3 - $total;
                    if ($diferenca > 0 && $diferenca >= 4):
                        $R1 = 1;
                        $R2 = 4;
                    elseif ($diferenca > 0):
                        $R1 += $diferenca;
                        $R2 += $diferenca;
                    else:
                        $R1 = $R2 + 1;
                        $R2 = $R3;
                    endif;
                    $_SESSION['footer'] = [$R1, $R2];
                }
                $filtro = "WHERE rodcodigo >= {$R1} and rodcodigo <= {$R2}  limit 4 ";
                $rodapes = new Rodape(null, $filtro);
                foreach ($rodapes->getResult() as $rodape):
                    ?>
                    <div class="large-3 columns">
                        <aside class="widget group">
                            <h3 class="widget-title"><?= $rodape['rodtitulo'] ?></h3>
                            <div class="widget-content">
                                <img src="admin/files/rodape/<?= $rodape['rodimagem'] ?>" class="alignleft"  width="60" height="60" alt="about me">
                                <p><?= $rodape['rodtexto'] ?></p>
                            </div>
                        </aside><!-- /widget -->
                    </div>

                <?php endforeach; ?>
            </footer><!-- /footer -->
        </div><!-- /large-12 -->
    </div><!-- /row -->
</div><!-- /footer-wrap -->

<div id="credits-wrap">
    <div class="row">
        <div class="large-12 columns">
            <div class="row credits">
                <div class="large-12 columns">
                    <?php $date = date("Y") ?>
                    &copy; Todos os Direitos Reservados 2017 - <?= $date ?> | &nbsp;

                    <a href="http://www.magnusoft.com.br/" title="MAGNUSOFT desenvolvimento">MAGNUSOFT desenvolvimento</a>
                    <span style="float:right">
                        <a href="?p=sobre" style="height: 25px; display: inline-block" class="action-btn">Sobre</a>
                        <a target="_blank" href="admin/"><img src="images/lock.png" width="25" height="25"></a>
                    </span>
                </div>				
            </div><!-- /row -->
        </div><!-- /large-12 -->
    </div><!-- /row -->
</div><!-- /credits-wrap -->

<script>
    function Topo() {
        $('body').scrollTop(200);
        return false;
    }
    $(".media-btn").click(function (e) {
        $.ajax({
            dataType: "json",
            url: "admin/api.php?method=setMusicaTocada",
            data: {muscodigo: this.id},
            success: function (data) {

            }
        });
    })
    $(document).ready(function (e) {


        var page = "<?= $_GET['p'] ?>"

        if (page == "album") {
            var disco = "<?= $_GET['id'] ?>"
            $.ajax({
                dataType: "json",
                url: "admin/api.php?method=setDiscoAcesso",
                data: {discodigo: disco},
                success: function (data) {
                }
            });
        }

        if (page == "artist") {
            var artista = "<?= $_GET['id'] ?>"
            $.ajax({
                dataType: "json",
                url: "admin/api.php?method=setArtistaAcesso",
                data: {artcodigo: artista},
                success: function (data) {
                }
            });
        }
    })

</script>