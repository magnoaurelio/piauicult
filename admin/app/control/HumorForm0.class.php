<?php
/**
 * HumorForm Form
 * @author  <your name here>
 */
class HumorForm extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Humor');
        $this->form->setFormTitle('Humor');
        

        // create the form fields
        $humcodigo = new TEntry('humcodigo');
        $humnome = new TEntry('humnome');
        $artcodigo = new \Adianti\Widget\Wrapper\TDBCombo('artcodigo', 'conexao', 'Artista', 'artcodigo', 'artnome','artnome');
        $fescodigo = new \Adianti\Widget\Wrapper\TDBCombo('fescodigo', 'conexao', 'Festival', 'fescodigo', 'fesnome','fesnome');
        $humsobre = new TText('humsobre');
        $humcategoria = new \Adianti\Widget\Wrapper\TDBCombo('humcategoria','conexao','HumorCategoria','codigo','descricao','descricao');
        $humarquivo = new TFile('humarquivo');

        $artcodigo->enableSearch();
        $fescodigo->enableSearch();
        $humcategoria->enableSearch();

        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'LETRA_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $humarquivo->setParametros('files/humor/',$nome_arquivo,$permite);


        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $humcodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $humnome ] );
        $this->form->addFields( [ new TLabel('Artista') ], [ $artcodigo ] );
        $this->form->addFields( [ new TLabel('Festival') ], [ $fescodigo ] );
        $this->form->addFields( [ new TLabel('Sobre') ], [ $humsobre ] );
        $this->form->addFields( [ new TLabel('Categoria') ], [ $humcategoria ] );
        $this->form->addFields( [ new TLabel('Arquivo') ], [ $humarquivo ] );



        // set sizes
        $humcodigo->setSize('100%');
        $humnome->setSize('100%');
        $artcodigo->setSize('100%');
        $fescodigo->setSize('100%');
        $humsobre->setSize('100%');
        $humcategoria->setSize('100%');
        $humarquivo->setSize('100%');



        if (!empty($humcodigo))
        {
            $humcodigo->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');

        $this->form->addAction('Voltar',  new TAction(array('HumorList', 'onReload')), 'fa:reply green');


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
            
            $object = new Humor;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object

            $livro = $object->get_festival()->get_livro();

            $ultimaPagina = $livro->getUltimaPagina();

            $filename = 'files/humor/'.$object->humarquivo;

            $pagina = new LivroPagina();
            $pagina->descricao = $object->humnome;
            $pagina->numero = $ultimaPagina->numero + 1;
            $pagina->livcodigo = $livro->livcodigo;
            File::moveSemPorONome($filename,'files/livros/paginas/');
            $pagina->arquivo = $object->humarquivo;
            $pagina->store();

            // get the generated humcodigo
            $data->humcodigo = $object->humcodigo;
            
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
                $object = new Humor($key); // instantiates the Active Record
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
