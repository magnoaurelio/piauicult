<?php
/**
 * ProjetoForm Form
 * @author  <your name here>
 */
class ProjetoForm extends TPage
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
        $this->form = new TQuickForm('form_Projeto');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Projeto');
        


        // create the form fields
        $procodigo = new TEntry('procodigo');
        $pronome = new TEntry('pronome');
        $procidade =  new \Adianti\Widget\Form\TCombo('procidade');
        $proendereco = new TEntry('proendereco');
        $probairro = new TEntry('probairro');
        $procep = new TEntry('procep');
        $procomplemento = new TEntry('procomplemento');
        $proimagem = new TFile('proimagem');
        $prologo = new TFile('prologo');
        $profone = new TEntry('profone');
        $procelular = new TEntry('procelular');
        $proresponsavel = new TEntry('proresponsavel');
        $profoto = new TFile('profoto');
        $procordenadas = new TEntry('procordenadas');
        $proesfera = new TCombo('proesfera');
        $proorgao = new TEntry('proorgao');
        $prosobre = new THtmlEditor('prosobre');

        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        // incluir foto do ARTISTA
        $nome_arquivo = 'LOCAl_'.$data_now.'_'.$getid;
        $path = "files/projetos/";
        
        if (!file_exists($path) or !is_dir($path)){
            mkdir($path);
        }

        $procidade->enableSearch();
        $procidade->addItems(DadosFixos::getPrefeituras());

        $procep->setMask('99999-999');
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $proimagem->setParametros($path,"PRO_".$nome_arquivo,$permite); 
        $profoto->setParametros($path,"RES_".$nome_arquivo,$permite);
        $prologo->setParametros($path,"LOGO_".$nome_arquivo,$permite);
        $proesfera->addItems(["Municipal"=>"Municipal", "Estadual"=>"Estadual", "Federal"=>"Federal"]);
        
        
        // add the fields
        $this->form->addQuickField('Código', $procodigo,  100 );
        $this->form->addQuickField('Nome', $pronome,  350 );
        $this->form->addQuickField('Cidade', $procidade,  300 );
        $this->form->addQuickField('Endereço', $proendereco,  300 );
        $this->form->addQuickField('Bairro', $probairro,  300 );
        $this->form->addQuickField('CEP', $procep,  100 );
        $this->form->addQuickField('Complemento', $procomplemento,  300 );
        $this->form->addQuickField('Esfera-Atuação', $proesfera,  300 );
        $this->form->addQuickField('Secretaria', $proorgao,  300 );
        $this->form->addQuickField('Imagem', $proimagem,  300 );
        $this->form->addQuickField('Logo', $prologo,  300 );
        $this->form->addQuickField('Fone', $profone,  200 );
        $this->form->addQuickField('Celular', $procelular,  200 );
        $this->form->addQuickField('Responsável', $proresponsavel,  300 );
        $this->form->addQuickField('Foto Responsável', $profoto,  300 );
        $this->form->addQuickField('Cordenadas(X,Y)', $procordenadas,  300 );
        $this->form->addQuickField('Sobre', $prosobre,  '100%' );




        if (!empty($procodigo))
        {
            $procodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction("Voltar",  new TAction(array('ProjetoList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Projeto Form', $this->form));
        
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
            
            $object = new Projeto;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated procodigo
            $data->procodigo = $object->procodigo;
            
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
                $object = new Projeto($key); // instantiates the Active Record
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
