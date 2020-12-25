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
<div id="main-wrap" >
    <div id="main" class="row">
        
         <div class="large-12 columns">
            <article class="post group">   
                <header class="entry-top special-top"> 
                    
                    <div class="large-3 columns" >
                        
                    <select class="form-control selecao">
                        <option value="0">Selecione um Gênero Musical</option>
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
                    //    $generos = new Read();
                       // $generos->ExeRead("genero", "ORDER BY genero ASC" );
                       $generos = new Genero(null, "ORDER BY genero ASC");
                        var_dump($generos);
                        $generomusicas = [];
                        foreach ($generos->getResult() as $genero) {
                            $generomusicas[] = $genero['gencodigo'];
                            $selected = isset($_GET['ID']) && $_GET['ID'] == $genero['gencodigo'] ? 'selected=selected' : "";
                            echo "<option {$selected} value={$genero['gencodigo']}>{$genero['gennome']}</option>";
                        }
                        ?>
                    </select>
                  </div>
                  <h1 class="entry-title page-title" style="margin-top:-5px;"><img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                      <a href="?p=genero&gencodigo=<?= $genero->gencodigo ?>"> Musicas & Generos

                      </a>
                  </h1>
                </header>   
            </article>
         </div>
       

       
        <!-- /large-12 -->
    </div>
    <!-- /main -->
</div>
<!-- /main-wrap -->
<script>
    $('.selecao').change(function (e) {
        if (this.value == 0) {
            top.location.href = "?p=artista-genero";
        } else {
            top.location.href = "?p=artista-genero&ID=" + this.value;
        }
    });
</script>