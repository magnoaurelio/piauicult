 
    <?php
    $emissora = $_GET['id'];
    $apresentador = new Read();
    $apresentador->ExeRead("apresentador", "WHERE apremissora = $emissora ORDER BY rand() limit 10");
    ?>
    <h4 class="widget-title"><a href="?p=emissora">Apresentadores</a></h4>
    <div class="large-3 columns sidebar sidebar-1">
    <aside class="widget group" style="margin-bottom: -10px;">
        <ol class="widget-list widget-list-single" >
            <li style="max-height: 250px; min-height: 250px; margin-bottom: 20px;">
            <?php 
            foreach($apresentador->getResult() as $apresentador):
                    $aprcodigo = $apresentador['aprcodigo'];
              //  $artista_tipos = new ArtistaTipo();
            //var_dump( $tipocodigo);
              ?>
                <figure class="event-thumb">
                    <h4 class="list-title"><a href="?p=emissora&id=<?=$apresentador['aprcodigo']?>"><?= $apresentador['aprnome']?></a></h4>
                    <!--a title="Mais sobre... <?=  $apresentador['aprnome'] ?>" href="?p=artist&id=<?=$artista['artcodigo']?>"-->
                    <?php 
                    $aprfoto = "admin/files/apresentador/" . trim($apresentador['aprfoto']);
                    if (!file_exists($aprfoto) or !is_file($aprfoto)):
                    $aprfoto = 'admin/files/imagem/user.png';
                    endif;
                    ?>

                    <img src="<?=$aprfoto?>" width="250" height="250" alt="" />

                    <div class="overlay icon-info-sign"></div>

                    </a>
                </figure>
               <a  href="?p=emissora&id=<?=$apresentador['aprcodigo']?>" title="Mais sobre... <?=$apresentador['aprfuncao']?>" class="action-btn"><?=$apresentador['aprfuncao']?></a>
            </li>
         </ol>
        </aside>
        <?php 
        endforeach;
        ?>
     </div>
 
