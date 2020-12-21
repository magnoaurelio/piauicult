<div id="main-wrap" style="margin-top: -120px">    
    <div id="main" class="row">        
        <div class="large-12 columns">            
            <header class="entry-top special-top">                
                <h1 class="entry-title page-title">tipos de Artistas.</h1>            
            </header>            
            <div class="row">                
                <div class="large-3 columns">                    
                    <select class="form-control selecao">                        
                        <option value="0" >Selecione um Tipo de artista</option>                        
                        <?php
                        $artista_tipos = new ArtistaTipo(null,"ORDER BY arttiponome ASC");
                        foreach ($artista_tipos->getResult() as $artista_tipo) {
                            $selected = isset($_GET['id']) && $_GET['id'] == $artista_tipo['arttipocodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$artista_tipo['arttipocodigo']}>{$artista_tipo['arttiponome']}</option>";
                        }
                        ?> 
                    </select>               
                </div>                
                <div class="large-9 columns">                    
                    &nbsp;               
                </div>            
            </div>            
            <article class="post group">                
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $artista_tipos = new ArtistaTipo($id);
                $primeiro = true;
                foreach ($artista_tipos->getResult() as $artistatipo):
                    $artista_tipo = new ArtistaTipo($artistatipo['arttipocodigo']);
                    $imgp = "admin/files/artista_tipo/" . trim($artista_tipo->arttipofoto);
                    if (!file_exists($imgp) or ! is_file($imgp)):
                        $imgp = 'images/clave_sol.jpg';
                    endif;
                    ?>                    
                    <?php
                    $musicos = ArtistaTipo::getMusicosTipo($artista_tipo->arttipocodigo);
                    ?>  


                    <style>
                        td{
                            border-collapse: collapse;
                        }      
                    </style>

                    <table cellpadding="3" cellspacing="3" style="margin-bottom: 20px;">                    
                        <tr>                            
                            <td  rowspan="2" width="105" style="padding: 0px;" >   
                                <aside class="widget group" style="width: 130px; height: 150px; margin:0px;">    
                                    <figure class="event-thumb" style="margin: 0px">          
                                        <a href="?p=artist&id=<?= $artista_tipo->arttipofoto ?>"> 
                                            <img src="<?= $imgp ?>" alt="" />      
                                            <div class="overlay icon-info-sign"></div>  
                                        </a>                                
                                    </figure>                                   
                                    <a href="?p=artist&id=<?= $artista_tipo->arttipofoto ?>" class="action-btn"><?= $artista_tipo->arttiponome ?></a>
                                </aside>                    
                            </td>                            
                            <?php
                            if (!empty($musicos)):
                                $cont = 0;
                                foreach ($musicos as $key => $artista):
                                    if($key == 13):
                                        break;
                                    endif;
                                    ?>                                    
                                    <td > 
                                        <aside class="widget group" style="width: 70px; height:70px; margin-bottom:10px;"> 
                                            <figure class="event-thumb" style="margin: 0px;">    
                                                <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="<?= $artista->artusual ?>"> 
                                                    <img src="admin/files/artistas/<?= $artista->artfoto ?>" alt="" />   
                                                </a>                                           
                                            </figure>          
                                            <a href="?p=artist&id=<?= $artista->artcodigo ?>" class="action-btn">Perfil</a>   
                                        </aside>                                   
                                    </td>                                   
                                    <?php
                                    $cont ++;
                                endforeach;
                            endif;
                            ?>                        
                        </tr>  
                        <tr>
                            <?php
                            if (!empty($musicos)):
                                foreach ($musicos as $key => $artista):
                                    if($key < $cont):
                                        continue;
                                    endif;
                                    ?>                                    
                                    <td > 
                                        <aside class="widget group" style="width: 70px; height:70px; margin:0px;"> 
                                            <figure class="event-thumb" style="margin: 0px;">    
                                                <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="<?= $artista->artusual ?>"> 
                                                    <img src="admin/files/artistas/<?= $artista->artfoto ?>" alt="" />   
                                                </a>                                           
                                            </figure>          
                                            <a href="?p=artistas&id=<?= $artista->artcodigo ?>" class="action-btn">Perfil</a>   
                                        </aside>                                   
                                    </td>                                   
                                    <?php
                                    $cont ++;
                                endforeach;
                            endif;
                            ?>                        
                        </tr>   

                    </table>                    
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
            top.location.href = "?p=artistas";
        } else {
            top.location.href = "?p=artistas&id=" + this.value;
        }
    });
</script>