<br/> 
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns">
            <article class="post group"> 
            <header class="entry-top special-top">
                 <div class="large-3 columns" style="margin-top:3px;">  
                    <select class="form-control selecao">
                        <option value="0">Selecione um Grupo Musical</option>
                        <?php
                        $bandasTipo = new BandaTipo(null, "ORDER BY bantiponome ASC");
                        foreach ($bandasTipo->getResult() as $bandatipo) {
                            $selected = isset($_GET['id']) && $_GET['id'] == $bandatipo['bantipocodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$bandatipo['bantipocodigo']}>{$bandatipo['bantiponome']}-{$bandatipo['bantiponome']}</option>";
                        }
                        ?>
                    </select>
                   </div>
                       <h1 class="entry-title page-title" style="margin-top:5px;">
                         <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                         <a href="?p=artist&id=<?= $artista->artcodigo ?>"><a href="#">Grupos Diversos</a></a>
                     </h1>
               
            </header>   
            </article>
        </div>
        <article class="post group" style="margin-top:-30px;">
             <ul class="list row" style="margin-left: 10px;  margin-right: 10px;">
                <?php
                $tipo = isset($_GET['id']) ? "WHERE  bantipocodigo = ".$_GET['id'] : null;
                $bandas = new Banda(null, $tipo);
                $cont  = 0;
                if ($bandas->getResult()):
                    foreach ($bandas->getResult() as $banda):
                        $banda  = new Banda($banda['bancodigo']);
                        $imgp = "admin/files/bandas/$banda->banfoto1";
                        if (!file_exists($imgp) or !is_file($imgp)):
                            $imgp = 'admin/files/imagem/instrumento.png';
                        endif;
                        if($cont++ % 4== 0){
                            echo '<ul class="list row">';
                        }
                ?>
                    <li class="large-3 columns" style="margin-top:10px;" >
                        <div class="li-content" style=" max-width: 280px; min-height: 220px;">
                            <figure class="event-thumb" style="max-width: 270px; min-height: 150px;  "> <a href="?p=banda&id=<?= $banda->bancodigo ?>">
                                    <img src="<?= $imgp ?>" with ="170" height="270" alt="" />
                                    <div class="overlay icon-info-in"></div>
                                </a>
                            </figure>
                            <h4 class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.1px;">
                                <a href="?p=banda&id=<?= $banda->bancodigo ?>"><?= $banda->bannome ?></a>
                            </h4>

                        </div>
                    </li>
                <?php
                        if($cont % 4 == 0 || $cont == $bandas->getRowCount()){
                            echo '</ul>';
                        }
                    endforeach;
                endif;
                ?>
            </ul>
           </article>
     </div> <!-- / row -->
</div>  <!-- /main-wrap -->

<script>
    $('.selecao').change(function(e) {
        if (this.value == 0) {
            top.location.href = "?p=bandas";
        } else {
            top.location.href = "?p=bandas&id=" + this.value;
        }
    });
</script>