<div id="main-wrap" style="margin-top: -120px">    
    <div id="main" class="row">        
        <div class="large-12 columns">            
            <header class="entry-top special-top">                
                <h1 class="entry-title page-title">Grupos Musicais.</h1>            
            </header>            
            <div class="row">                
                <div class="large-3 columns">                    
                    <select class="form-control selecao">                        
                        <option value="0" >Selecione um Tipo de Grupo</option>                        
                        <?php
                        $bantipos = new BandaTipo(null, null, "ORDER BY bantiponome ASC");
                        foreach ($bantipos->getResult() as $bantipo) {
                            $selected = isset($_GET['id']) && $_GET['id'] == $bantipo['bantipocodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$bantipo['bantipocodigo']}>{$bantipo['bantiponome']}</option>";
                        }
                        ?> 
                    </select>               
                </div>                
                <div class="large-9 columns">                    
                    &nbsp;               
                </div>            
            </div>            
            <article class="post group">     
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
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $bantipos = BandaTipo::getBandasTipoOrdem($id);
                $primeiro = true;
                //var_dump($bantipos);
                foreach ($bantipos as $bantipocodigo => $qtd):
                    $bantipo = new BandaTipo($bantipocodigo);
                  
                    $imgp = "admin/files/banda_tipo/" . trim($bantipo->bantipofoto);
                    if (!file_exists($imgp) or ! is_file($imgp)):
                        $imgp = 'admin/files/images/banda.png';
                    endif;
                     
                    ?>                    
                    <?php
                    $grupos= $bantipo->getBandas();
                    
                    ?>  
                    <div class="artistas-container row" >
                        <div class="large-1 columns">
                            <aside class="widget group" style="width: 80px; height:80px; margin-left:5px;">    
                                <figure class="event-thumb" style="margin: 5px">          
                                    <a href="?p=banda&id=<?= $bantipo->bantipocodigo ?>"> 
                                        <img src="<?= $imgp ?>" alt="" />      
                                        <div class="overlay icon-info-sign"></div>  
                                    </a>                                   
                                </figure>                                   
                                <a href="?p=banda&id=<?= $bantipo->bantipocodigo ?>" class="action-btn"><?= $bantipo->bantiponome ?></a> 
                            </aside>  
                        </div>
                        <div class="large-11 columns" style="">
                            <table>  
                                <?php
                                if (!empty($grupos)):
                                    $cont = 0;
                                    echo "<tr>";
                                    $tm = sizeof($grupos);
                                    foreach ($grupos as $key => $banda):
                                       
                                        if ($cont == 8):
                                            $cont = 0;
                                            echo "</tr><tr>";
                                        endif;
                                        ?>                                    
                                        <td > 
                                            <aside class="widget group" style="width: 125px; height:125px; margin-right: 5px; margin-bottom:20px;"> 
                                                <figure class="event-thumb" style="margin: 0px;">    
                                                    <a href="?p=banda&id=<?= $banda->bancodigo ?>" title="<?= $banda->bannome ?>"> 
                                                         <?php
                                                                    $imgb = "admin/files/bandas/" . trim($banda->banfoto1);
                                                                    if (!file_exists($imgb) or ! is_file($imgb)):
                                                                        $imgb = 'admin/files/images/banda.png';
                                                                    endif;
                                                                    ?>                    
                   
                                                        <img src="<?= $imgb ?>" alt="" />   
                                                    </a>   
                                                    
                                                </figure>          
                                                <a href="?p=banda&id=<?= $banda->bancodigo ?>" class="action-btn"><?= $banda->bannome ?></a>   
                                            </aside>                                   
                                        </td>                                   
                                        <?php
                                           // var_dump($banda);
                                        $cont ++;
                                    endforeach;
                                endif;
                                if ($cont <= 8 || ($tm % 8 == 0)):
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
        </div><!-- /large-12 -->    
    </div><!-- /main -->
</div><!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=grupo_tipo";
        } else {
            top.location.href = "?p=grupo_tipo&id=" + this.value;
        }
    });
</script>