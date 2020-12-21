<?php

class Layout {

    static function Painel($titulo = 'Painel', $conteudo = "content", $rodape = null, $class = 'panel-default') {
        $painel = new TElement('div');
        $painel->class = 'painel ' . $class;

        $header = new TElement('div');
        $header->class = 'panel-heading padrao';

        $title = new TElement('div');
        $title->class = 'panel-title';
        $title->add($titulo);
        $header->add($title);

        $body = new TElement('div');
        $body->class = 'panel-body';
        $body->add($conteudo);
        $painel->add($header . $body);

        if ($rodape != null) {
            $footer = new TElement('div');
            $footer->class = 'panel-footer';
            $footer->add($rodape);
            $painel->add($footer);
        }
        return $painel;
    }

    static function LinkItem($class, $value, $icone) {
        $link = new TElement('a');
        $link->class = 'list-group-item';
        $link->generator = 'adianti';
        $link->href = 'index.php?class=' . $class;
        $link->add('<span class="glyphicon glyphicon-' . $icone . '"></span> ' . $value);

        return $link;
    }

    static function onRow() {
        $row = new TElement('div');
        $row->class = 'row';
        return $row;
    }

    static function onCol_lg($lg = 6) {
        $col = new TElement('div');
        $col->class = 'col-lg' . $lg;
        return $col;
    }

    static function onImg($img, $w = null, $h = null, $class = 'img-round', $lightbox = false) {
        $img = new TElement('img');
        $img->class = $class;
        $img->width = $w;
        $img->heiht = $y;
        $img->heiht = $y;
        if ($lightbox) {
            $a = new TElement('a');
            $data_light = 'data-lightbox';
            $a->$data_light = $img;
            $a->href = $img;
            $a->add($img);
            return $a;
        } else {
            return $img;
        }
    }

    static function Link($href = null, $title = null, $target = null) {
        $a = new TElement('a');
        $a->href = $href;
        $a->title = $title;
        $a->target = $target;
        return $a;
    }

    static function getAtivo($value) {
        $class = ($value) ?  'success' : 'danger';
        $label = ($value) ? _t('Yes') : _t('No');
        $div = new TElement('span');
        $div->class = "label label-{$class}";
        $div->style = "text-shadow:none; font-size:12px; font-weight:lighter";
        $div->add($label);
        return $div;
    }

}
