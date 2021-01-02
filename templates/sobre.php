<link rel="stylesheet" href="css/mystyle.css"
<link rel="stylesheet" href="css/bootstrap.min.css"
<br>
<br>
<?php
$api = new Api();
$filter = new Filter("precodigo", "<=", 224);
$prefeituraService = new PrefeituraService($api->getPrefeitura([$filter->getValue()]));

?>
<div id="main-wrap" style="margin-top: -10px">
    <div id="main" class="row">
        <div class="large-12 columns" style="margin-top: -10px">
             <article class="post group">   
                <header class="entry-top special-top"> 
                   
                  <h1 class="entry-title page-title" style="margin-top:5px;">
                      <img src="images/piauicult.jpg" width="80" alt="" />&nbsp;&nbsp;&nbsp;
                      <a href="#"> Sobre o PIAUICult.</a>
                  </h1>
                </header>   
            </article>
             </div>
            <article class="post group" style="margin-top: -30px">

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
                                    <th><a title="Listagem dos ARTISTAS Alfabética" href="?p=artistas">01-Artistas</a></th>
                                    <td><i class="icon-star"></i>&nbsp;<?= $total->soma((new Artista())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Cadastro de DISCOS em que o ARTISTAS participaram" href="?p=disco">02-Discos</a></th>
                                    <td><i class="icon-play-circle"></i>&nbsp;<?=$total->soma((new Disco())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Listagem das MÚSICAS Alfabética" href="?p=musicas">03-Músicas</a></th>
                                    <td><i class="icon-music"></i>&nbsp;<?=$total->soma((new Musica())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Listagem de ENCARTES/CANCIONEIROS anexos ao CD do Artista" href="?p=livro">04-Cancioneiros/Encartes</a></th>
                                    <td><i class="icon-book"></i>&nbsp;<?=$total->soma((new Livro())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Listagem de PÁGINAS de ENCARTES/CANCIONEIROS anexos ao CD do Artista" href="?p=livro">05-Páginas de Encartes</a></th>
                                    <td><i class="icon-book"></i>&nbsp;<?=$total->soma((new Livro_Pagina())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Galerias de Fotos e Imagens dos ARTISTAS" href="?p=galeria">06-Galeria de Fotos</th>
                                    <td><i class="icon-picture"></i>&nbsp;<?=$total->soma((new Galeria_Foto())->getRowCount())?></td>
                                </tr>
                                 <tr>
                                     <th><a title="Listagem dos VÍDEOS realizados sobre os ARTISTAS" href="?p=videos">07-Vídeos Diversos</a></th>
                                    <td><i class="icon-camera-retro"></i>&nbsp;<?=$total->soma((new Videos())->getRowCount())?></td>
                                </tr>
                                
                                
                                <tr>
                                    <th><a title="Listagem de GRUPOS DIVERSOS..." href="?p=bandas">08-Gupos Diversos</a></th>
                                    <td><i class="icon-music"></i>&nbsp;<?=$total->soma((new Banda())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a href="?p=projetos" title="Cadastro de PROJETOS CULTURAIS das Cidades" >09-Projetos</a></th>
                                    <td><i class="icon-pencil"></i>&nbsp;<?=$total->soma((new Projetos())->getRowCount())?></td>
                                </tr>
                                
                                <tr>
                                    <th><a title="Emissoras das Cidades Cadastradas no PIAUICult" href="?p=emissora">10-Emissoras</a></th>
                                    <td><i class="icon-rss"></i>&nbsp;<?=$total->soma((new Emissora())->getRowCount())?></td>
                                </tr>
                                 <tr>
                                    <th><a title="Apresentadores das EMISSORAS das Cidades Cadastradas no PIAUICult" href="?p=emissora">11-Apresentador(a)</a></th>
                                    <td><i class="icon-microphone"></i>&nbsp;<?=$total->soma((new Apresentador())->getRowCount())?></td>
                                </tr>
                                 <tr>
                                    <th><a title="Programação das EMISSORAS das Cidades Cadastradas no PIAUICult" href="?p=emissora">12-Programação</a></th>
                                    <td><i class="icon-microphone"></i>&nbsp;<?=$total->soma((new Programacao())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Listagem de NOTÍCIAS Publicadas de ARTISTAS" href="?p=noticias">13-Notícias</a></th>
                                    <td><i class="icon-globe"></i>&nbsp;<?=$total->soma((new Noticia())->getRowCount())?></td>
                                </tr>
                                 <tr>
                                     <th><a title="Listagem de EVENTOS Realizadas pelos ARTISTAS"href="?p=events">14-Eventos</a></th>
                                    <td><i class="icon-globe"></i>&nbsp;<?=$total->soma((new Evento())->getRowCount())?></td>
                                </tr>
                                  <tr>
                                      <th><a title="Cadastro de LOCAIS DE EVENTOS dos 224 Cidades usados pelos ARTISTAS"href="?p=locais">15-Locais de Eventos</a></th>
                                    <td><i class="icon-home"></i>&nbsp;<?=$total->soma((new EventoLocal())->getRowCount())?></td>
                                </tr>
                                   <tr>
                                      <th><a title="Cadastro de 224 CIDADES naturalidade dos ARTISTAS"href="?p=cidades">16-Cidades</a></th>
                                    <td><i class="icon-home"></i><?=$total->soma(sizeof($prefeituraService->getPrefeituras()))?></td>
                                </tr>
                                <tr>
                                    <th><a title="Cadastro de FESTIVAIS CULTURAIS das Cidades" href="?p=festivais">17-Festivais</a></th>
                                    <td><i class="icon-music"></i>&nbsp;<?=$total->soma((new Festival())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Cadastro de INTRUMENTOS MUSICAIS dos Artístas" href="?p=instrumentos">18-Instrumentos Musicais</a></th>
                                    <td><i class="icon-music "></i>&nbsp;<?=$total->soma((new Instrumento())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Registros de Humor" href="?p=festivais-humor">19- Humor</a></th>
                                    <td><i class="icon-smile"></i>&nbsp;<?=$total->soma((new Humor())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a title="Registros de Cinema" href="?p=festivais-cinema">20- Cinema</a></th>
                                    <td><i class="icon-film "></i>&nbsp;<?=$total->soma((new Cinema())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a href="?p=artista-genero" title="Cadastro de GÊNEROS MUSICAIS das Músicas" >21-Gêneros Musicais</a></th>
                                    <td><i class="icon-headphones"></i>&nbsp;<?=$total->soma((new Genero())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th><a href="?p=links" title="Cadastro de LINKS CULTURAIS das Cidades" >22-Links Culturais</a></th>
                                    <td><i class="icon-globe"></i>&nbsp;<?=$total->soma((new Links())->getRowCount())?></td>
                                </tr>
                                <tr>
                                    <th>&nbsp;Itens Publicados no PIAUICult</th> 
                                    <th>&nbsp;<?=$total->getValor()?></th>
                                </tr>
                            </table>
                        </div>

                    </div>



                    <!-- Meet the team -->

                    <h1 class="center">Colaboradores no <i>Projeto</i></h1>
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

<script>
    document.querySelector(".myCard").classList.toggle("flip")
</script>

