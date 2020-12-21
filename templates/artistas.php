
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
                            <option value="0" >Selecione todos os artistas</option>                        
                            <?php
                             class Total{
                                private $valor;
                                public function __construct()
                                {
                                    $this->valor = 0;
                                }
                                 function soma($valor){
                                    $this->valor += $valor;
                                    return $valor;
                                }
                                 function getValor(){
                                    return $this->valor;
                                }
                            }

                            $total = new Total();
                            $artistas = new Artista(null, "ORDER BY artusual ASC");
                            $artistaCodigos = [];
                            $artista_tipos = new ArtistaTipo(null, "ORDER BY arttiponome ASC");
                            foreach ($artista_tipos->getResult() as $artista_tipo) {
                                $selected = isset($_GET['id']) && $_GET['id'] == $artista_tipo['arttipocodigo'] ? 'selected=selected' : "";
                                echo "<option {$selected} value={$artista_tipo['arttipocodigo']}>{$artista_tipo['arttiponome']}</option>";
                            }
                            ?> 
                    </select>               
                                 
                    </div>    
                    <h1 class="entry-title page-title" style="margin-top:10px;">
                        <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp; 
                        <a href="?p=artistas&id=<?= $convidado->arttipocodigo ?>"> Artistas & Fotos</a>  
                    </h1>
                </header>   
             </article>
        </div>
        
       <article class="post group" style="margin-top:-30px;">                
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                $artista_tipos = new ArtistaTipo($id, "WHERE arttipocodigo != 18 ORDER BY RAND() limit 1");
                $primeiro = true;
                foreach ($artista_tipos->getResult() as $artistatipo):
                    $artista_tipo = new ArtistaTipo($artistatipo['arttipocodigo']);
                    $imgp = "admin/files/artista_tipo/" . trim($artista_tipo->arttipofoto);
                    if (!file_exists($imgp) or ! is_file($imgp)):
                        $imgp = 'images/ARTISTA_GERAL.jpg';
                    endif;
                    ?>                    
                    <?php
                    $musicos = ArtistaTipo::getMusicosTipo($artista_tipo->arttipocodigo);
//                    $m =  array_chunk($musicos, 2);
//                    if (sizeof($m) > 0) {
//                        $musicos = $m[0];
//                    }
                    ?>

                    <?php if (!isset($_GET['id']) and $primeiro): ?>
               
                        <div class="artistas-container row" style="margin-top: 5px;">
                            <?php
                            $primeiro = false;
                            $convidado = new ArtistaTipo(18);
                            ?>
                            <div class="large-2 columns" style="margin-top: 5px;">
                                <aside class="widget group" style="width: 190px; height:190px; margin-top:5px;">    
                                    <figure class="event-thumb" style="margin: 0px">          
                                        <a href="?p=artistas&id=<?= $convidado->arttipocodigo ?>"> 
                                            <img src="<?= $imgp ?>"  width="190" height="190" alt="logo" />      
                                            <div class="overlay icon-info-sign"></div>  
                                        </a>                                
                                    </figure>                                   
                                    <a href="?p=artistas&id=<?= $convidado->arttipocodigo ?>" class="action-btn"><?= $convidado->arttiponome ?></a>
                                </aside> 
                                  <p> Estatísticas </p>
                                <img src="images/estrela.png" width="20" height="20" alt="estrela" /> &nbsp;Artistas: <strong> <?=$total->soma((new Artista())->getRowCount())?></strong>  <br/>
                                <img src="images/play.png" width="20" height="20" alt="disco" /> &nbsp;Discos: &nbsp;<strong>  <?=$total->soma((new Disco())->getRowCount())?></strong> <br/>
                                <img src="images/nota.png" width="20" height="20" alt="musica" /> &nbsp;Musicas: <strong> <?=$total->soma((new Musica())->getRowCount())?></strong> 
                            
                            </div>
                            <div class="large-10 columns" style="margin-top: 5px;">
                                <table>  
                                    <?php
                                    $convidados = ArtistaTipo::getMusicosTipo($convidado->arttipocodigo);
                                    if (!empty($convidados)):
                                        $cont = 0;
                                        echo "<tr>";
                                        $tm = sizeof($convidados);
                                        foreach ($convidados as $key => $artista):
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
                            <hr style="border: 1px solid #ddd;">
                        </div>
                    <?php endif; ?>

                    <div class="artistas-container row">
                        <div class="large-2 columns">
                            <aside class="widget group" style="width: 190px; height:190px; margin-top: 5px;">    
                                <figure class="event-thumb" style="margin: 0px">          
                                    <a href="?p=artistas&id=<?= $artista_tipo->arttipocodigo ?>"> 
                                        <img src="<?= $imgp ?>" alt="" />      
                                        <div class="overlay icon-info-sign"></div>  
                                    </a>                                
                                </figure>                                   
                                <a href="?p=artistas&id=<?= $artista_tipo->arttipocodigo ?>" class="action-btn"><?= $artista_tipo->arttiponome ?></a>
                              </aside> 
                            <p> 
                                <i class="fas fa-clock" style="font-size:120px;color:#2196F3"></i>
                                <i class="far fa-clock" style="font-size:120px;color:#2196F3"></i>
                               Estatísticas
                            </p>
                            <img src="images/estrela.png" width="20" height="20" alt="estrela" /> &nbsp;Artistas: <strong> <?=$total->soma((new Artista())->getRowCount())?></strong>  <br/>
                           <img src="images/play.png" width="20" height="20" alt="disco" /> &nbsp;Discos: &nbsp;<strong>  <?=$total->soma((new Disco())->getRowCount())?></strong> <br/>
                           <img src="images/nota.png" width="20" height="20" alt="musica" /> &nbsp;Musicas: <strong> <?=$total->soma((new Musica())->getRowCount())?></strong> 
                         
                        </div>
                        
                        <div class="large-10 columns" style="">
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
                                                <a href="?p=artist&id=<?= $artista->artcodigo ?>" class="action-btn">
                                                <?= $artista->artusual ?>
                                                </a>   
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
                    <?php
                endforeach;
                ?>            

            </article>           
       
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