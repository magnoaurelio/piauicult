<link rel="stylesheet" href="css/mystyle.css"
<link rel="stylesheet" href="css/bootstrap.min.css"

<div id="main-wrap">
    <div id="main" class="row">
        <div class="large-12 columns">
            <article class="post group">

                <div class="entry-content">
                    <div class="row">


                        <div class="large-8 columns">

                            <h2>O Piauícult </h2>
                            <?=(new Sobre())->descricao?>
                        </div>

                        <div class="large-4 columns">

                            <h2>Dados Estatísticos</h2>
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
                            ?>
                            <table class="table-piaui" >
                                <tr>
                                    <th>Artista</th>
                                    <td><i class="icon-star"></i>&nbsp;<?= $total->soma((new Artista())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>Discos</th>
                                    <td><i class="icon-play-circle"></i>&nbsp;<?=$total->soma((new Disco())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>Músicas</th>
                                    <td><i class="icon-music"></i>&nbsp;<?=$total->soma((new Musica())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>Cancioneiros/Encartes</th>
                                    <td><i class="icon-book"></i>&nbsp;<?=$total->soma((new Livro())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>Páginas de Encartes</th>
                                    <td><i class="icon-book"></i>&nbsp;<?=$total->soma((new Livro_Pagina())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>Galeria de Fotos</th>
                                    <td><i class="icon-picture"></i>&nbsp;<?=$total->soma((new Galeria_Foto())->getRowCount())?></td>
                                </tr>
                                 <tr>
                                    <th>Vídeos Musicais</th>
                                    <td><i class="icon-camera-retro"></i>&nbsp;<?=$total->soma((new Videos())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>Bandas e Gupos Musicais</th>
                                    <td><i class="icon-music"></i>&nbsp;<?=$total->soma((new Banda())->getRowCount())?></td
                                </tr>
                                <tr>
                                    <th>Projetos</th>
                                    <td><i class="icon-pencil"></i>&nbsp;<?=$total->soma((new Projetos())->getRowCount())?></td
                                </tr>
                                <tr>
                                    <th>Emissoras</th>
                                    <td><i class="icon-rss"></i>&nbsp;<?=$total->soma((new Emissora())->getRowCount())?></td>
                                </tr>
                                 <tr>
                                    <th>Apresentador(a)</th>
                                    <td><i class="icon-microphone"></i>&nbsp;<?=$total->soma((new Apresentador())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>Notícias</th>
                                    <td><i class="icon-globe"></i>&nbsp;<?=$total->soma((new Noticia())->getRowCount())?></td>
                                </tr>
                                 <tr>
                                    <th>Eventos</th>
                                    <td><i class="icon-globe"></i>&nbsp;<?=$total->soma((new Evento())->getRowCount())?></td>
                                </tr>
                                  <tr>
                                    <th>Locais de Eventos</th>
                                    <td><i class="icon-home"></i>&nbsp;<?=$total->soma((new EventoLocal())->getRowCount())?></td>
                                </tr>
                                
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;<?=$total->getValor()?></th>
                                </tr>

                            </table>
                        </div>

                    </div>



                    <!-- Meet the team -->

                    <h1 class="center">Equipe envolvida no <i>Projeto</i></h1>
                        <?php
                        try{
                            $url = 'http://piauicult.com.br/admin/api.php?method=getUsuarios&filter[]=equipe&filter[]==&filter[]=S';
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $usuarios = curl_exec($ch);
                            $usuarios = json_decode($usuarios);
                            curl_close($ch);
                        }catch (Exception $e){
                            die('Não foi possível carregar as Cidades devido :'.$e->getMessage());
                        }
                        $tamanho  = sizeof($usuarios);
                        $cont = 0;
                        if($usuarios) {
                            foreach ($usuarios as $usuario) {
                                $usuario = (object)$usuario;
                                if($cont++ % 4 == 0){
                                    echo "<div class='row'>";
                                }
                                $filename =  "admin/files/usuarios/$usuario->foto";
                                if (!file_exists($filename) or !is_file($filename)):
                                    $filename = 'admin/app/images/user.png';
                                endif;
                                ?>
                                <div class="large-3 columns myCard">
                                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                                        <div class="flipper">
                                            <div class="front">
                                                <div class="box" style="height: 400px;">

                                                    <p><img src="<?=$filename?>" alt="" width="100%" style="max-height: 250px;"></a>
                                                    </p>
                                                    <h5 style="text-align: center"><a href="#" title=""><?=$usuario->usual?></a></h5>
                                                    <p>
                                                        <i class="icon-phone"></i>
                                                        <strong>Contato:&nbsp;<?=$usuario->contato?></strong>

                                                    </p>
                                                    <p>
                                                        <i class="icon-envelope"></i>
                                                        <strong>Email:&nbsp;<?=$usuario->email?></strong>
                                                    </p>

                                                    <p>
                                                        <i class="icon-ok-sign"></i>
                                                        <strong>Função:&nbsp;<?=$usuario->funcao?></strong>
                                                    </p>

                                                    <!-- <a class="btn btn-social btn-facebook" href="#"><i class="icon-facebook"></i></a> <a class="btn btn-social btn-google-plus" href="#"><i class="icon-google-plus"></i></a> <a class="btn btn-social btn-twitter" href="#"><i class="icon-twitter"></i></a> <a class="btn btn-social btn-linkedin" href="#"><i class="icon-linkedin"></i></a>-->

                                                </div>
                                            </div>
                                            <div class="back">
                                                <div class="box" style="height: 400px;">
                                                    <h5 style="text-align: center"><a title=><?=$usuario->funcao?></a></h5>
                                                    <p style="text-align: justify"><?=$usuario->descricao?></p>

                                                    <!--    <a class="btn btn-social btn-facebook" href="#"><i class="icon-facebook"></i></a> <a class="btn btn-social btn-google-plus" href="#"><i class="icon-google-plus"></i></a> <a class="btn btn-social btn-twitter" href="#"><i class="icon-twitter"></i></a> <a class="btn btn-social btn-linkedin" href="#"><i class="icon-linkedin"></i></a>-->

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <?php
                                if($cont % 4  == 0 or $cont == $tamanho){
                                    echo "</div>";
                                }
                            }

                        }
                        ?>
                    </div>

                </div>
            </article>
        </div>
    </div>
</div>

        <script>
            document.querySelector(".myCard").classList.toggle("flip")
        </script>

