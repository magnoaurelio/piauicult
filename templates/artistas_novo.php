<div id="main-wrap" style="margin-top: -120px">    
    <div id="main" class="row">        
        <div class="large-12 columns">            
            <header class="entry-top special-top">                
                <h1 class="entry-title page-title">Tipos - Artistas</h1>            
            </header>            
            <div class="row">                
                <div class="large-3 columns">                    
                    <select class="form-control selecao">                        
                        <option value="0" >Selecione um Tipo</option>                        
                             <?php                          
                            $artista_tipos = new ArtistaTipo(null,null,"ORDER BY arttiponome ASC") ;                          
                            foreach ($artista_tipos->getResult() as $artista_tipo) {                              
                                $selected  = isset($_GET['id']) && $_GET['id'] == $artista_tipo['arttipocodigo']? 'selected=selected': "";                               
                                echo "<option {$selected} value={$artista_tipo['arttipocodigo']}>{$artista_tipo['arttiponome']}</option>";                          
                                }?> 
                    </select>               
                </div>                
                <div class="large-9 columns">                    
                    &nbsp;               
                </div>            
            </div>            
            <article class="post group">                
                <?php                
                $id  = isset($_GET['id'])? $_GET['id']: null;                 
                $artista_tipo = ArtistaTipo::getMusicosTipo($id);                
                $primeiro = true;          
                
                foreach ($artista_tipos as  $arttipocodigo => $qtd):                    
                $artista_tipos = new ArtistaTipo($arttipocodigo);                    
                $imgp = "admin/files/artista_tipo/" . trim($artista_tipo->arttipofoto);                    
                if (!file_exists($imgp) or ! is_file($imgp)):                       
                    $imgp = 'admin/files/imagem/clave_sol.jpg';                    
                endif; 
                              
                $musicos = $artista_tipo->getMusicos();
                var_dump($musicos);
                ?>                    
                <table>                        
                    <tr>                            
                        <td  width="105" style="border-right: 2px dotted #CCC; margin-left: 5px;">   
                            <aside class="widget group" style="width: 130px; height: 130px;">    
                                <figure class="event-thumb" style="margin: 0px">          
                                    <a href="?p=artistas&id=<?= $artista_tipo->inscodigo ?>"> 
                                        <img src="<?= $imgp ?>" alt="" />      
                                        <div class="overlay icon-info-sign"></div>  
                                    </a>                                   
                                </figure>                                   
                                <a href="?p=artistas&id=<?= $artista_tipo->inscodigo ?>" class="action-btn"><?= $artista_tipo->arttiponome ?></a> 
                            </aside>                            
                        </td>                            
                            <?php                            
                            if (!empty($musicos)):                                
                                foreach ($musicos as $artista):                                    
                            ?>                                    
                        <td style="padding-left: 5px;"> 
                            <aside class="widget group" style="width: 70px; height:70px; margin-right: 5px;"> 
                                <figure class="event-thumb" style="margin: 0px">    
                                    <a href="?p=artistas&id=<?= $artista->artcodigo ?>" title="<?= $artista->artusual ?>"> 
                                        <img src="admin/files/artistas/<?= $artista->artfoto ?>" alt="" />   
                                    </a>                                           
                                </figure>          
                                <a href="?p=artistas&id=<?= $artista->artcodigo ?>" class="action-btn">Perfil</a>   
                            </aside>                                   
                        </td>                                   
                           <?php                                
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
    $('.selecao').change(function(e){      
        if(this.value == 0){           
            top.location.href = "?p=artistas";       
        }else{           
            top.location.href = "?p=artistas&id=" + this.value;       }          });
</script>