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
                        <option value="0">Selecione um Artista</option>
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
                        foreach ($artistas->getResult() as $artista) {
                            $artistaCodigos[] = $artista['artcodigo'];
                            $selected = isset($_GET['id']) && $_GET['id'] == $artista['artcodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$artista['artcodigo']}>{$artista['artusual']}</option>";
                        }
                        ?>
                    </select>
                  </div>
                  <h1 class="entry-title page-title" style="margin-top:-5px;"><img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                      <a href="?p=artist&id=<?= $artista->artcodigo ?>"> Discos  & Artistas </a>
                  </h1>
                </header>   
            </article>
            </div>
    
            <article class="post group" style="margin-top:-30px;">
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : array_rand($artistaCodigos, 1);
                $artistas = Disco::getArtistaOrdem($id);
                
                foreach ($artistas as $artcodigo => $artista): $artista = new Artista($artcodigo);
                    $imgp = "admin/files/artistas/" . trim($artista->artfoto);
                    if (!file_exists($imgp) or ! is_file($imgp)): $imgp = 'admin/files/imagem/user.png';
                    endif;
                    ?>
                    <?php $discos = $artista->getDiscos(); ?>

                    <div class="artistas-container row"  style="margin-top: 5px;">
                        <div class="large-2 columns">
                            <aside class="widget group" style="width: 190px; height:190px; margin-top:5px;">    
                                <figure class="event-thumb" style="margin: 0px">          
                                    <a href="?p=artist&id=<?= $artista->artcodigo ?>"> 
                                        <img src="<?= $imgp ?>" alt="" />      
                                        <div class="overlay icon-info-sign"></div>  
                                    </a>                                
                                </figure>                                   
                                <a href="?p=artist&id=<?= $artista->artcodigo ?>" class="action-btn"><?= $artista->artusual ?></a>
                            </aside> 
                            <p> Estatísticas</p>
                            <img src="images/estrela.png" width="20" height="20" alt="estrela" /> &nbsp;Artistas: <strong> <?=$total->soma((new Artista())->getRowCount())?></strong>  <br/>
                            <img src="images/play.png" width="20" height="20" alt="disco" /> &nbsp;Discos: &nbsp;<strong>  <?=$total->soma((new Disco())->getRowCount())?></strong> <br/>
                            <img src="images/nota.png" width="20" height="20" alt="musica" /> &nbsp;Musicas: <strong> <?=$total->soma((new Musica())->getRowCount())?></strong> 
                            
                        </div>
                        <div class="large-10 columns" style="margin-top: 5px;">
                            <table>  
                                <?php
                                $tm = sizeof($discos);
                                $cont = 0;
                                if (!empty($discos)):
                                    echo "<tr>";
                                    foreach ($discos as $key => $disco):
                                        if ($cont == 7):
                                            $cont = 0;
                                            echo "</tr><tr>";
                                        endif;
                                        ?>                                    
                                        <td > 
                                            <aside class="widget group" style="width: 135px; height:135px; margin-right: 0px; margin-bottom:20px;"> 
                                                <figure class="event-thumb" style="margin: 0px;">    
                                                    <a href="?p=album&id=<?= $disco->discodigo ?>" title="<?= $disco->disnome ?>"> 
                                                        <img src="admin/files/discos/<?= $disco->disimagem ?>" alt="" />   
                                                    </a>                                           
                                                        
                                                <a  style="text-align: center;" href="?p=album&id=<?= $disco->discodigo ?>" class="action-btn"><?= substr($disco->disnome,0,18) ?>...</a>   
                                                </figure>  
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
                    
                <?php endforeach; ?>
            </article>
        <!-- /large-12 -->
    </div>
    <!-- /main -->
</div>
<!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=disco";
        } else {
            top.location.href = "?p=disco&id=" + this.value;
        }
    });
</script>