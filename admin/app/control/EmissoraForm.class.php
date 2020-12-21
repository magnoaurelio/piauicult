<?php
/**
 * EmissoraForm Form
 * @author  <your name here>
 */
class EmissoraForm extends TPage
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
        $this->form = new TQuickForm('form_Emissora');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Emissora');
        


        // create the form fields
        $emicodigo = new TEntry('emicodigo');
        $eminome = new TEntry('eminome');
        $emivivo = new TEntry('emivivo');
        $emifacebook = new TEntry('emifacebook');
        $emiwhatsapp = new TEntry('emiwhatsapp');
        $emitwitter = new TEntry('emitwitter');
        $emiyuotube = new TEntry('emiyuotube');
        $emiinstagram = new TEntry('emiinstagram');
        $emilocal = new TEntry('emilocal');
        $emifoto = new TFile('emifoto');
        $emiimagem = new TFile('emiimagem');
        $emiendereco = new TEntry('emiendereco');
        $emibairro = new TEntry('emibairro');
        $emicep = new TEntry('emicep');
        $emicontato = new TEntry('emicontato');
        $emiemail = new TEntry('emiemail');
        $emisite = new TEntry('emisite');
        $emicidade = new TCombo('emicidade');
        $emiestado = new TEntry('emiestado');
        $emioperador = new TEntry('emioperador');
        $emisobre = new THtmlEditor('emisobre');
        
        
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'EMI_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $path = "files/emissoras/";
        
        $emicidade->addItems(DadosFixos::getPrefeituras());
        $emicidade->enableSearch();
        if(!file_exists($path))
            mkdir($path);
            
        $emifoto->setParametros($path,$nome_arquivo,$permite);
        $emiimagem->setParametros($path,$nome_arquivo,$permite);
        
          // add the fields
        $this->form->addQuickField('Código', $emicodigo,  '50%' );
        $this->form->addQuickField('Nome', $eminome,  '100%' );
        $this->form->addQuickField('Foto', $emifoto,  '100%' );
        $this->form->addQuickField('Imagem', $emiimagem,  '100%' );
        $this->form->addQuickField('Localização', $emilocal,  '100%' );
        $this->form->addQuickField('Endereço', $emiendereco,  '100%' );
        $this->form->addQuickField('Bairro', $emibairro,  '100%' );
        $this->form->addQuickField('Cep', $emicep,  '100%' );
        $this->form->addQuickField('Fone_Celular', $emicontato,  '100%' );
        $this->form->addQuickField('Email', $emiemail,  '100%' );
        $this->form->addQuickField('Site', $emisite,  '100%' );
        $this->form->addQuickField('Ao Vivo', $emivivo,  '100%' );
        $this->form->addQuickField('Cidade', $emicidade,  '100%' );
        $this->form->addQuickField('Estado', $emiestado,  '100%' );
        $this->form->addQuickField('Facebook', $emifacebook,  '100%' );
        $this->form->addQuickField('Twitter', $emitwitter,  '100%' );
        $this->form->addQuickField('Yuotube', $emiyuotube,  '100%' );
        $this->form->addQuickField('Whatsapp', $emiwhatsapp,  '100%' );
        $this->form->addQuickField('Instagram', $emiinstagram,  '100%' );
        $this->form->addQuickField('Sobre', $emisobre,  '100%' );


        if (!empty($emicodigo))
        {
            $emicodigo->setEditable(FALSE);
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
        $this->form->addQuickAction('Voltar',  new TAction(array('EmissoraList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Emissora Form', $this->form));
        
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
            
            $object = new Emissora;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated emicodigo
            $data->emicodigo = $object->emicodigo;
            
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
                $object = new Emissora($key); // instantiates the Active Record
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
