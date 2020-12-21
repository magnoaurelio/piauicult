<?php
/**
 * BandaForm Form
 * @author  <your name here>
 */
class BandaForm extends TPage
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
        $this->form = new TQuickForm('form_Banda');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Grupos / Bandas Cadastro');
        


        // create the form fields
        $bancodigo = new TEntry('bancodigo');
        $bannome = new TEntry('bannome');
        $bancep = new TEntry('bancep');
        $bancidade = new TEntry('bancidade');
        $banuf = new TEntry('banuf');
        $banendereco = new TEntry('banendereco');
        $banbairro = new TEntry('banbairro');
        $bannumero = new TEntry('bannumero');
        $bancontato = new TEntry('bancontato');
        $banemail = new TEntry('banemail');
     //   $banresponsavel = new TEntry('banresponsavel');
        $banresponsavel = new TDBCombo('banresponsavel','conexao','Artista','artcodigo','artusual','artusual');
        $banmusicos = new TText('banmusicos');
        $banfoto1 = new TFile('banfoto1');
        $banfoto2 = new TFile('banfoto2');
        $banfoto3 = new TFile('banfoto3');
        $banfoto4 = new TFile('banfoto4');
        $banfoto5 = new TFile('banfoto5');
        $bandetalhe = new THtmlEditor('bandetalhe');
        $bantipocodigo = new TDBCombo('bantipocodigo','conexao','BandaTipo','bantipocodigo','bantiponome','bantiponome');
        
        $bantipocodigo->enableSearch();
        
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $pasta =  "files/bandas/";
        
        if (!file_exists($pasta)){
            mkdir($pasta);
        }
        
        // incluir foto do ARTISTA
        $nome_arquivo = $data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $banfoto1->setParametros($pasta,"IMG_01_".$nome_arquivo,$permite);
        $banfoto2->setParametros($pasta,"IMG_02_".$nome_arquivo,$permite);
        $banfoto3->setParametros($pasta,"IMG_03_".$nome_arquivo,$permite);
        $banfoto4->setParametros($pasta,"IMG_04_".$nome_arquivo,$permite);
        $banfoto5->setParametros($pasta,"IMG_05_".$nome_arquivo,$permite);
        

        // add the fields
        $this->form->addQuickField('Código', $bancodigo,  100 );
        $this->form->addQuickField('Nome', $bannome,  300 );
        $this->form->addQuickField('Tipo de Grupo', $bantipocodigo,  300 );
        $this->form->addQuickField('Cidade', $bancidade,  300 );
        $this->form->addQuickField('UF', $banuf,  100 );
        $this->form->addQuickField('Cep', $bancep,  100 );
        $this->form->addQuickField('Endereço', $banendereco,  350 );
        $this->form->addQuickField('Bairro', $banbairro,  300 );
        $this->form->addQuickField('Número', $bannumero,  100 );
        $this->form->addQuickField('Contato', $bancontato,  300 );
        $this->form->addQuickField('Email', $banemail,  300 );
        $this->form->addQuickField('Responsável', $banresponsavel,  300 );
        $this->form->addQuickField('Foto 1', $banfoto1,  400 );
        $this->form->addQuickField('Foto 2', $banfoto2,  400 );
        $this->form->addQuickField('Foto 3', $banfoto3,  400 );
        $this->form->addQuickField('Foto 4', $banfoto4,  400 );
        $this->form->addQuickField('Foto 5', $banfoto5,  400 );
        $this->form->addQuickField('Detalhe', $bandetalhe,  '100%' );




        if (!empty($bancodigo))
        {
            $bancodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction("Voltar",  new TAction(array('BandaList', 'onReload')), 'fa:reply green');
        
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Grupo Cadastro', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
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
            
            $object = new Banda;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated bancodigo
            $data->bancodigo = $object->bancodigo;
            
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
                $object = new Banda($key); // instantiates the Active Record
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
