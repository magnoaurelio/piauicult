<style>
    td{
        border-collapse: collapse;
    }  

    .disco-logo{
        float: left;
    }
    .artistas-container{
        width: 100%;
        padding: 10px;
    }
</style>
<br/>
<div id="main-wrap" style="margin-top: -10px">    
    <div id="main" class="row">        
        <div class="large-12 columns"> 
             <article class="post group">   
                    <header class="entry-top special-top">
                        <div class="large-3 columns" style="margin-top:3px;"> 
                            <select class="form-control selecao"> 
                                <option value="0" >Selecione um instrumento</option>                        
                                <?php
                                $instrumentos = new Instrumento(null, null, "ORDER BY insnome ASC");
                                $instruCodigos = [];
                                foreach ($instrumentos->getResult() as $instrumento) {
                                    $instruCodigos[] = $instrumento['inscodigo'];
                                    $selected = isset($_GET['id']) && $_GET['id'] == $instrumento['inscodigo'] ? 'selected=selected' : "";
                                    echo "<option {$selected} value={$instrumento['inscodigo']}>{$instrumento['insnome']}</option>";
                                }
                                ?> 
                            </select>               
                                 
                               </div>
                        
                        <h1 class="entry-title page-title" style="margin-top:5px;"> 
                            <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                            <a href="?p=instrumentistas&id=<?= $instrumento->inscodigo ?>">Artistas & Instrumentos</a>
                        </h1> 
                   </header>      
               </article>
            </div><!-- /large-12 -->   
            <article class="post group" style="margin-top:-30px;" >     
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : array_rand($instruCodigos, 1);

                $instrumentos = Instrumento::getMusicosOrdem($id);
                $primeiro = true;
                foreach ($instrumentos as $inscodigo => $qtd):
                    $instrumento = new Instrumento($inscodigo);
                    $imgp = "admin/files/instrumento/" . trim($instrumento->insfoto);
                    if (!file_exists($imgp) or ! is_file($imgp)):
                        $imgp = 'admin/files/imagem/instrumento.png';
                    endif;
                    ?>                    
                    <?php
                    $musicos = $instrumento->getMusicos();
                    ?>  
                    <div class="artistas-container row" style="margin-top: 5px;" >
                        <div class="large-2 columns">
                            <aside class="widget group" style="width: 190px; height:190px; margin-left: 5px; margin-top: 5px;">    
                                <figure class="event-thumb" style="margin: 0px">          
                                    <a href="?p=instrumentistas&id=<?= $instrumento->inscodigo ?>"> 
                                        <img src="<?= $imgp ?>" alt="" />      
                                        <div class="overlay icon-info-sign"></div>  
                                    </a>                                   
                                </figure>                                   
                                <a href="?p=instrumentistas&id=<?= $instrumento->inscodigo ?>" class="action-btn"><?= $instrumento->insnome ?></a> 
                            </aside>  
                        </div>
                        <div class="large-10 columns" style="margin-top: 5px;">
                            <table>  
                                <?php
                                if (!empty($musicos)):
                                    $cont = 0;
                                    echo "<tr>";
                                    $tm = sizeof($musicos);
                                    foreach ($musicos as $key => $artista):
                                        if ($cont == 7):
                                            $cont = 0;
                                            echo "</tr><tr>";
                                        endif;
                                        ?>                                    
                                        <td > 
                                            <aside class="widget group" style="width: 130px; height:130px; margin-right: 5px; margin-bottom:20px;"> 
                                                <figure class="event-thumb" style="margin: 0px;">    
                                                    <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="<?= $artista->artusual ?>"> 
                                                        <img src="admin/files/artistas/<?= $artista->artfoto ?>" alt="" />   
                                                    </a>                                           
                                                </figure>          
                                                <a href="?p=artist&id=<?= $artista->artcodigo ?>" class="action-btn"><?= $artista->artusual ?></a>   
                                            </aside>                                   
                                        </td>                                   
                                        <?php
                                        $cont ++;
                                    endforeach;
                                endif;
                                if ($cont <= 7 || ($tm % 7 == 0)):
                                    echo "</tr>";
                                endif;
                                ?>                        
                            </table> 
                        </div>

                    </div>
                    <hr style="border: 1px solid #ddd; width: 98%; margin: 0 auto; opacity: 0.5">

                    <?php
                endforeach;
                ?>            
            </article>           
        
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=instrumentos";
        } else {
            top.location.href = "?p=instrumentos&id=" + this.value;
        }
    });
</script>