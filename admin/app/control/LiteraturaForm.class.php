<?php
/**
 * LiteraturaForm Form
 * @author  <your name here>
 */
class LiteraturaForm extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Literatura');
        $this->form->setFormTitle('Literatura - Publicar');
        

        // create the form fields
        $litcodigo = new TEntry('litcodigo');
        $litnome = new TEntry('litnome');
        $litpagina = new TEntry('litpagina');
        $artcodigo = new \Adianti\Widget\Wrapper\TDBCombo('artcodigo', 'conexao', 'Artista', 'artcodigo', 'artnome','artnome');
        $fescodigo = new \Adianti\Widget\Wrapper\TDBCombo('fescodigo', 'conexao', 'Festival', 'fescodigo', 'fesnome','fesnome');
        $fesprecodigo = new \Adianti\Widget\Wrapper\TDBCombo('fesprecodigo', 'conexao', 'Festival_Premio', 'fesprecodigo', 'fesprenome','fesprenome');
        $litsobre = new THtmlEditor('litsobre');
        $litcatcodigo = new \Adianti\Widget\Wrapper\TDBCombo('litcatcodigo','conexao','LiteraturaCategoria','litcatcodigo','litcatnome','litcatnome');
        $litarquivo = new \Adianti\Widget\Form\TFile('litarquivo');

        $artcodigo->enableSearch();
        $fescodigo->enableSearch();
        $fesprecodigo->enableSearch();
        $litcatcodigo->enableSearch();

        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'LIT_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $litarquivo->setParametros('files/literatura/',$nome_arquivo,$permite);


        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $litcodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $litnome ] );
        $this->form->addFields( [ new TLabel('Artista') ], [ $artcodigo ] );
        $this->form->addFields( [ new TLabel('Festival') ], [ $fescodigo ] );
        $this->form->addFields( [ new TLabel('Premiação') ], [ $fesprecodigo ] );
        $this->form->addFields( [ new TLabel('Categoria') ], [ $litcatcodigo ] );
        $this->form->addFields( [ new TLabel('Desenho') ], [ $litarquivo ] );
        $this->form->addFields( [ new TLabel('Nº pagina') ], [ $litpagina ] );
        $this->form->addFields( [ new TLabel('Sobre') ], [ $litsobre ] );




        // set sizes
        $litcodigo->setSize('100%');
        $litpagina->setSize('100%');
        $litnome->setSize('100%');
        $artcodigo->setSize('50%');
        $fescodigo->setSize('50%');
        $fesprecodigo->setSize('50%');
        $litsobre->setSize('100%');
        $litcatcodigo->setSize('50%');
        $litarquivo->setSize('50%');



        if (!empty($litcodigo))
        {
            $litcodigo->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');

        $this->form->addAction('Voltar',  new TAction(array('LiteraturaList', 'onReload')), 'fa:reply green');


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
        try {
            TTransaction::open('conexao'); // open a transaction

            /**
             * // Enable Debug logger for SQL operations inside the transaction
             * TTransaction::setLogger(new TLoggerSTD); // standard output
             * TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
             **/

            $this->form->validate(); // validate form data
            $data = $this->form->getData(); // get form data as array

            $object = new Literatura;  // create an empty object
            $object->fromArray((array)$data); // load the object with data
            $livro = $object->get_festival()->get_livro();
            $ultimaPagina = $livro->getUltimaPagina();
            $filename = 'files/literatura/' . $object->litarquivo;
            if ($data->litarquivo) {
                File::moveSemPorONome($filename, 'files/literatura/paginas/');
            }
            $object->store();
            $humor = new Literatura($object->litcodigo);

      /*      if (!$object->litcodigo) {
                $pagina = new LivroPagina();
                $pagina->descricao = $humor->litnome;
                $pagina->numero = $ultimaPagina->numero + 1;
                $pagina->livcodigo = $livro->livcodigo;
                $pagina->arquivo = $humor->litarquivo;
                $pagina->store();
                $humor->litpagina = $pagina->id;
                $humor->store();

            }else{
                $pagina = new LivroPagina($humor->litpagina);
                $pagina->arquivo = $object->litarquivo;
                $pagina->descricao = $object->litnome;
                $pagina->store();
            }*/
            // save the object


            // get the generated litcodigo
            $data->litcodigo = $object->litcodigo;
            
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
                $object = new Literatura($key); // instantiates the Active Record
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
