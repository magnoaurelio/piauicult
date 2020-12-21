<?php
/**
 * LivroPaginaForm Form
 * @author  <your name here>
 */
class LivroPaginaForm extends TWindow
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setTitle("Adicionar Páginas");
        parent::setSize(600,250);
        
        // creates the form
        $this->form = new TQuickForm('form_LivroPagina');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form tit
        


        // create the form fields
        $arquivo = new TFile('arquivo');

        $arquivo->setParametros('files/livros/auxpag/',null,array('zip'));
        // add the fields
        $this->form->addQuickField('Arquivo (.zip)', $arquivo,  400 , new TRequiredValidator);




        if (!empty($id))
        {
            $id->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction('Adicionar Páginas', new TAction(array($this, 'onSave')), 'fa:floppy-o green fa-lg');

        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Páginas', $this->form));
        
        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
        try
        {
            $this->form->validate(); // validate form data
            
             $path =  'files/livros/auxpag/';
             $arquivo = $path.$param['arquivo'];
             $extrair  = Zip::extrairPara($arquivo,$path);
            if($extrair){
               unlink($arquivo);
            $param['path'] = $path;
       
           $this->setPaginas($param);
            new TMessage('success','Processamento Concluído com sucesso!');
           }
             parent::closeWindow();
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    
     function setPaginas($param){
        TTransaction::open('conexao');
           $arq = ArquivosZIP::ArquivosDir($param['path']);  
           $path = 'files/livros/paginas/'; 
           $cont =  0;
           foreach($arq as $val){
              $cont ++;
              $name = $this->sanitizeString(utf8_decode($val));
              $pos = strripos($val,'.');
              $pagina = new LivroPagina();
              $pagina->descricao = substr($val,0,$pos);
              $pagina->numero = $cont;
              $pagina->livcodigo = TSession::getValue('livcodigo');
              $pagina->arquivo = $name; 
              $pagina->store();        
             ArquivosZIP::Move($param['path'].$val,$path.$pagina->arquivo);
           } 
        TTransaction::close(); 
    }
    
    
    function sanitizeString($string) {

            // matriz de entrada
            $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º');
        
            // matriz de saída
            $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
        
            return str_replace($what, $by, $string);
        }
    
    
    function onLoad($param){
        TSession::setValue('livcodigo',$param['livcodigo']);
    }
    
    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(TRUE);
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('conexao'); // open a transaction
                $object = new LivroPagina($key); // instantiates the Active Record
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}
