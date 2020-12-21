<?php

switch ($_POST['action']):
       case '':
        break;
endswitch;

function Upload() {
    $secretKey = "k3nthcnmpgvf5zd2rcnmzxtuzni0l58o";

    $signature = md5($secretKey . 'action' . $_POST['action'] . 'apiKey' . $_POST['apiKey'] . 'name' . $_POST['name'] . 'title' . $_POST['title']);

    echo json_encode(['signature' => $signature]);
}
