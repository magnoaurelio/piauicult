<?php
/**
 * EdicaoForm Registration
 * @author  <your name here>
 */
class VideoView extends TWindow
{
    protected $form; // form
    
    use Adianti\Base\AdiantiStandardFormTrait; // Standard form methods
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        parent::setSize(800,620);
   
        
        
    }
    
    function onLoad($param){
      try{
       TTransaction::open('conexao');
        $video = new Videos($param['key']);
        $iframe = new TElement('iframe');
        $pos = strripos($video->vidurl, "v=");
            if ($pos):
                $url = substr($video->vidurl, $pos + 2, 11);
            else:
                $pos = strripos($video->vidurl, ".be/");
                if ($pos):
                    $url = substr($video->vidurl, $pos + 4, 11);
                else:
                    throw new Exception("Problemas com a URL do vídeo");
                endif;
            endif;
        $iframe->src ="https://www.youtube.com/embed/{$url}"; 
        $iframe->class = 'table';   
        $iframe->style = 'height:84%; backgroud-color:#FDAADA';
        $iframe->name="ifr";
       
        $this->form = new TQuickForm('form_Videos');
        $this->form->class = 'tform'; // change CSS class
        
        $this->form->style = 'display: table;width:100%'; // change style
        $idvideo = new TAction(array($this, 'onLiberar'));
        $idvideo->setParameter('key',$video->vidcodigo);
        $this->form->addQuickAction('Liberar',$idvideo , 'fa:ok-sign');
        parent::add($iframe);
        parent::add($this->form);
        TTransaction::close();
       }catch(Exception $e){ new TMessage('warning',$e->getMessage());} 
    }
    
    
    function onLiberar($param){
       try{
       TTransaction::open('conexao');
        $video = new Videos($param['key']);
        $video->vidliberado = 1; 
        $video->store();      
        TTransaction::close();
       }catch(Exception $e){ new TMessage('warning',$e->getMessage());} 
       parent::closeWindow();
    }
}
