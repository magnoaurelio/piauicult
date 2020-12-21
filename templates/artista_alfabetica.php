
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns">

            <div class="row">
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

                <div class="large-12 columns">
                    <article class="post group" style="width: 100%; padding: 5px 20px 20px 20px;">
                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <div class="col-lg-12 cabeca">
                                    <header class="entry-top special-top">
                                        <h1 class="entry-title page-title"><a href="#">Artistas de A - Z</a></h1> 
                                    </header>
                                </div>
                                <?php
                                $n = 65;

                                for ($n = 65; $n <= 90; $n++) {

                                    $letra = chr($n);
                                    $ativa = $letra == 'A' ? 'active' : "";
                                    ?>
                                    <li role="presentation" class="<?= $ativa ?>"><a href="#tab<?= $letra ?>" aria-controls="tab<?= $letra ?>" role="tab" data-toggle="tab"><?= $letra ?></a></li>
                                <?php } ?>
                            </ul>

                            <div class="tab-content" style="float: left; width: 100%;">
                                <?php
                                $d = 0;
                                $p = 0;
                                $n = 65;

                                for ($n = 65; $n <= 90; $n++) {

                                    $letra = chr($n);
                                    $ativa = $letra == 'A' ? 'active' : "";
                                    ?>
                                    <div role="tabpanel" class="tab-pane <?= $ativa ?>" id="tab<?= $letra ?>">
                                        <ol class="tracklisting">
                                            <?php
                                            $artistas = new Read;
                                            $artistas->ExeRead("artista", "WHERE  SUBSTRING(artusual,1,1) = :letra  ORDER BY artusual", "letra={$letra
                                                    }");
                                            if ($artistas->getResult()):
                                                foreach ($artistas->getResult() as $artista):
                                                    $artistaObject = new Artista($artista['artcodigo']);
                                                    ?>
                                                    <li class="group track">
                                                        <a class="my-btn"><i class="icon-star"></i></a>
                                                        <h5 class="track-title"><a href="?p=artist&id=<?= $artista['artcodigo']; ?>"><?= $artista['artusual']; ?></a></h5><br/>
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td  width="65"> 
                                                                    <a href="?p=artist&id=<?= $artista['artcodigo']; ?>" class="" title="<?= $artista['artusual']; ?>"><img src="admin/files/artistas/<?= $artista['artfoto']; ?>" width="80" alt="" /></a>
                                                                </td>
                                                                <?php
                                                                // interprestes
                                                                $instrumentos = $artistaObject->getInstrumentos();
                                                                $instrumentos_format = [];
                                                                foreach ($instrumentos as $instrumento):
                                                                    $instrumentos_format[] = "<a href='?p=instrumentistas&id={$instrumento->inscodigo
                                                                            }'><img src='admin/files/instrumento/{$instrumento->insfoto}' title='{$instrumento->insnome}' width='60'/></a>";
                                                                endforeach;
                                                                $instrumentos_format = implode("  ", $instrumentos_format);
                                                                ?>
                                                                <td style="padding-left: 50px;"><?= $instrumentos_format ?></td>
                                                            </tr>
                                                        </table>
                                                     
                                                        
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="bio<?=$artistaObject->artcodigo?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin-top: 100px;">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title"  id="myModalLabel">Biografia</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?= $artistaObject->artbiografia?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    
                                                        <div class="action-btns" style="width:50%;">
                                                            <nav id="nav">
                                                                <a href="#"><span style=" text-align: left;">Rede Social: <strong> <?= trim($artista['artusual']) ?></strong></span></a>
                                                                   <a href="<?= $artista['artfacebook'] ?>" target="_blank" class="" title="Siga <?= trim($artista['artusual']) ?> no Facebook.  ">
                                                                       <img class="par" width="40" height="40" src="images/facebook1.png"/>
                                                                   </a>
                                                            
                                                                   <a href="<?= $artista['artinstagram'] ?>" target="_blank" class="" title="Siga  <?= trim($artista['artusual']) ?> no Instagram.">
                                                                        <img class="par" width="40" height="40" src="images/instagram1.png"/>
                                                                   </a>
                                                              
                                                                   <a href="<?= $artista['arttwitter'] ?>" target="_blank" class="" title="Siga <?= trim($artista['artusual']) ?> no Twitter." >
                                                                        <img class="par" width="40" height="40" src="images/twitter1.png"/>
                                                                   </a>
                                                              
                                                                   <a href="<?= $artista['artyuotube'] ?>" target="_blank" class="" title="Siga  <?= trim($artista['artusual']) ?> no Yuo Tube.">
                                                                        <img class="par" width="40" height="40" src="images/yuotube1.png"/>
                                                                   </a>
                                                               
                                                                   <a href="<?= $artista['artwhatsapp'] ?>" target="_blank" class="" title="Siga <?= trim($artista['artusual']) ?> no WhatsApp.">
                                                                      <img class="par" width="40" height="40" src="images/whatsapp1.png"/>
                                                                   </a>
                                                                
                                                                  <a href='<?= $artista['artsoundcloud'] ?>'  target="_blank" title="Siga <?= trim($artista['artusual']) ?> no SoundCloud." >
                                                                      <img class="par" width="40" height="40" src="images/soudcloud.png"/> 
                                                                 </a>
                                                            
                                                           </nav>
                                                            <?php if ($artistaObject->artbiografia): ?>
                                                                <a data-toggle="modal" data-target="#bio<?=$artistaObject->artcodigo?>" class="action-btn">Biografia</a>
                                                            <?php else: ?>
                                                                <a data-toggle="modal" data-target="#bio<?=$artistaObject->artcodigo?>" style="background-color:#CCC;" class="action-btn">Biografia</a>
                                                            <?php endif; ?>
                                                            <a href="?p=artist&id=<?= $artista['artcodigo']; ?>"  onclick="Topo()" class="action-btn">Mais...</a>
                                                        </div>
                                                        <div id="lyrics-1" class="track-lyrics-hold">
                                                            <p><img src="admin/files/musicas/letra/<?= $musica->musletra ?>" width="auto"  alt="" /></p>
                                                        </div>
                                                             
                                                    </li>

                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                                  
                                        </ol>
                                    </div>
                                    
                                    <?php
                                    $d = 0;
                                } // fim do for das letras  
                                ?>
                            </div>

                        </div>
                </div>
                </article>

            </div>
        </div>

    </div>
    <!-- /large-12 -->
</div>
<!-- /main -->
</div>
<!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=artistas";
        } else {
            top.location.href = "?p=artista&id=" + this.value;
        }
    });
</script>