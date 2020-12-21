<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PainelAcordeon
 *
 * @author MAGNUSOFT-PC
 */
class PainelAcordeon extends Tag {
    
    

    public function __construct() {
        parent::__construct('div');
        $this->class = "panel panel-default";
    }

    /**
     * 
     * @param type $prenome - NOME DA PREFEITURA
     * @param type $precodigo - CODIGO DA PREFEITURA
     * @param type $prefeitoFoto -  FOTO DO PREFEITO
     */
    public function setTitleAmpar($prenome,$precodigo,$prefeitoFoto) {
        // DIV PRINCIPAL DO TITULO
        $div = new Tag('div');
        $div->class = 'panel-heading';
        $div->role = 'tab';
        
             
        $h4 =  new Tag('p');
        $h4->class = 'panel-title pt-painel-title';
 
        $link =  new Tag('a');
        $link->class = 'collapsed';
        $link->role = 'button';
            $data_toogle = 'data-toggle';
        $link->$data_toogle = 'collapse';
            $data_parent = 'data-parent';
        $link->$data_parent = '#accordion';
            $aria_expanded = 'aria-expanded';
        $link->$aria_expanded = 'false';
            $aria_controls = 'aria-controls';
        $link->$aria_controls = 'pre'.$precodigo;
        $link->href = '#pre'.$precodigo;
        $link->style = 'text-decoration:none';
        
        $img = new Tag('img');
        $img->src = $prefeitoFoto;
        $img->alt = 'foto';
        $img->style = 'width:50px; height:50px;';
        
        $link->add($img.'&nbsp;&nbsp;<strong>'.$prenome.'</strong>');
        $h4->add($link);
        $div->add($h4);        
        $this->add($div);
    }
    
    
    public function setBodyAmpar($param){
        $div = new Tag('div');
        $div->class = 'panel-collapse collapse';
        $div->role = 'tabpanel';
        $aria_expanded = 'aria-expanded';
        $div->$aria_expanded = 'false';
        $div->id = 'pre'.$param['precodigo'];        
        $body = new Tag('div');
        $body->class = 'panel-body';
        
        $body->add("");
        $div->add($body);

        $this->add($div);  
    }
    
    

}
