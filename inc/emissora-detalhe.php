<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-9 columns">

            <article class="post group">
                <?php
                $emissora = new Emissora($_GET['id']);
                $imgp = "admin/files/emissoras/" . trim($emissora->emifoto);

                if (!file_exists($imgp) or ! is_file($imgp)):
                    $imgp = 'admin/files/imagem/user.png';
                endif;
                ?>
                <header class="entry-top special-top">
                    <h1 class="entry-title page-title">Emissora (<?= $emissora->eminome ?>).</h1>
                </header>
                <div class="entry-content">
                <ul class="cpt-meta">
                    <p>Estado: <strong><?=$emissora->emiestado?></strong></p>
                    <p>Cidade:<strong> <?=$emissora->emicidade?></strong></p>
                    <p>Endereço:<strong> <?=$emissora->emiendereco?></strong></p>
                    <p>Bairro: <strong><?=$emissora->emibairro?></strong></p>
                    <p>Cep:<strong> <?=$emissora->emicep?></strong></p>
                    <p>Contato:<strong> <?=$emissora->emicontato?></strong></p>
                    <p>Email: <strong> <?=$emissora->emiemail?></strong></p>
                    <p>Site: <strong><a  href="<?=$emissora->emisite?>" target="_blanck" ><?=$emissora->emisite?></a></strong></p>
                </u>
                    <p><h3>Sobre</h3> <?=$emissora->emisobre?></p>
                    <h3>Programações</h3>
                    <ol class="tracklisting">
                        <?php
                         $programacoes =  new Read();
                         $programacoes->ExeRead("programacao","WHERE emicodigo = :cod", "cod={$emissora->emicodigo}");
                         if($programacoes->getResult()) {
                             foreach ($programacoes->getResult() as $programacao){
                             ?>
                             <li class="group track">
                               <a href="?p=emissora" id="" class="media-btn">Play programação</a>
                                <h4 class="track-title"><?= DataCalendario::date2br($programacao['dataplay']) ?></h4><br/>
                             </li>
                             <?php
                          }
                        }
                        ?>
                    </ol>
            </article>



        </div>
        <div class="large-3 columns sidebar sidebar-1">
            <aside class="widget group">
                <ol class="widget-list widget-list-single">
                    <li>
                        <figure class="event-thumb">
                            <a href="<?= $imgp ?>" data-rel="prettyPhoto">
                                <img src="<?= $imgp ?>" />
                                <div class="overlay icon-zoom-in"></div>								
                            </a>
                        </figure>
                                <h5 class="list-subtitle"><?= $emissora->eminome ?></h5>

                    </li>
                </ol>
            </aside><!-- /widget -->


        </div>
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    function BuscaID(str,id) {
      var pos1 = str.search("users/");
      var pos2 = str.search("&amp;");
      var codigo = str.substring(pos1+6,pos2)
      $("#"+id).val(codigo)
    }
</script>