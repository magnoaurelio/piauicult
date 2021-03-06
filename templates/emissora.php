<?php
$api = new Api();
$filterAmpar = new Filter("precodigo", "<=", 224);

$prefeituraService = new PrefeituraService($api->getPrefeitura([$filterAmpar->getValue()]));
//$unidadeGestora = $prefeituraService['codigoUnidGestora'];
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
<div id="main-wrap" >
    <div id="main" class="row">
        <div class="large-12 columns">
          <article class="post group"> 
              <header class="entry-top special-top">
                 <div class="large-3 columns" >  
                    <select class="form-control selecao" onchange="selectCidade(this.value)">
                        <option value="0">Selecione uma Cidade</option>
                        <?php
                        foreach ($prefeituraService->getPrefeituras() as $prefeitura) {
                            $selected = isset($_GET['precodigo']) && $_GET['precodigo'] == $prefeitura->precodigo ? 'selected=selected' : "";
                            echo "<option {$selected} value={$prefeitura->precodigo}>{$prefeitura->prenome}</option>";
                        }
                        ?>
                    </select>

                    
                   </div>
                       <h1 class="entry-title page-title" style="margin-top:15px;">
                         <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                         <a href="?p=emissora&id=<?= $emissora->emicodigo ?>?cidade&id=<?= $prefeitura->precodigo ?>">
                             <a href="#">Cidades & Emissoras</a>
                         </a>
                     </h1>
               
            </header>   
          </article>
        </div>
    
      
        <article class="post group">
                <div class="artistas-container row">
                    <div class="large-12 columns">
                        <section class="events-section events-upcoming">
                          <ol class="tracklisting">
                             <ol class="widget-list">
                         <?php
                            if (isset($_GET['precodigo'])) {
                                $cidades = $prefeituraService->getByPrecodigo($_GET['precodigo']);
                            }else{
                                $cidades = $prefeituraService->getPrefeituras();
                            }
                            foreach ($cidades as $cidade) {
                            $precodigo = str_pad($cidade->precodigo, 0, 3, 0);
                            $preimagem = Imagem::getPrefeitura($cidade->prefoto, $cidade->codigoUnidGestora);
                         //   $preimagem = Imagem::getPrefeitura($prefeitura->prefoto, $prefeitura->codigoUnidGestora);
                            $bandeira = Imagem::getPrefeitura($cidade->prebandeira, $cidade->codigoUnidGestora);
                            $brasao = Imagem::getPrefeitura($cidade->prebrasao, $cidade->codigoUnidGestora);
                            $bandeira = Imagem::getPrefeitura($cidade->prebandeira, $cidade->codigoUnidGestora);
                            $emissoras = new Emissora(null, "WHERE emicidade = {$precodigo}");
                            $tm = $emissoras->getRowCount();
                            if ($tm < 1)
                                continue;
                            ?>
                            
                            <li>
                            
                               <aside class="widget group" style="width: 300px; height:200px; margin-right: 3px;"> 
                                    <a href="?p=cidade&id=<?= $cidade->precodigo; ?>" class="entry-title page-title" title="<?= $cidade->prenome; ?>">
                                        <h4 class="entry-title page-title"> <?= $cidade->prenome; ?></h4>
                                        <img src="<?= $preimagem; ?>" width="300" height="200" alt=""/>
                                    </a>
                               </aside>
                            
                           
                            <table>
                            <tr>   
                            <?php
                            if ($emissoras->getResult()):
                            $cont = 0;
                           // $tm = sizeof($emissoras);
                            foreach ($emissoras->getResult() as $emissora):
                                $emissora = new Emissora($emissora['emicodigo']);
                                if ($cont == 7):
                                    $cont = 0;
                                    echo "</tr>";
                                endif;
                                ?>
                           
                            
                           <td>
                                   <aside class="widget group" style="width: 150px; height:150px; margin-right: 3px;"> 
                                      <figure class="event-thumb" style="margin: 0px;">  
                                            <a href="?p=emissora-detalhe&id=<?= $emissora->emicodigo ?>&precodigo=<?= $cidade->precodigo ?>"
                                               title="<?= $emissora->eminome ?>">
                                                <img src="admin/files/emissoras/<?= $emissora->emifoto ?>"
                                                     style="width: 150px; height: 150px;" alt=""/>
                                            </a>
                                        </figure>
                                        <a style="text-align: center;"
                                           href="?p=emissora-detalhe&id=<?= $emissora->emicodigo ?>&precodigo=<?= $cidade->precodigo ?>"
                                           class="action-btn"><?= $emissora->eminome ?></a>
                                    </aside>
                                  
                                </td>
                                     
                                 <?php
                                $cont++;
                                endforeach;
                                endif;
                                if ($cont <= 7 || ($tm % 7 == 0)):
                                    echo "</tr>";
                                endif;
                              
                            ?>
                            </tr>
                             
                            </table> 
                                   <!-- COLOCAR AQUI -->
                            </li>
                           
                            <?php } ?>
                           
                              </ol>
                          </ol>
                        </section>    
                     
                     </div>
                  </div>
          </article>
          
         </div>
        <!-- /large-12 -->
    </div>
    <!-- /main -->
 
     <script>
        function selectCidade(precodigo) {
            top.location.href = precodigo == 0 ? "?p=emissora" : "?p=emissora&precodigo="+ precodigo;
        }
    </script>
