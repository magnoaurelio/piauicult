<?php
/**
 * WelcomeView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006-2012 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class WelcomeView extends TPage
{
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        $html1 = new THtmlRenderer('app/resources/bemvindo_tela.html');
        $html2 = new THtmlRenderer('app/resources/bemvindo.html');

        $html1->enableSection('main', array());
        $html2->enableSection('main', array());
        

        
        $panel1 = new TPanelGroup('Bem-vindo:  '. TSession::getValue('username'));
        $panel1->add($html1);
        $panel2 = new TPanelGroup('Bom trabalho:  '. TSession::getValue('username'));
        $panel2->add($html2);
        // add the template to the page
        parent::add( TVBox::pack($panel1,$panel2) );
    }
}
