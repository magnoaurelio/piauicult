        <div id="header-wrap">
            <div id="slider-wrap" class="flexslider">
                <ul class="slides">
				<?php 
                 $topos =  new Topo();
                 foreach ($topos->getResult() as $topo):
                 ?>
                    <li>
                        <!--img src="admin/files/topo/<?=$topo['topimagem']?>" alt="" /-->
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="slide-description">
                                    <h2><a href="?p=locais"><spam style="color:#000"><?=$topo['toptitulo']?></spam></a></h2>
                                    <h3><spam style="color:#000"><?=$topo['toptexto']?></spam></h3>
                                </div>	
                            </div>
                        </div>
                    </li>	
                 <?php endforeach; ?>   	
                    
                </ul>
            </div><!-- /slider-wrap -->

        </div><!-- /header-wrap -->

