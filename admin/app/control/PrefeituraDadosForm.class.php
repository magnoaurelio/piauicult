<?php
/**
 * PrefeituraDadosForm Form
 * @author  <your name here>
 */
class PrefeituraDadosForm extends TPage
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
        $this->form = new BootstrapFormBuilder('form_PrefeituraDados');
        $this->form->setFormTitle('DADOS DO MUNÍCIPIO - <span id="prefeitura"></span>');
        

        // create the form fields
        $codigo = new TEntry('codigo');
        $prehistoria = new THtmlEditor('prehistoria');
        $preperfil = new THtmlEditor('preperfil');
        $prehino = new THtmlEditor('prehino');
        $previsaogeral = new THtmlEditor('previsaogeral');
        $unidadeGestora = new TEntry('unidadeGestora');


        // add the fields
        $this->form->addFields( [ new TLabel('Codigo') ], [ $codigo ] );
        $this->form->addFields( [ new TLabel('História') ], [ $prehistoria ] );
        $this->form->addFields( [ new TLabel('Perfil') ], [ $preperfil ] );
        $this->form->addFields( [ new TLabel('Hino') ], [ $prehino ] );
        $this->form->addFields( [ new TLabel('Visão Geral') ], [ $previsaogeral ] );



        // set sizes
        $codigo->setSize('100%');
        $prehistoria->setSize('100%');
        $preperfil->setSize('100%');
        $prehino->setSize('100%');
        $previsaogeral->setSize('100%');
        $unidadeGestora->setSize('100%');



        if (!empty($codigo))
        {
            $codigo->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('Back'),  new TAction(['PrefeituraList', 'onReload']), 'fa:reply red');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
        parent::add($container);
    }


    function onLoad($param){
       \Adianti\Database\TTransaction::open('conexao');
        $prefeitura = new Prefeitura($param['precodigo']);
        \Adianti\Registry\TSession::setValue('prefeitura',$prefeitura);
        \Adianti\Widget\Base\TScript::create('$("#prefeitura").text("'.$prefeitura->codigoUnidGestora.' - '.$prefeitura->prenome.'")');
        $this->form->setData($prefeitura->getDados()); // fill the form
       \Adianti\Database\TTransaction::close();
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
            
            $object = new PrefeituraDados;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $prefeitura = \Adianti\Registry\TSession::getValue('prefeitura');
            if (!$prefeitura) throw new Exception('Você não tem permissão para alterar esta unidade Gestora');
            $object->unidadeGestora = $prefeitura->codigoUnidGestora;
            $object->store(); // save the object
            
            // get the generated codigo
            $data->codigo = $object->codigo;
            
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
                $object = new PrefeituraDados($key); // instantiates the Active Record
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
