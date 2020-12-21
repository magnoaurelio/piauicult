<aside class="widget group" style="margin-top: -30px">
	<?php
        $emissora = $_GET['id'];
	$apresentador = new Read();
	$apresentador->ExeRead("apresentador", "WHERE apremissora = $emissora ORDER BY rand() limit 10");
	
	?>
	<ol class="widget-list">
	<h4 class="widget-title"><a href="?p=emissora">Profissional do Rádio</a></h4>
	
	<?php 
	foreach($apresentador->getResult() as $apresentador):
            $aprcodigo = $apresentador['aprcodigo'];
          //  $artista_tipos = new ArtistaTipo();
	//var_dump( $tipocodigo);
          ?>
          <li>
            <figure class="event-thumb">
                <h4 class="list-title"><a href="?p=emissora&id=<?=$apresentador['aprcodigo']?>"><?= $apresentador['aprnome']?></a></h4>
                <?php 
                $aprfoto = "admin/files/apresentador/" . trim($apresentador['aprfoto']);
                if (!file_exists($aprfoto) or !is_file($aprfoto)):
                $aprfoto = 'admin/files/imagem/user.png';
                endif;
                ?>

                <img src="<?=$aprfoto?>" width="100%" height="100%" alt="" />

                <div class="overlay icon-info-sign"></div>

                </a>
            </figure>
            <a  href="?p=emissora&id=<?=$apresentador['aprcodigo']?>" title="Mais sobre... <?=$apresentador['aprfuncao']?>" class="action-btn"><?=$apresentador['aprfuncao']?></a>
            </li>
            <?php 
            
              
            // var_dump($artista['artcodigo']);
	endforeach;?>
	</ol>
	</aside>
