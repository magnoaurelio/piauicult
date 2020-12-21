<?php
$api = new Api();
$filterAmpar = new Filter("precodigo","<=", 224);
$prefeituraService = new PrefeituraService($api->getPrefeitura([$filterAmpar->getValue()]));
?>
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns">
            <div class="row">
            <article class="post group">
                <header class="entry-top special-top">
                    <div class="large-3 columns" style="margin-top:3px;">
                        <select class="form-control selecao" onchange="selectCidade(this.value)">
                            <option value="0">Selecione uma Cidade</option>
                            <?php
                            foreach ($prefeituraService->getPrefeituras() as $prefeitura) {
                                $selected = isset($_GET['id']) && $_GET['id'] == $prefeitura->precodigo ? 'selected=selected' : "";
                                echo "<option {$selected} value={$prefeitura->precodigo}>{$prefeitura->prenome}</option>";
                            }
                            ?>
                        </select>

                        <script>
                            function selectCidade(precodigo) {
                                top.location.href = "?p=projetos&id="+ precodigo
                            }
                        </script>
                    </div>
                    <h1 class="entry-title page-title" style="margin-top:5px;">
                        <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                        <a href="?p=artist&id=<?= $artista->artcodigo ?>"><a href="#">Projetos</a></a>
                    </h1>

                </header>
            </article>
     
           
         <article class="post group" style="margin-top:-30px;">
             <ul class="list row" style="margin-left: 0px;  margin-right: 0px;">
            <!--section class="events-section events-upcoming">
                <ol class="widget-list"-->
                     
                    <?php
                    $cont  = 0;
                    $criterio =  isset($_GET["id"]) ? " WHERE (`procidade` * 1) = {$_GET['id']} " : null;
                    $projetos = new Projetos(null, $criterio);
                    if ($projetos->getResult()):

                        foreach ($projetos->getResult() as $projeto):
                            $projeto = new Projetos($projeto['procodigo']);
                            $imgp = "admin/files/projetos/" . trim($projeto->proimagem);
                            if (!file_exists($imgp) or ! is_file($imgp)):
                               $imgp = 'admin/files/imagem/user.png';
                            endif;
                             if($cont % 4== 0){
                                echo '<ul class="list row">';
                             }
                            ?>

                            <li class="large-3 columns">
                                 <div class="li-content" style=" max-width:290px; min-height: 220px;">
                                     <figure class="event-thumb" style="max-width: 290px; min-height: 180px;  "> <a href="?p=projeto&id=<?= $projeto->procodigo ?>">
                                             <img src="<?= $imgp ?>" with ="290" height="180" alt="" />
                                             <div class="overlay icon-info-in"></div>
                                         </a>
                                     </figure>
                                     <h4 class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.1px;">
                                         <a href="?p=projeto&id=<?= $projeto->procodigo  ?>">
                                             <?= $projeto->pronome ?>
                                         </a>
                                     </h4>
                                  <a href="?p=projeto&id=<?= $projeto->procodigo ?>" class="action-btn">Mais detalhes ...</a>
                                 </div>
                             </li>
                            <?php
                             $cont+= 1;
                             if( $cont % 4 == 0 || $cont == $projetos->getRowCount()){
                             echo '</ul>';
                             }
                        endforeach;
                    else:
                        echo '<li class="large-3 columns" style="margin-top:1px;" >Nenhum projeto encontrado</li>';
                    endif;
                    ?>
                </ul>
            <!--/section-->

           </article>
          </div>
    </div>
  </div>
</div>
     