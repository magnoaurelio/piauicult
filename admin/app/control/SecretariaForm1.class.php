<?php
/**
 * SecretariaForm Form
 * @author  <your name here>
 */
class SecretariaForm extends TPage
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
        $this->form = new TQuickForm('form_Secretaria');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new \Adianti\Wrapper\BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Secretaria');
        


        // create the form fields
        $prenumero = new TEntry('prenumero');
        $criteria =  new TCriteria;
        $secnome = new TEntry('secnome');
        $unidadeGestora = new TEntry('unidadeGestora');
        $secendereco = new TEntry('secendereco');
        $secbairro = new TEntry('secbairro');
        $secfone = new TEntry('secfone');
        $secemail = new TEntry('secemail');
        $secsecretario = new TEntry('secsecretario');
        $secusual = new TEntry('secusual');
        $secicon = new TEntry('secicon');
        $secimagem = new TFile('secimagem');
        $secfotor = new TFile('secfotor');
        $secfoto = new TFile('secfoto');
        $secsexo = new TCombo('secsexo');
        $sectipo = new TCombo('sectipo');
        $secsite = new TEntry('secsite');
        $descricao = new THtmlEditor('descricao');
        $precodigo = new TDBCombo('precodigo','conexao','Prefeitura','precodigo','prenome','prenome',$criteria);
        $unidadeGestora = new TDBCombo('unidadeGestora', 'conexao', 'Prefeitura', 'codigoUnidGestora', '{codigoUnidGestora}-{prenome}','codigoUnidGestora asc'  );
       // $unidadeGestora = new TEntry('unidadeGestora');

        $precodigo->enableSearch();
        $unidadeGestora->enableSearch();
        
        $secsexo->addItems(DadosFixos::Genero());
        $sectipo->addItems(DadosFixos::tipoAssessor());
         
        // add the fields
        $this->form->addQuickField('Prenumero', $prenumero,  50 );
        $this->form->addQuickField('Unidade Gestora', $unidadeGestora,  400 );
        $this->form->addQuickField('Nome Secretaria', $secnome,  400 );
        $this->form->addQuickField('Endereço', $secendereco,  400 );
        $this->form->addQuickField('Bairro', $secbairro,  300 );
        $this->form->addQuickField('Fone', $secfone, 300 );
        $this->form->addQuickField('Email', $secemail,  400 );
        $this->form->addQuickField('Site', $secsite,  400 );
        $this->form->addQuickField('Nome Secretário', $secsecretario,  400 );
        $this->form->addQuickField('Nome Usual', $secusual,  300 );
        $this->form->addQuickField('Sexo', $secsexo,  300 );
        $this->form->addQuickField('Tipo Assessor', $sectipo,  300 );
        $this->form->addQuickField('Foto Secretário', $secfotor,  300 );
        $this->form->addQuickField('Imagem Secretaria 1', $secfoto,  300 );
        $this->form->addQuickField('Imagem Secretaria 2', $secimagem,  300 );
        $this->form->addQuickField('Descrição', $descricao,  '100%');
        

        if (!empty($prenumero))
        {
            $prenumero->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $btn_onsave = $this->form->addQuickAction("Salvar", new TAction([$this, 'onSave']), 'fa:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addQuickAction("Limpar formulário", new TAction([$this, 'onClear']), 'fa:eraser #ffffff');
        $btn_onclear->addStyleClass('btn-success'); 

        $btn_onshow = $this->form->addQuickAction("Voltar", new TAction(['SecretariaList', 'onShow']), 'fa:reply #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 
     //   $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
     //   $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
     //   $this->form->addQuickAction('Listagem de Secretarias',  new TAction(array('SecretariaList', 'onReload')), 'bs:list green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Secretaria', $this->form));
        
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
            
            $object = new Secretaria;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->unidadeGestora = \Adianti\Registry\TSession::getValue('unidadeGestora');
         
            $path  = "tmp/";
            $destino = Prefeitura::getPrefeitura($object->unidadeGestora)->getDiretorio()."secretaria/";
            if (!file_exists($destino)) {
                mkdir($destino, 755, true);
            }

            if (is_file($path . $object->secfotor)) {
                $object->secfotor = File::moveRenomeando($path . $object->secfotor, $destino, true);
            }

            if (is_file($path . $object->secfoto)) {
                $object->secfoto = File::moveRenomeando($path . $object->secfoto, $destino, true);
            }
            if (is_file($path . $object->secimagem)) {
                $object->secimagem = File::moveRenomeando($path . $object->secimagem, $destino, true);
            }

            $object->store(); // save the object
            
            // get the generated prenumero
            $data->prenumero = $object->prenumero;
            
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
                $object = new Secretaria($key); // instantiates the Active Record
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
    public function onShow($param = null)
    {

        //<onShow>

        //</onShow>
    } 
}
