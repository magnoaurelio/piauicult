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
                                        <h1 class="entry-title page-title"><a href="#">Discos de A - Z</a></h1>
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
                                            $discos = new Read;
                                            $discos->ExeRead("disco", "WHERE  SUBSTRING(disnome,1,1) = :letra  ORDER BY disnome", "letra={$letra}");
                                            if ($discos->getResult()):
                                                foreach ($discos->getResult() as $disco):
                                                $autor = Disco::getAutorDisco($disco['discodigo']);
                                              
                                                  // produtores
                                                    $produtores = Disco::getProdutor($disco['discodigo']);
                                                    $produtores_format = [];
                                                    foreach ($produtores as $produtor):
                                                        $produtores_format[] = "<a href='?p=artist&id={$produtor->artcodigo}'>" . $produtor->artusual . "</a>";
                                                    endforeach;
                                                    $produtores_format = implode(" , ", $produtores_format);

                                                    // arte
                                                    $artes = Disco::getArte($disco['discodigo']);
                                                    $artes_format = [];
                                                    foreach ($artes as $arte):
                                                        $artes_format[] = "<a href='?p=artist&id={$arte->artcodigo}'>" . $arte->artusual . "</a>";
                                                    endforeach;
                                                    $artes_format = implode(" , ", $artes_format);
                                               
                                                    ?>

                                                    <li class="group track">
                                                        <a class="my-btn"><i class="icon-star"></i></a>
                                                        <h5 class="track-title"><a href="?p=album&id=<?= $disco['discodigo']; ?>"><?= $disco['disnome']; ?></a></h5><br/>
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                
                                                                 <td  width="150">
                                                                      <small><img src="/images/icone/music.png" width="16"> Disco</small>
                                                                    <a href="?p=album&id=<?= $disco['discodigo']; ?>" class="" title=" Ir para o DISCO:<?= $disco['disnome']; ?>">
                                                                        <img src="admin/files/discos/<?= $disco['disimagem']; ?>" width="120" alt="" />
                                                                    </a>
                                                                   
                                                                  </td>
                                                                  <br/>
                                                                  <td  width="90">
                                                                       <small><img src="/images/icone/star.png" width="16"> Autor</small>
                                                                      <a href="?p=artist&id=<?= $autor->artcodigo; ?>" class="" title="  Ir para o AUTOR: <?= $autor->artusual; ?>">
                                                                             <img src="admin/files/artistas/<?= $autor->artfoto ?>"width="90" alt="" /> 
                                                                       </a>
                                                                      </td>
                                                                
                                                                    <td  width="90">  
                                                                        <small><img src="/images/icone/produtor.png" width="16"> Produtor</small>
                                                                       <a href="?p=artist&id=<?= $produtor->artcodigo ?>"  title="Ir para o PRODUTOR:  <?=  $produtor->artusual ?> ">
                                                                    <img src="admin/files/artistas/<?= $produtor->artfoto ?>" width="90" alt="" />
                                                                    </a>
                                                                   </td>
                                                                   <td  width="90"> 
                                                                        <small><img src="/images/icone/write.png" width="16"> Arte</small>
                                                                        <a href="?p=artist&id=<?= $arte->artcodigo ?>"  title="Ir para o DESING GRÁFICO:  <?=  $arte->artusual ?> ">
                                                                    <img src="admin/files/artistas/<?= $arte->artfoto  ?>" width="90" alt="" />
                                                                    </a>
                                                                   </td>
                                                                   <td width="10" align="right">
                                                                    <small></small><br/>
                                                                    <small></small><br/>
                                                                    <small></small><br/>
                                                                    <div class="action-btns" style="width:50%;">
                                                                     <nav id="nav">
                                                                         <a href="#"><span style="text-align: left;">Rede Social: <strong> <?= trim($autor->artusual) ?></strong></span></a>
                                                                       <a href="<?= $autor->artfacebook ?>" target="_blank" class="" title="Siga <?= trim($autor->artusual) ?> no Facebook.  ">
                                                                           <img class="par" width="40" height="40" src="images/facebook1.png"/>
                                                                       </a>

                                                                       <a href="<?= $autor->artinstagram ?>" target="_blank" class="" title="Siga  <?= trim($autor->artusual) ?> no Instagram.">
                                                                            <img class="par" width="40" height="40" src="images/instagram1.png"/>
                                                                       </a>

                                                                       <a href="<?= $autor->arttwitter ?>" target="_blank" class="" title="Siga <?= trim($autor->artusual) ?> no Twitter." >
                                                                            <img class="par" width="40" height="40" src="images/twitter1.png"/>
                                                                       </a>

                                                                       <a href="<?= $autor->artyuotube ?>" target="_blank" class="" title="Siga  <?= trim($autor->artusual) ?> no Yuo Tube.">
                                                                            <img class="par" width="40" height="40" src="images/yuotube1.png"/>
                                                                       </a>

                                                                       <a href="<?= $autor->artwhatsapp ?>" target="_blank" class="" title="Siga <?= trim($autor->artusual) ?> no WhatsApp.">
                                                                          <img class="par" width="40" height="40" src="images/whatsapp1.png"/>
                                                                       </a>

                                                                      <a href='<?= $autor->artsoundcloud ?>'  target="_blank" title="Siga <?= trim($autor->artusual) ?> no SoundCloud." >
                                                                          <img class="par" width="40" height="40" src="images/soudcloud.png"/> 
                                                                     </a>

                                                                          </nav>
                                                                     </div>
                                                                </td>
                                                                 <td style="padding-left: 20px; padding-right: 10px;" >
                                                                         <div class="row">
                                                                             <div class="col-lg-4">
                                                                            <small><img src="/images/icone/star.png" width="16"> Autor(es):</small>
                                                                           </div>
                                                                           <div class="col-lg-8">
                                                                              <a href="?p=artist&id=<?= $autor->artcodigo; ?>" class="" title=" Ir para o AUTOR: <?= $autor->artusual; ?>">
                                                                                 <small><?= $autor->artusual; ?></small>
                                                                             </a>
                                                                          </div>
                                                                        </div>
                                                                      
                                                                         <div class="row">
                                                                             <div class="col-lg-4">
                                                                                 <small><img src="/images/icone/produtor.png" width="16"> Produtor(es)</small>
                                                                           </div>
                                                                           <div class="col-lg-8">
                                                                              <a href="?p=artist&id=<?= $produtor->artcodigo; ?>"  title=" Ir para o PRODUTOR: <?= $produtor->artusual; ?>">
                                                                                 <small><?= $produtor->artusual; ?></small>
                                                                             </a>
                                                                          </div>
                                                                        </div>
                                                                       <div class="row">
                                                                             <div class="col-lg-4">
                                                                            <small><img src="/images/icone/write.png" width="16"> Arte</small>
                                                                           </div>
                                                                           <div class="col-lg-8">
                                                                              <a href="?p=artist&id=<?= $arte->artcodigo; ?>" title=" Ir para o DESIGN GRÁFICO: <?= $arte->artusual; ?>">
                                                                                 <small><?= $arte->artusual; ?></small>
                                                                             </a>
                                                                          </div>
                                                                        </div>
                                                                      
                                                               </td>    

                                                            </tr>

                                                        </table>
                                                        <!-- Modal -->
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