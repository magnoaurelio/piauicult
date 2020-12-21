<div id="footer-wrap">
    <div class="row">
        <div class="large-12 columns">
            <footer class="row footer" style="background: #3f3f3f; padding-top: 5px;">
                <h4 class="widget-title">Links Culturais</h4>
                  <?php  
                    $links = new Links();
                   //var_dump( $tipocodigo);
                   foreach ($links->getResult() as $links):
                   $lincodigo = $links['lincodigo'];
                   $linnome   = $links['linnome'];
                  ?>
                <div class="large-3 columns">
                    <aside class="widget group">
                     <ol class="widget-list">
                        <li>
                             <a href="<?=$links['linurl']?>" target="_blanck" title="Responsável: <?=$links['linusual']?>">
                                  <div class="widget-content">
                                 <img src="admin/files/links/<?=$links['linimagem']?>" class="alignleft"  width="50" height="50" alt=""> a
                                 </div>
                                   <?=$links['linnome']?><br>
                                 <small>Por: <em> <?=$links['linusual']?></em></small>
                             </a>

                        </li>
                    </ol>
                         <br>
                    </aside>
                </div>
                  <?php endforeach; ?>
              
            </footer><!-- /footer -->
        </div><!-- /large-12 -->
   
      
    </div><!-- /row -->
</div><!-- /footer-wrap -->