<?php
/**
 * ClienteForm Registration
 * @author  <your name here>
 */
class ClienteForm extends TPage
{
    protected $form; // form
    
    use Adianti\Base\AdiantiStandardFormTrait; // Standard form methods
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('conexao');              // defines the database
        $this->setActiveRecord('Cliente');     // defines the active record
        
        // creates the form
        $this->form = new TQuickForm('form_Cliente');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Cliente Publicar');
        


        // create the form fields
        $clicodigo = new TEntry('clicodigo');
        $discodigo = new TDBCombo('discodigo','conexao','Disco','discodigo','{disnome}-{discodigo}','disnome');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual}-{artcodigo}','artusual');
        $cliprocodigo = new TDBCombo('cliprocodigo','conexao','ClienteProduto','cliprocodigo','{clipronome}-{cliprocodigo}','clipronome');
        $clinome = new TEntry('clinome');
        $clilote = new TEntry('clilote');
        $cliusual = new TEntry('cliusual');
        $clisexo = new TCombo('clisexo');
        $cliendereco = new TEntry('cliendereco');
        $clibairro = new TEntry('clibairro');
        $clicep = new TEntry('clicep');
        $cliuf = new TEntry('cliuf');
        $clifone = new TEntry('clifone');
        $clicelular = new TEntry('clicelular');
        $cliemail = new TEntry('cliemail');
        $Site = new TEntry('Site');
        $clidata = new TDate('clidata');
        $clidatacompra = new TDate('clidatacompra');
        $clisobre = new TText('clisobre');
        $cliquantidade = new TEntry('cliquantidade');
        $clicor = new TCombo('clicor');
        $clitamanho = new TEntry('clitamanho');
        $clivalor = new TEntry('clivalor');
        $cliimagem = new TFile('cliimagem');
        $clifoto = new TFile('clifoto');

        $artcodigo->enableSearch();
        $discodigo->enableSearch();
        $cliprocodigo->enableSearch();
            
        $clidata->setMask("dd/mm/yyyy");
        $clidatacompra->setMask("dd/mm/yyyy");
        $clicep->setMask('99999-999');
       // $artcpf->setMask('999.999.999-99');
        $cliuf->setMask("SS");  
        $cliuf->setTip("Sigla do Estado (XX)");    
        $clisexo->addItems(["M"=>"Masculino", "F"=>"Feminino"]);
        $clicor->addItems([ "Amarelo"=>"A","Branco"=>"B","Preto"=>"P"]);
        $data_now = date('dmYHis');
        
        $getid = TSession::getValue('userid');
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $nome_arquivo = 'CLIF_'.$data_now.'_'.$getid;
        $clifoto->setParametros('files/clientes/',$nome_arquivo,$permite);
        $nome_arquivo1 = 'CLII_'.$data_now.'_'.$getid;
        $cliimagem->setParametros('files/clientes/',$nome_arquivo1,$permite);
        
        
        // add the fields
        //TODO new TRequiredValidator
        $this->form->addQuickField('Cd_Cliente', $clicodigo,  100 );
        $this->form->addQuickField('Cd_Disco', $discodigo,  300 );
        $this->form->addQuickField('Cd_Artista', $artcodigo, 300 ) ;
        $this->form->addQuickField('Nome Cliente', $clinome,  300 );
        $this->form->addQuickField('Nome Usual', $cliusual,  300 );
        $this->form->addQuickField('Sexo', $clisexo,  200 );
        $this->form->addQuickField('Endereco', $cliendereco,  300 );
        $this->form->addQuickField('Bairro', $clibairro,  200 );
        $this->form->addQuickField('CEP', $clicep,  200 );
        $this->form->addQuickField('UF', $cliuf,  50 );
        $this->form->addQuickField('Fones', $clifone,  300 );
        $this->form->addQuickField('Celular', $clicelular,  300 );
        $this->form->addQuickField('E-mail', $cliemail,  300 );
        $this->form->addQuickField('Site', $Site,  300 );
        $this->form->addQuickField('Dt_Nascimento', $clidata,  100 );
        $this->form->addQuickField('Nº Lote', $clilote,  100 );
        $this->form->addQuickField('Produto', $cliprocodigo,  300 , new TRequiredValidator);
        $this->form->addQuickField('Dt_Compra', $clidatacompra,  100 );
        $this->form->addQuickField('Quantidade', $cliquantidade,  100 );
        $this->form->addQuickField('Cor', $clicor,  100 );
        $this->form->addQuickField('Tamanho', $clitamanho,  100 );
        $this->form->addQuickField('Valor R$', $clivalor,  200 );
        $this->form->addQuickField('Imagem', $clifoto,  300 );
        $this->form->addQuickField('Foto', $cliimagem,  300 );
         $this->form->addQuickField('Sobre', $clisobre,  '100%' );


       
        if (!empty($clicodigo))
        {
            $clicodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('ClienteList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Cliente Form', $this->form));
        
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
            
            $object = new Cliente;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->clidata = TDate::date2us($object->clidata);
            $object->clidatacompra = TDate::date2us($object->clidatacompra);
            $object->store(); // save the object
            
            // get the generated clicodigo
            $data->clicodigo = $object->clicodigo;
            
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
        $this->form->clear();
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
                $object = new Cliente($key); // instantiates the Active Record
                $object->clidata = TDate::date2br($object->clidata);
                $object->clidatacompra = TDate::date2br($object->clidatacompra);
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}
