<?php include_once 'app/config/Config.php'; ?>
<?php

$edikey = $_REQUEST['livcodigo'];

$livro = new Livro($edikey);

$path_paginas = "admin/files/livros/paginas/";

//seta o índice atual da pagina 
$indice_pagina = 0;

//cria a lista responsável pelos os thumnails
$ul = new Tag("ul");

//cria um array para armazenar as paginas
$docs = array();

$read  = new Read();

$read->ExeRead("livro_pagina","WHERE livcodigo = :livro ORDER BY numero ASC","livro={$edikey}");

//percorre as paginas adicionando as no array docs
foreach ($read->getResult() as $pagina) :
    // atribui +1 nos indices
    $indice_pagina ++;
    $filename = "admin/files/livros/paginas/" . $pagina['arquivo'];
    //  add os dados da pagina no array docs
    $docs[] = $indice_pagina . ':"' . $path_paginas . $pagina['arquivo'] . '"';
    // cria uma mimitura para a pagina
    $ul = addNaLista($ul, $path_paginas . $pagina['arquivo'], $indice_pagina, $filename,"Pag.".$pagina['numero']);
endforeach;

// juntas os documentos em uma string separada por virgula
$paginas = implode(',', $docs);

// recupera o conteudo de um arquivo HTML

$content = $livro->livmostra == 1 ? file_get_contents("jornal/index_retrato.html") : file_get_contents("jornal/index_paisagem.html");
// substitui as variaveis
$content = str_replace('{PAGINAS}', $paginas, $content);
$content = str_replace('{TOTAL_PAGINAS}', $indice_pagina, $content);
$content = str_replace('{THUMBNAILS}', $ul, $content);

// mostra o conteudo do html
echo $content;

/**
 * FUNÇÃO RESPONSÁVEL PARA ADICIONAR OS THUMBNAILS NA LISTA
 * 
 * @param Tag $lista
 * @param string $img
 * @param int $page
 */
function addNaLista($lista, $filename, $page, $arquivo = null,$arquivo_titulo = null) {
    $img = new Tag("img");
    $img->src = $filename;
    $img->width = 76;
    $img->height = 76;
    $img->class = "page-" . $page;

    $span = new Tag("span");
    $span->add($page);

    $li = new Tag("li");
    $li->class = "i";

    $li->add($img);
    $li->add($span);
    if ($arquivo) {
        $li->add("<a href='" . $arquivo . "' target='_blank' title='".$arquivo_titulo."' class='file '><i class='fa fa-file-image-o blue'></i></a>");
    }
    $lista->add($li);
    return $lista;
}
