<?php
$api = new Api();
if (isset($_GET['precodigo'])) {
    $filterAmpar = new Filter("precodigo", "=", $_GET['precodigo']);
} else {
    $filterAmpar = new Filter("precodigo", "<=", 224);
}
$prefeituraService = new PrefeituraService($api->getPrefeitura([$filterAmpar->getValue()]));
?>
<style>
    td {
        border-collapse: collapse;
    }

    .disco-logo {
        float: left;
    }

    .artistas-container {
        width: 100%;
        padding: 10px;
    }
</style>
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns">
            <article class="post group">   
                <header class="entry-top special-top"> 
                 <div class="large-3 columns" >  
                    <select class="form-control selecao" onchange="selectCidade(this.value)">
                        <option value="0">Selecione uma Cidade</option>
                        <?php
                        foreach ($prefeituraService->getPrefeituras() as $prefeitura) {
                            $selected = isset($_GET['id']) && $_GET['id'] == $prefeitura->precodigo ? 'selected=selected' : "";
                            echo "<option {$selected} value={$prefeitura->precodigo}>{$prefeitura->prenome}</option>";
                        }
                        ?>
                    </select>

                    
                   </div>
                       <h1 class="entry-title page-title" style="margin-top:5px;">
                         <img src="images/lupa.png" width="35" height="35" alt="lupa" />&nbsp;&nbsp;&nbsp;
                         <a href="?p=artist&id=<?= $artista->artcodigo ?>">
                             <a href="#">Cidades & Emissoras</a>
                         </a>
                     </h1>
               
            </header>      
             </article>
        </div>
        
             
       
    </div><!-- /main -->
</div><!-- /main-wrap -->>
   
        <!-- /large-12 -->
    <!-- /main -->
     <script>
        function selectCidade(precodigo) {
            top.location.href = "?p=emissora&id="+ precodigo
        }
    </script>
