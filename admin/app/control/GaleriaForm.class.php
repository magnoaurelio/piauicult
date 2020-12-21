<?php
/**
 * GaleriaForm Form
 * @author  <your name here>
 */
class GaleriaForm extends TPage
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
        $this->form = new TQuickForm('form_Galeria');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Galeria');
        


        // create the form fields
        $galcodigo = new TEntry('galcodigo');
        $galcaption = new TEntry('galcaption');
        $galarquivo = new TFile('galarquivo');
        $galdata = new TDate('galdata');
        $galartista = new TDBCombo('galartista','conexao','Artista','artcodigo','artusual','artusual');
        $galdisco = new TDBCombo('galdisco','conexao','Disco','discodigo','{disnome}-{discodigo}','disnome');
           
        $galcodigo->setEditable(false);
        $galdata->setMask('dd/mm/yyyy');
        $galdata->setDatabaseMask('yyyy-mm-dd');
            
        $data_now = date('dmYHis');

        $getid = TSession::getValue('userid');

        $path =  'files/galeria/';
        if (!file_exists($path) or !is_dir($path)){
            mkdir($path);
        }

        $nome_arquivo = 'FOTO_'.$data_now.'_'.$getid;

        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');

        $galarquivo->setParametros($path,$nome_arquivo,$permite); 

         $galartista->enableSearch();
         $galdisco->enableSearch();
        
        // add the fields
        $this->form->addQuickField('Código', $galcodigo,  100 );
        $this->form->addQuickField('Legenda', $galcaption,  400 );
        $this->form->addQuickField('Arquivo', $galarquivo,  350 , new TRequiredValidator);
        $this->form->addQuickField('Data', $galdata,  200 );
        $this->form->addQuickField('Artista', $galartista,  400 );
        $this->form->addQuickField('Disco', $galdisco,  400 );




        if (!empty($galcodigo))
        {
            $galcodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('GaleriaList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Galeria Form', $this->form));
        
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
            
            $object = new Galeria;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
           // $object->galdata = TDate::date2us($object->galdata);
            $object->store(); // save the object
            
            // get the generated galcodigo
            $data->galcodigo = $object->galcodigo;
            
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
                $object = new Galeria($key); // instantiates the Active Record
             //   $object->galdata = TDate::date2us($object->galdata);
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
