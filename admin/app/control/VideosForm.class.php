<?php
/**
 * VideosForm Form
 * @author  <your name here>
 */
class VideosForm extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TQuickForm('form_Videos');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Videos Diversos');
       


        // create the form fields
        $vidcodigo = new TEntry('vidcodigo');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual} - {artcodigo}','artusual');
        $vidurl = new TEntry('vidurl');
        $vidfoto = new Adianti\Widget\Form\TFile('vidfoto');
        $vidtipo = new TCombo('vidtipo');
        $vidpublica = new \Adianti\Widget\Form\TDate('vidpublica');
        $viddescricao = new TEntry('viddescricao');
        
        
        $vidtipo->addItems(DadosFixos::TipoVideo());

        // $getid = TSession::getValue('userid');
         // incluir foto do ARTISTA
        $getid = TSession::getValue('userid');
        $data_now = date('dmYHis');
        
        $nome_arquivo = 'VID_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $vidfoto->setParametros('files/video/',$nome_arquivo,$permite); 
        // add the fields
        $this->form->addQuickField('Codigo', $vidcodigo,  100 );
        $this->form->addQuickField('Artista', $artcodigo,  300 );
        $this->form->addQuickField('URL', $vidurl,  600 , new TRequiredValidator);
        $this->form->addQuickField('Publicação', $vidpublica,  300 );
        $this->form->addQuickField('Imagem', $vidfoto,  '100%' );
        $this->form->addQuickField('Tipo', $vidtipo,  300 );
        $this->form->addQuickField('Descrição', $viddescricao,  '100%' );

        if (!empty($vidcodigo))
        {
            $vidcodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('VideosList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Vídeos Form', $this->form));
        
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
            TTransaction::open('conexao'); // open a transaction
            
            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/
            
            $this->form->validate(); // validate form data
            
            $object = new Videos;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            if (!$object->viddata){
                $object->viddata = date("Y-m-d");
            }
            $object->store(); // save the object
            
            // get the generated vidcodigo
            $data->vidcodigo = $object->vidcodigo;
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
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
                $object = new Videos($key); // instantiates the Active Record
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
