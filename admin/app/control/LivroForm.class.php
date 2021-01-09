<?php
/**
 * LivroForm Form
 * @author  <your name here>
 */
class LivroForm extends TPage
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
        $this->form = new TQuickForm('form_Livro');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Livro');
        


        // create the form fields
        $livcodigo = new TEntry('livcodigo');
        $livnome = new TEntry('livnome');
        $livcategoria = new TCombo('livcategoria');
        $livtipo = new TCombo('livtipo');
        $livisbn = new TEntry('livisbn');
      //  $livautor = new TEntry('livautor');
        $livautor = new TDBCombo('livautor','conexao','Artista','artcodigo','{artusual}-{artcodigo}','artnome');
        $livgenero = new TCombo('livgenero');
        $livfoto = new TFile('livfoto');
        $livimagem = new TFile('livimagem');
        $livano = new TEntry('livano');
        $liveditora = new TEntry('liveditora');
        $livpagina = new TEntry('livpagina');
        $livresumo = new THtmlEditor('livresumo');
     // $livdisco = new TDBCombo('livdisco','conexao','Disco','discodigo','disnome','disnome');
        $livdisco = new TDBCombo('livdisco','conexao','Disco','discodigo','{disnome} - {discodigo}','disnome');
        $fescodigo = new TDBCombo('fescodigo','conexao','Festival','fescodigo','{fesnome} - {fescodigo}','fesnome');
        $livmostra  = new TRadioGroup('livmostra');
      //  $festipocodigo  = new TEntry('festipocodigo');
        
        $livmostra->setLayout('horizontal');
        $livmostra->setUseButton();
        $ops =  array(2=>"Paisagem",1=>"Retrato");
        $livmostra->addItems($ops);
        

        $livautor->enableSearch();
        $livdisco->enableSearch();
        $fescodigo->enableSearch();

        $livcategoria->setChangeAction(new TAction(array($this, 'onChangeType')));

        $livcategoria->addValidation("Categoria", new \Adianti\Validator\TRequiredValidator());


        //self::onChangeType(["livcategoria" => 1]);

        $livtipo->addItems(DadosFixos::TipoLivro());
        $livcategoria->addItems(DadosFixos::LivroCategoria());



        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        // incluir foto do ARTISTA
        $nome_arquivo = $data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $livfoto->setParametros('files/livros/','FOTO'.$nome_arquivo,$permite); 
        $livimagem->setParametros('files/livros/','IMG'.$nome_arquivo,$permite); 

        // add the fields
        $this->form->addQuickField('Código', $livcodigo,  100 );
        $this->form->addQuickField('Nome', $livnome,  300 );
        $this->form->addQuickField('Categoria', $livcategoria,  300 );
        $this->form->addQuickField('Disco', $livdisco,  300 );
        $this->form->addQuickField('Festival', $fescodigo,  300 );
        $this->form->addQuickField('Tipo', $livtipo, 200 );
        $this->form->addQuickField( 'Formato R/P', $livmostra, 300 );
        $this->form->addQuickField('ISBN', $livisbn,  200 );
        $this->form->addQuickField('Artista(Autor)', $livautor,  300 );
       // $this->form->addQuickField('Gênero', $livgenero,  200 );
        $this->form->addQuickField('Livro', $livfoto,  300 );
        $this->form->addQuickField('Imagem', $livimagem,  300 );
        $this->form->addQuickField('Ano', $livano,  200 );
        $this->form->addQuickField('Editora', $liveditora,  200 );
        $this->form->addQuickField('Página', $livpagina,  100 );
        $this->form->addQuickField('Resumo', $livresumo,  '100%' );




        if (!empty($livcodigo))
        {
            $livcodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('LivroList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Livro/Encarte Form', $this->form));
        
        parent::add($container);
    }




    public static function onChangeType($param)
    {
        if ($param['livcategoria'] == '1') // DISCO
        {
            TQuickForm::hideField('form_Livro', 'fescodigo');
            TQuickForm::showField('form_Livro', 'livdisco');
            TCombo::reload('form_Livro', 'livtipo', DadosFixos::TipoLivroOption('disco'));
        }
        elseif($param['livcategoria'] == '2') // FESTIVAL
        {
            TQuickForm::hideField('form_Livro', 'livdisco');
            TQuickForm::showField('form_Livro', 'fescodigo');
            TCombo::reload('form_Livro', 'livtipo', DadosFixos::TipoLivroOption('festival'));
        }
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
            
            $object = new Livro;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated livcodigo
            $data->livcodigo = $object->livcodigo;
            
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
                $object = new Livro($key); // instantiates the Active Record
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
