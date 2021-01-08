<?php
/**
 * ApresentadorForm Form
 * @author  <your name here>
 */
class ApresentadorForm extends TPage
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
        $this->form = new TQuickForm('form_Apresentador');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Apresentador');
        


        // create the form fields
        $aprcodigo = new TEntry('aprcodigo');
        $aprnome = new TEntry('aprnome');
        $aprfoto = new TFile('aprfoto');
        $apremissora = new TDBCombo('apremissora','conexao','Emissora','emicodigo','{emicodigo}-{eminome}','eminome');
        $aprcontato = new TEntry('aprcontato');
        $apremail = new TEntry('apremail');
     //   $aprfuncao = new TEntry('aprfuncao');
        $aprfuncao = new TCombo('aprfuncao');
        
        $apremissora->enableSearch();
       
        $aprfuncao->addItems([
            "APRESENTADOR(a)"=>"APRESENTADOR(a)", 
            "JORNALISTA-APRESENTADOR(a)"=>"JORNALISTA-APRESENTADOR(a)",
            "LOCUTOR(a)"=>"LOCUTOR(a)",
            "COMENTARISTA POLÍTICO"=>"COMENTARISTA POLÍTICO",
            "COLUNISTA SOCIAL"=>"COLUNISTA SOCIAL",
            "DIRETOR COMERCIAL"=>"DIRETOR COMERCIAL", 
            "NOTICIARISTA"=>"NOTICIARISTA",
            "8-DIRETOR EXECUTIVO"=>"DIRETOR EXECUTIVO", 
            "9-SONOPLASTA"=>"SONOPLASTA",
            "10-PROGRMADOR MUSICAL"=>"PROGRMADOR MUSICAL", 
            "11-DIRETOR DE PROGRAMAÇÃO"=>"DIRETOR DE PROGRAMAÇÃO", 
            "12-RADIALISTA"=>"RADIALISTA "
            ]);
        
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'APR_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $path = "files/apresentador/";
        
        if(!file_exists($path))
            mkdir($path);
            
        $aprfoto->setParametros($path,$nome_arquivo,$permite);
        // add the fields
        $this->form->addQuickField('Código', $aprcodigo,  '50%' );
        $this->form->addQuickField('Nome', $aprnome,  '100%' );
        $this->form->addQuickField('Função', $aprfuncao,  '100%' );
        $this->form->addQuickField('Foto', $aprfoto,  '100%' );
        $this->form->addQuickField('Emissora', $apremissora,  '50%' );
        $this->form->addQuickField('Contato', $aprcontato,  '100%' );
        $this->form->addQuickField('Email', $apremail,  '100%' );




        if (!empty($aprcodigo))
        {
            $aprcodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
         $this->form->addQuickAction('Voltar',  new TAction(array('ApresentadorList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Apresentador Form', $this->form));
        
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
            
            $object = new Apresentador;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated aprcodigo
            $data->aprcodigo = $object->aprcodigo;
            
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
                $object = new Apresentador($key); // instantiates the Active Record
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
