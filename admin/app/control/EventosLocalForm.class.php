<?php
/**
 * EventosLocalForm Form
 * @author  <your name here>
 */
class EventosLocalForm extends TPage
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
        $this->form = new TQuickForm('form_EventosLocal');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('EventosLocal');
        


        // create the form fields
        $loccodigo = new TEntry('loccodigo');
        $locnome = new TEntry('locnome');
        $locendereco = new TEntry('locendereco');
        $locbairro = new TEntry('locbairro');
        $loccep = new TEntry('loccep');
        $loccidade = new \Adianti\Widget\Form\TCombo('loccidade');
        $loccomplemento = new TEntry('loccomplemento');
        $loccordenadas = new TEntry('loccordenadas');
       
        $locimagem1 = new TFile('locimagem1');
        $locimagem2 = new TFile('locimagem2');
        $locimagem3 = new TFile('locimagem3');
        $locimagem4 = new TFile('locimagem4');
        $locimagem5 = new TFile('locimagem5');
        $locimagem6 = new TFile('locimagem6');
        $locfone = new TEntry('locfone');
        $loccelular = new TEntry('loccelular');
        $locresponsavel = new TEntry('locresponsavel');
        $locfoto = new TFile('locfoto');
        $locsobre = new THtmlEditor('locsobre');
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $loccep->setMask('99999-999');
        // incluir foto do ARTISTA
       
        $nome_arquivo1 = 'LOC1_'.$data_now.'_'.$getid;
        $nome_arquivo2 = 'LOC2_'.$data_now.'_'.$getid;
        $nome_arquivo3 = 'LOC3_'.$data_now.'_'.$getid;
        $nome_arquivo4 = 'LOC4_'.$data_now.'_'.$getid;
        $nome_arquivo5 = 'LOC5_'.$data_now.'_'.$getid;
        $nome_arquivo6 = 'LOC6_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        
        
        
        
        $locimagem1->setParametros('files/local/',"LOC1_".$nome_arquivo1,$permite); 
        $locimagem2->setParametros('files/local/',"LOC2_".$nome_arquivo2,$permite); 
        $locimagem3->setParametros('files/local/',"LOC3_".$nome_arquivo3,$permite); 
        $locimagem4->setParametros('files/local/',"LOC4_".$nome_arquivo4,$permite); 
        $locimagem5->setParametros('files/local/',"LOC5_".$nome_arquivo5,$permite); 
        $locimagem6->setParametros('files/local/',"LOC6_".$nome_arquivo6,$permite); 
        $locfoto->setParametros('files/local/',"RES_". $nome_arquivo1 ,$permite);

        $loccidade->addItems(DadosFixos::getPrefeituras());


        // add the fields
        $this->form->addQuickField('Código', $loccodigo,  100 );
        $this->form->addQuickField('Nome', $locnome,  300 );
        $this->form->addQuickField('Cidade', $loccidade,  300 );
        $this->form->addQuickField('Endereço', $locendereco,  300 );
        $this->form->addQuickField('Bairro', $locbairro,  300 );
        $this->form->addQuickField('Cep', $loccep,  100 );
        $this->form->addQuickField('Complemento', $loccomplemento,  300 );
        $this->form->addQuickField('Cord.(X;Y)', $loccordenadas,  300 );
        $this->form->addQuickField('Responsável', $locresponsavel,  300 );
        $this->form->addQuickField('Foto Responsável', $locfoto,  300 );
        $this->form->addQuickField('Fone', $locfone,  300 );
        $this->form->addQuickField('Celular', $loccelular,  300 );
       
        $this->form->addQuickField('Imagem principal ',$locimagem1,  300 );
        $this->form->addQuickField('Imagem do local 2', $locimagem2,  300 );
        $this->form->addQuickField('Imagem do local 3', $locimagem3,  300 );
        $this->form->addQuickField('Imagem do local 4', $locimagem4,  300 );
        $this->form->addQuickField('Imagem do local 5', $locimagem5,  300 );
        $this->form->addQuickField('Imagem do local 6', $locimagem6,  300 );
        $this->form->addQuickField('Sobre', $locsobre,  '100%' );




        if (!empty($loccodigo))
        {
            $loccodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction("Voltar",  new TAction(array('EventosLocalList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Eventos Local Form', $this->form));
        
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
            
            $object = new EventosLocal;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated loccodigo
            $data->loccodigo = $object->loccodigo;
            
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
                $object = new EventosLocal($key); // instantiates the Active Record
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
