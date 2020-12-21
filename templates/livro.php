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
            <article class="post group"  style="margin-top:-15px;">   
                <header class="entry-top special-top"> 
               
                <div class="large-3 columns"  style="margin-top:0px;">
                    <select class="form-control selecao">
                        <option value="0" >Selecione todos os artistas</option>
                        <?php
                        $artistas = new Artista(null, "ORDER BY artusual ASC");
                        foreach ($artistas->getResult() as $artista) {
                            $selected = isset($_GET['id']) && $_GET['id'] == $artista['artcodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$artista['artcodigo']}>{$artista['artusual']}</option>";
                        }
                        ?>
                    </select>
                </div>
                 <h1 class="entry-title page-title"  style="margin-top:5px;"><img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;  
                     <a target="_blank" href="livro.php?livcodigo=<?= $livro['livcodigo'] ?>"> Discos & Encartes</a>
                 </h1>
              </header>   
            </article>
            </div>
        <article class="post group" style="margin-top:-30px;">
                <?php
                $livros = new Livro();
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                if($id){
                    $livros->ExeRead('livro', "WHERE (SELECT SUBSTRING_INDEX(disco.artcodigo,';',1) from disco where disco.discodigo = livro.livdisco) 
                    = :cod","cod={$id}");
                }
                $cont  = 0;
                if ($livros->getResult()):
                    foreach ($livros->getResult() as $livro):
                        $livro = new Livro($livro['livcodigo']);
                        $imgp = "admin/files/livros/" . trim($livro->livfoto);
                        if (!file_exists($imgp) or ! is_file($imgp)):
                            $imgp = 'admin/files/imagem/instrumento.png';
                        endif;
                        if($cont++ % 6 == 0){
                            echo '<ul class="list row">';
                        }


                    $artista = $livro->get_Artista();
                ?>
                    <li class="large-2 columns"style="margin-top:5px;" >
                        <div class="li-content" style="min-height: 230px; max-height: 230px;">
                            <figure class="event-thumb" style="min-height: 180px; max-height: 180px;">
                                <a target="_blank" href="livro.php?livcodigo=<?= $livro->livcodigo ?>" title="Ir para o ENCARTE:  <?= $livro->livnome ?> ">
                                    <img src="<?= $imgp ?>" with ="180" height="180" alt="" />
                                    <div class="overlay icon-info-in"></div>
                                </a>
                            </figure>
                            <h4 class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.1px;">
                                <a href="?p=album&id=<?= $livro->livdisco ?>"  title="Ir para o DISCO:  <?= $livro->livnome ?> ">
                                    <?= $livro->livnome ?>
                                </a>
                            </h4>
                            <a class="action-btn" href="?p=artist&id=<?= $artista->artcodigo ?>"  title="Ir para o ARTISTA:  <?=  $artista->artusual ?> ">
                                <?= $artista->artusual?>
                            </a>
                        </div>
                    </li>
                <?php
                        if($cont % 6 == 0 || $cont == $livros->getRowCount()){
                            echo '</ul>';
                        }
                    endforeach;
                endif;
                ?>
          </article>
        </div>
        <!-- /large-12 -->
    </div>
    <!-- /main -->

<!-- /main-wrap -->
<script>
    $('.selecao').change(function(e) {
        if (this.value == 0) {
            top.location.href = "?p=livro";
        } else {
            top.location.href = "?p=livro&id=" + this.value;
        }
    });
</script>