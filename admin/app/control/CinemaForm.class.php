<?php
/**
 * CinemaForm Form
 * @author  <your name here>
 */
class CinemaForm extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Cinema');
        $this->form->setFormTitle('Cinema Publicar');
        

        // create the form fields
        $cincodigo = new TEntry('cincodigo');
        $cinnome = new TEntry('cinnome');
        $cingenero = new \Adianti\Widget\Wrapper\TDBCombo('cingenero','conexao','CinemaGenero','codigo','descricao','descricao');
        $cinduracao = new TEntry('cinduracao');
        $cinsobre = new \Adianti\Widget\Form\THtmlEditor('cinsobre');
        $cindata = new \Adianti\Widget\Form\TDate('cindata');
        $fescodigo = new \Adianti\Widget\Wrapper\TDBCombo('fescodigo', 'conexao', 'Festival', 'fescodigo', 'fesnome','fesnome');
        $cinimagem = new \Adianti\Widget\Form\TFile('cinimagem');
        $fesprecodigo = new \Adianti\Widget\Wrapper\TDBCombo('fesprecodigo', 'conexao', 'Festival_Premio', 'fesprecodigo', 'fesprenome','fesprenome');


        $cindata->setMask('dd/mm/yyyy');
        $cindata->setDatabaseMask('yyyy-mm-dd');

        $cingenero->enableSearch();
        $fescodigo->enableSearch();
        $fesprecodigo->enableSearch();

        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'HUM_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $cinimagem->setParametros('files/cinema/',$nome_arquivo,$permite);


        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $cincodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $cinnome ] );
        $this->form->addFields( [ new TLabel('Gênero') ], [ $cingenero ] );
        $this->form->addFields( [ new TLabel('Duração') ], [ $cinduracao ] );
        $this->form->addFields( [ new TLabel('Sobre') ], [ $cinsobre ] );
        $this->form->addFields( [ new TLabel('Festival') ], [ $fescodigo ] );
        $this->form->addFields( [ new TLabel('Premiação') ], [ $fesprecodigo ] );
        $this->form->addFields( [ new TLabel('Imagem') ], [ $cinimagem ] );
        $this->form->addFields( [ new TLabel('Data') ], [ $cindata ] );



        // set sizes
        $cincodigo->setSize('100%');
        $cinnome->setSize('100%');
        $cingenero->setSize('100%');
        $cinduracao->setSize('100%');
        $cinsobre->setSize('100%');
        $cindata->setSize('100%');
        $fescodigo->setSize('100%');
        $cinimagem->setSize('100%');
        $fesprecodigo->setSize('100%');



        if (!empty($cincodigo))
        {
            $cincodigo->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        $this->form->addAction('Voltar',  new TAction(array('CinemaList', 'onReload')), 'fa:reply green');


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
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
            $data = $this->form->getData(); // get form data as array
            
            $object = new Cinema;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated cincodigo
            $data->cincodigo = $object->cincodigo;
            
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
                $object = new Cinema($key); // instantiates the Active Record
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
