<?php
/**
 * FestivalForm Form
 * @author  <your name here>
 */
class FestivalForm extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Festival');
        $this->form->setFormTitle('Festival');
        

        // create the form fields
        $fescodigo = new TEntry('fescodigo');
        $fesnome = new TEntry('fesnome');
        $festema = new TEntry('festema');
        $fesimagem = new TFile('fesimagem');
        $criarLivro = new \Adianti\Widget\Form\TRadioGroup('criarlivro');
        $fesfoto1 = new TFile('fesfoto1');
        $fesfoto2 = new TFile('fesfoto2');
        $fesfoto3 = new TFile('fesfoto3');
        $fesdata = new TDate('fesdata');
        $fesperiodo = new TEntry('fesperiodo');
        $precodigo = new TCombo('precodigo');
        $fessobre = new THtmlEditor('fessobre');
        $fesoutros = new THtmlEditor('fesoutros');
        $procodigo = new TDBCombo('procodigo', 'conexao', 'Projeto', 'procodigo', 'pronome');
        $fesprodutor =  new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual}-{artcodigo}','artusual');
        $festipocodigo = new TDBCombo('festipocodigo','conexao','Festival_tipo','festipocodigo','{festiponome}-{festipocodigo}','festiponome');
        $fesmostra  = new TRadioGroup('fesmostra');
      //  $festipocodigo  = new TEntry('festipocodigo');
        
        $fesmostra->setLayout('horizontal');
        $fesmostra->setUseButton();
        $ops =  array(0=>"Paisagem",1=>"Retrato");
        $fesmostra->addItems($ops);
      
        $procodigo->enableSearch();
        $fesprodutor->enableSearch();
        $festipocodigo->enableSearch();

        $criarLivro->setBooleanMode();


        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $path = "files/festivais/";
        
        $precodigo->addItems(DadosFixos::getPrefeituras());
        
        if(!file_exists($path))
            mkdir($path);
            
        $fesimagem->setParametros($path,'IMG_'.$data_now.'_'.$getid,$permite);
        $fesfoto1->setParametros($path,'IMG1_'.$data_now.'_'.$getid,$permite);
        $fesfoto2->setParametros($path,'IMG2_'.$data_now.'_'.$getid,$permite);
        $fesfoto3->setParametros($path,'IMG3_'.$data_now.'_'.$getid,$permite);



        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $fescodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $fesnome ] );
        $this->form->addFields( [ new TLabel('Temática') ], [ $festema ] );
        $this->form->addFields( [ new TLabel('Criar livro?') ], [ $criarLivro ] );
        //$this->form->addFields( [ new TLabel('Formato R/P') ], [ $fesmostra ] );
        $this->form->addFields( [ new TLabel('Tipo Festival') ], [ $festipocodigo ] );
        $this->form->addFields( [ new TLabel('Livro') ], [ $fesimagem ] );
        $this->form->addFields( [ new TLabel('Foto 1') ], [ $fesfoto1 ] );
        $this->form->addFields( [ new TLabel('Foto 2') ], [ $fesfoto2 ] );
        $this->form->addFields( [ new TLabel('Foto 3') ], [ $fesfoto3 ] );
        $this->form->addFields( [ new TLabel('Data') ], [ $fesdata ] );
        $this->form->addFields( [ new TLabel('Período') ], [ $fesperiodo ] );
        $this->form->addFields( [ new TLabel('Cidade') ], [ $precodigo ] );
        $this->form->addFields( [ new TLabel('Nome Projeto') ], [ $procodigo ] );
        $this->form->addFields( [ new TLabel('Produtor') ], [ $fesprodutor ] );
        $this->form->addFields( [ new TLabel('Sobre') ], [ $fessobre ] );
        $this->form->addFields( [ new TLabel('Outros') ], [ $fesoutros ] );
       



        // set sizes
        $fescodigo->setSize('100%');
        $fesnome->setSize('50%');
        $festema->setSize('50%');
        $fesimagem->setSize('100%');
        $fesfoto1->setSize('50%');
        $fesfoto2->setSize('50%');
        $fesfoto3->setSize('50%');
        $fesdata->setSize('50%');
        $fesperiodo->setSize('100%');
        $precodigo->setSize('50%');
        $fessobre->setSize('100%');
        $fesoutros->setSize('100%');
        $procodigo->setSize('50%');
        $fesprodutor->setSize('50%');
        $festipocodigo->setSize('50%');



        if (!empty($fescodigo))
        {
            $fescodigo->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        $this->form->addAction('Voltar',  new TAction(array('FestivalList', 'onReload')), 'fa:reply green');


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
            
            $object = new Festival;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object

            if ($data->criarlivro){
                $livro  = new Livro();
                $livro->livnome =  $object->fesnome;
                $livro->fescodigo =  $object->fescodigo;
                $livro->livcategoria =  2; // FESTIVAL;
                $livro->store();
            }

            // get the generated fescodigo
            $data->fescodigo = $object->fescodigo;
            
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
                $object = new Festival($key); // instantiates the Active Record
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
