<div id="main-wrap" style="margin-top: -10px;">
    <div id="main" class="row">

        <section class="events-section">
            <article class="post group" style="padding-left: 50px; padding-bottom: 50px;">
                <div class="single_post_content">
                    <h2>
                        <span>
                            <a target="_blank" href="admin/"><img src="images/contato.png"></a>                       
                        </span>
                        <span> - FALE CONOSCO</span>

                        <span class="foto">
                            <img src="" style="display: none; float: right; margin-right: 20%; border: 5px double #0270A3; " id="foto" width="120" height="120">
                        </span>
                    </h2>

                </div>


                <?php
                $param = $_POST;
                if (isset($param['email']) && !empty($param['email'])):
                    try {

                        if ($_POST['verer'] == 1):
                            $artista = new Artista($_POST['artcodigo']);
                            // se existe email então pega o email    
                            if ($artista->artemail):
                                $email['email'] = $artista->artemail;
                                $email['nome'] = $artista->artnome;
                            else:
                                throw new Exception("Email do artista não cadastrado entre em contato direto com a Piaui Cult!");
                            endif;
                        // se não direcionar a um vereador
                        else:
                            $email['email'] = "magnusoft1@hotmail.com";
                            $email['nome'] = "Piaui Cult";
                        endif;


                        $param['assunto'] = "FALE CONOSCO - PIAUI CULT";
                        $param['msg'] = "Fale conosco!</b><br><b>Nome Usuário: </b> {$param['nome']} <br><b>Telefone:</b> {$param['telefone']}<br> <b>Email do Usuário: {$param['email']}</b><br><b>Cidade:</b> {$param['cidade']}<br><b>Mensagem:</b> {$param['mensagem']}";

                        // É necessário indicar que o formato do e-mail é html
                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .= "From: " . $param['nome'] . " <" . $param['email'] . ">";
                        //$headers .= "Bcc: $EmailPadrao\r\n";
                        $enviaremail = mail($email['email'], $param['assunto'], $param['msg'], $headers);
                        if (!$enviaremail) {
                            throw new Exception("Erro ao Enviar");
                        }
                        $msg = "{$param['nome']}! Obrigado por entrar em contato conosco retornaremos o mais breve possível!";
                    } catch (Exception $e) {
                        $msg = "{$e->getMessage()}";
                    }
                    ?>

                <div class="modal fade" style="margin-top: 100px;" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Fale Conosco</h4>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        <?= $msg ?>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                endif;
                ?>



                <form id="form-solicitar" action="?p=contato" method="post">


                    <div class="form-group form-horizontal">
                        <label id="ver">Deseja direcionar a solicitação a um Artista?
                            <input name="verer" type="radio" value="1"> Sim 
                            <input name="verer" checked="" type="radio" value="0"> Não
                        </label>
                    </div>

                    <div class="form-group" id="div_vereador">
                        <label for="vereador">Artista</label>
                        <select class="form-control"  style="width: 80%;" id="Artista"   name="artcodigo">
                            <option value="0">Selecione um Artista</option>     
                            <?php
                            $artistas = new Artista(null, "ORDER BY artusual ASC");
                            foreach ($artistas->getResult() as $artista) {
                                $artista = new Artista($artista['artcodigo']);
                                echo "<option  value='{$artista->artcodigo}'>{$artista->artusual}</option>";
                            }
                            ?>   
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input name="nome" id="data_pub"  type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input name="telefone" id="data_pub"  type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input name="cidade" id="data_pub"  type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" id="data_pub"  type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Mensagem</label>
                        <textarea name="mensagem" id="data_pub" style="width: 80%; height: 150px;" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label id="equacao" for="tipo"> Qual o resultado?</label>
                        <input name="resultado" id="resultado"  type="text" class="form-control">
                    </div>

                    <a onclick="ValidaForm()" class="btn btn-success"><i class="fa fa-send-o"></i> Enviar</a>
                </form> 
            </article>
        </section>

    </div>
</div><!-- /main-wrap -->

<script>
    function getRandom(min, max) {
        return  Math.floor((Math.random() * max) + min);
    }


    var n1 = getRandom(0, 10);
    var n2 = getRandom(0, 10);
    $("#equacao").text("Qual o resultado? " + n1 + " + " + n2);
    $("input[name=verer]").change(function () {
        valor = $(this).val();
        if (valor == 1) {
            $("#div_vereador").fadeIn("slow");
        } else {
            $("#div_vereador").fadeOut("slow");
        }

    });

    $(document).ready(function () {

        $("#div_vereador").hide();
        $('#myModal').modal('show')
    });



    function ValidaForm() {
        if ($("#resultado").val() != n1 + n2) {
            alert("Resultado da operação " + n1 + " + " + n2 + " Inválido!");
            $("#resultado").val("");
            n1 = getRandom(0, 10);
            n2 = getRandom(0, 10);
            $("#equacao").text("Qual o resultado? " + n1 + " + " + n2);
        } else {
            $("#form-solicitar").submit();
        }
    }


    $("#Artista").change(function (e) {
        $.ajax({
            dataType: "json",
            url: "admin/api.php?method=PegaArtista",
            data: {artcodigo: this.value},
            success: function (data) {
                $("#foto").css('display', 'block');
                $("#foto").removeAttr("src");
                $("#foto").attr("src", "admin/files/artistas/" + data.artista['artfoto']);
            }
        });
    })



</script>





