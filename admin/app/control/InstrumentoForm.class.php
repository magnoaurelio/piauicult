<?php
/**
 * InstrumentoForm Form
 * @author  <your name here>
 */
class InstrumentoForm extends TPage
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
        $this->form = new TQuickForm('form_Instrumento');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
       $this->form->setFormTitle('Cadastro de Instrumento');
        
        // create the form fields
        $inscodigo = new TEntry('inscodigo');
        $insnome = new TEntry('insnome');
        $insassessorio1 = new TEntry('insassessorio1');
        $insassessorio2 = new TEntry('insassessorio2');
        $insassessorio3 = new TEntry('insassessorio3');
        $insquant = new TEntry('insquant');
        $insfoto = new TFile('insfoto');
        $inshistorico = new THtmlEditor('inshistorico');

//  caminho dos arquivos
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'INS_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $insfoto->setParametros('files/instrumento/',$nome_arquivo,$permite);

        // add the fields
        $this->form->addQuickField('Inscodigo', $inscodigo,  100 );
        $this->form->addQuickField('Intrumento', $insnome,  200 );
        $this->form->addQuickField('Assessorio1', $insassessorio1,  200 );
        $this->form->addQuickField('Assessorio2', $insassessorio2,  200 );
        $this->form->addQuickField('Assessorio3', $insassessorio3,  200 );
        $this->form->addQuickField('Quantidade', $insquant,  100 );
        $this->form->addQuickField('Imagem', $insfoto,  200 );
        $this->form->addQuickField('Histórico', $inshistorico, '100%' );


        
        if (!empty($inscodigo))
        {
            $inscodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar', new TAction(array('InstrumentoList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Instrumento Form', $this->form));
        
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
            
            $object = new Instrumento;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated inscodigo
            $data->inscodigo = $object->inscodigo;
            
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
                $object = new Instrumento($key); // instantiates the Active Record
                //var_dump($object->inscodigo);
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
