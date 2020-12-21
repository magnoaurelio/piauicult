
<?php
$api = new Api();
if (isset($_GET['precodigo'])) {
    $filterAmpar = new Filter("precodigo", "=", $_GET['precodigo']);
} else {
    $filterAmpar = new Filter("precodigo", "<=", 224);
}
$prefeituraService = new PrefeituraService($api->getPrefeitura([$filterAmpar->getValue()]));
$festival = new Festival();
?>
 <style>
    td {
        border-collapse: collapse;
    }

    .disco-logo {
        float: left;
    }

    .artistas-container {
        width: 100%;
        padding: 10px;
    }
</style>
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns">
          <div class="row">
           <article class="post group"> 
              <header class="entry-top special-top">
                 <div class="large-3 columns" style="margin-top:3px;">  
                    <select class="form-control selecao">
                        <option value="0">Selecione uma Cidade</option>
                        <?php
                        $bandasTipo = new BandaTipo(null, "ORDER BY bantiponome ASC");
                        foreach ($bandasTipo->getResult() as $bandatipo) {
                            $selected = isset($_GET['id']) && $_GET['id'] == $bandatipo['bantipocodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$bandatipo['bantipocodigo']}>{$bandatipo['bantiponome']}</option>";
                        }
                        ?>
                    </select>
                   </div>
                       <h1 class="entry-title page-title" style="margin-top:5px;">
                         <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                         <a href="?p=artist&id=<?= $artista->artcodigo ?>"><a href="#">Festivais Diversos</a></a>
                     </h1>
               
            </header>   
            </article>
          
               
            <article class="post group" style="margin-top:-30px;">
                <div class="artistas-container row">
                    <div class="large-12 columns" style=" padding: 10px;">
                        <table class="table">
                            
                            <?php
                            $cidades = $prefeituraService->getPrefeituras();
                            foreach ($cidades
                            as $cidade) {
                            $codigo = str_pad($cidade->precodigo, 0, 3, 0);
                            $brasao = Imagem::getPrefeitura($cidade->prebrasao, $cidade->codigoUnidGestora);
                            $bandeira = Imagem::getPrefeitura($cidade->prebandeira, $cidade->codigoUnidGestora);
                            $festivais = new Festival(null, "WHERE precodigo = {$codigo}");
                            $tm = $festivais->getRowCount();
                            if ($tm < 1)
                                continue;
                            ?>
                            <tr class="group track">
                               
                                <td style="margin-right: 10px; text-align: center;  ">
                                   <h5 class="track-title"> <a href="?p=cidade&id=<?= $codigo; ?>"><?= $cidade->prenome; ?>&nbsp;</a></h5>
                                        <table border="1">
                                            
                                            <!--tr>
                                                
                                                <td width="65">
                                                    <a href="?p=cidade&id=<?= $cidade->precodigo; ?>" class=""
                                                       title="<?= $cidade->prenome; ?>"><img src="<?= $brasao; ?>"
                                                                                             width="60" alt=""/></a>
                                                </td>
                                                <td width="65">
                                                    <a href="?p=cidade&id=<?= $cidade->precodigo; ?>" class=""
                                                       title="<?= $cidade->prenome; ?>"><img src="<?= $bandeira; ?>"
                                                                                             width="60" alt=""/></a>
                                                </td>
                                                 
                                            </tr-->
                                      
                                        </table>
                                </td>
                               </div>
                                <?php

                                if ($festivais->getResult()):
                                    $cont = 0;
                                    echo "<tr>";
                                    $tm = sizeof($festivais);
                                    foreach ($festivais->getResult() as $festival):
                                         if ($cont == 7):
                                            $cont = 0;
                                            echo "</tr><tr>";
                                        endif;
                                        $festival = new Festival($festival['fescodigo']);
                                        ?>
                                        <td>
                                            <div class="large-2 columns sidebar sidebar-1">
                                            <aside class="widget group"
                                                   style="width: 125px; height:125px; margin-right: 5px; margin-bottom:20px;">
                                                <figure class="event-thumb" style="margin: 0px;">
                                                    <a href="?p=festival-detalhe&id=<?= $festival->fescodigo ?>"
                                                       title="<?= $festival->fesnome ?>">
                                                        <img src="admin/files/festivais/<?= $festival->fesimagem ?>"
                                                             style="width: 120px; height: 100px;" alt=""/>
                                                    </a>
                                                </figure>
                                                <a style="text-align: center;"
                                                   href="?p=festival-detalhe&id=<?= $festival->fescodigo ?>"
                                                   class="action-btn"><?= $festival->fesnome ?> - <?= trim($festival->fesperiodo)?></a>
                                            </aside>
                                                </div>
                                        </td>
                                        <?php
                                       $cont ++;
                                    endforeach;
                                endif;
                                 if ($cont <= 7 || ($tm % 8 == 0)):
                                    echo "</tr>";
                                endif;
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </article>
        </div>
        <!-- /large-12 -->
    </div>
    <!-- /main -->
</div>