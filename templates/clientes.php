<div id="main-wrap" style="margin-top: -10px;">
    <div id="main" class="row">

    <section class="events-section">
        <article class="post group" style="padding-left: 50px; padding-bottom: 50px;">
              <h2>
                    <div class="large-12 columns" style="margin-top:3px;"> 
                       <img src="images/lupa.png" width="35" height="35" alt="lupa" />   <a target="_blank" href="admin/"><img src="images/compras.png" width="150" height="80"></a>                       
                        Compras: <a href="#">CLIENTES & PRODUTOS</a>
                        &nbsp;&nbsp;&nbsp; <a href="?p=artist&id=<?= $artista->artcodigo ?>">
                        &nbsp;&nbsp;&nbsp;
                        </a>
                         
                         <div class="large-3 columns" style="margin-top:30px;"> 
                         <select class="form-control selecao">
                             <option value="0">Selecione Lote e Produto  </option>
                             <?php
                             $clinteProduto = new ClienteProduto(null, "ORDER BY clipronome ASC");
                            
                             foreach ($clinteProduto->getResult() as $clinteproduto) {
                                 $selected = isset($_GET['id']) && $_GET['id'] == $clinteproduto['cliprocodigo'] ? 'selected=selected' : "";
                                 echo "<option {$selected} value={$clinteproduto['cliprocodigo']}>{$clinteproduto['cliprocodigo']}-{$clinteproduto['clipronome']}</option>";
                                 
                             }
                            
                             ?>
                         </select>
                       
                      </div>
                    </div>
               </h2>   

            
         
     <div class="large12 columns" style="margin-top:3px;">    
   <article class="post group">
    <h5>Colaboradores / Adquirentes</h5>
    <table class="table"  width="100%" border="0">				
        <thead  class="table-striped" style="text-align: left;">
            <tr style="background:#0099ff; color:#ffffff;">
                  <th with="20">Nº</th>
                  <th with="50" scope="col" style="text-align: center;">Lote</th>
                  <th with="100" >Produto</th>
                  <th with="50" >Foto</th>
                  <th with="100" >Nome</th>
                  <th with="50" scope="col">Sexo</th>
                  <th with="50" scope="col">Modêlo</th>
                  <th with="30" scope="col">Cor</th>
                  <th with="50" scope="col">Tamanho</th>
                  <th with="50" scope="col">Dt Compra</th>
                  <th with="50" scope="col">Qte</th>
                  <th with="50" scope="col">Valor R$</th>
                  <th with="50" scope="col">Pago</th>
                </tr>
          </thead>

        <?php
      //  $produto = new cliente_produto();
      //  $cliprocodigo = $produto->cliprocodigo;
    //    $discodigo = Disco::getCliente($cliente['discodigo']);
       $q = 1;
       $t = 0;
       $v = 0;
       $p = 0;
       $cont  = 0;
      
       $cliprocodigo= isset($_GET['id']) ? "WHERE  cliprocodigo = ".$_GET['id']  : null;
       $clientes = new Cliente(null, $cliprocodigo);
       
  //     $clientes = new Cliente(null,"WHERE cliprocodigo = 2 ");
     //  $clientes = new Cliente(null);
        if ($clientes->getResult()):
          foreach ($clientes->getResult() as $cliente):
            $cliente = new Cliente($cliente["clicodigo"]);
            $clinome =  $cliente->clinome;
            $clifoto =  $cliente->clifoto;
            $cliimagem =  $cliente->cliimagem;
            $foto = "admin/files/clientes/" . trim( $cliente->clifoto);
            $imagem = "admin/files/clientes/" . trim( $cliente->cliimagem);
            $clidata =  $cliente->clidata;
            $clidatacompra =  $cliente->clidatacompra;

            //$clidata= setMask("dd/mm/yyyy");
            //$clidatacompra->setMask("dd/mm/yyyy");

            $artista = $cliente->getArtista();

             ?>
              <tbody>
                <tr>
                    <td with="20" scope="row" ><?= $q?></td>
                     <td with="60"><?= $cliente->clilote ?></td>
                     <td with="50"><?=  $cliente->getClienteProduto()->clipronome ?></td>
                      <td with="60">
                           <h4 class="list-subtitle" style="margin-bottom: 3px; letter-spacing: 0.1px;">
                               <a href="?p=artist&id=<?= $artista->artcodigo ?>" title="Veja a Página do <?= $artista->artusual ?> "><img src="<?= $artista->foto ?>" width="40" alt="" /></a>
                            </h4>
                          
                      </td>
                      <td with="60">
                          <small>Resp:</small><a href="?p=artist&id=<?= $artista->artcodigo ?>" title="Veja a Página do <?= $artista->artusual ?> "> <?= $artista->artusual ?></a><br/>
                          <small>Impr:</small><strong> <?= $cliente->cliusual ?></strong>
                      </td>
                      <td with="50" style="text-align: center;"><?=  $cliente->clisexo?></td>
                      <td with="50"> 
                          <a href="<?= $foto ?>" data-rel="prettyPhoto" title="Clik e Veja o modelo: <?=  $cliente->getClienteProduto()->clipronome ?>">
                        <?php if (!file_exists($foto) or ! is_file($foto)): ?>                                                                                  
                            <img src="images/piauicult.jpg" width="25" right ="25" alt="" />
                        <?php else: ?>
                            <img src="<?= $foto ?>" width="40" alt="" />
                          
                        <?php 
                       
                        endif; ?>
                        
                       </a> 
                  </td>
                  <td with="30"><?= $cliente->clicor?></td>
                  <td with="50" style="text-align: center;"><?=  $cliente->clitamanho ?></td>
                  <td with="50"><?= date('d/m/Y',strtotime($cliente->clidatacompra)) ?></td>
                  <td with="20" style="text-align: center;"><?=  $cliente->cliquantidade ?></td>
                  <td with="50" style="text-align: center;"><?= number_format($cliente->clivalor,2, ',', '.') ?> </td>
                  <td with="50"> <a href="#>" data-toggle="modal" data-target="#modal<?=$cliente->clicodigo?>" class="">
                        <?php if (!file_exists($imagem) or ! is_file($imagem)): ?>                                                                                  
                            <img src="images/piauicult.jpg" width="25" alt="" />
                        <?php else: ?>
                            <!--img src="<?= $imagem ?>" width="40" alt="" /-->
                             <img src="images/OK.jpg" width="25" alt="" />
                        <?php
                         $p= $p+$cliente->clivalor;
                         endif; ?>
                       </a> 
                  </td>
                </tr>

              </tbody>

            <?php
            $q++;
            $t= $t+$cliente->clivalor;
        endforeach;
          endif;
        ?>

        <tfoot  class="table-striped ">
            <tr style="background:#0099ff; color:#ffffff;">
                  <th with="20"></th>
                  <th with="100" ></th>
                  <th with="50" ></th>
                  <th with="100" ></th>
                  <th with="50" scope="col"></th>
                  <th with="50" scope="col"></th>
                  <th with="50" scope="col"></th>
                  <th with="50" scope="col"></th>
                  <th with="50" scope="col"></th>
                  <th with="50" scope="col"></th>
                  <th with="50" scope="col"><?= $q-1 ?></th>
                  <th with="50" scope="col"  style="text-center: right;"><?= number_format($t,2, ',', '.') ?></th>
                  <th with="50" scope="col"  style="text-center: right;"><?= number_format($p,2, ',', '.') ?></th>
                </tr>
         </tfoot>

    </table>
      
</div>
         </section>
     </article>
    </div>
</div><!-- /main-wrap -->
<script>
    $('.selecao').change(function(e) {
        if (this.value == 0) {
            top.location.href = "?p=clientes";
        } else {
            top.location.href = "?p=clientes&id=" + this.value;
        }
    });
</script>
