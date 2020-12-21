<?php
/**
 * LivroPaginaFormList Form List
 * @author  <your name here>
 */
class LivroPaginaFormList extends TPage
{
    protected $form; // form
    protected $datagrid; // datagrid
    protected $pageNavigation;
    protected $loaded;
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TQuickForm('form_LivroPagina');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Páginas');
        


        // create the form fields
        $id = new TEntry('id');
        $numero = new TEntry('numero');
        $descricao = new TEntry('descricao');
        $arquivo   = new TFile('arquivo');

        $id->setEditable(False);
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        // incluir foto do ARTISTA
        $nome_arquivo = 'PAG_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $arquivo->setParametros('files/livros/paginas/',$nome_arquivo,$permite); 
        
        // add the fields
        $this->form->addQuickField('Id', $id,  100 );
        $this->form->addQuickField('Numero', $numero,  100 );
        $this->form->addQuickField('Descricão', $descricao,  300 );
        $this->form->addQuickField('Arquivo', $arquivo,  400 );




        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar', new TAction(array('LivroList', 'onReload')), 'fa:reply green');
        $this->form->addQuickAction('Limpar Páginas', new TAction(array($this, 'onLimpar')), 'fa:trash red');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        ##LIST_DECORATOR##
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'Id', 'left');
        $column_numero = new TDataGridColumn('numero', 'Nº Pag', 'left');
        $column_livcodigo = new TDataGridColumn('Livro->livnome', 'Livro', 'left');
        $column_descricao = new TDataGridColumn('descricao', 'Descricao', 'left');
        $column_arquivo = new TDataGridColumn('arquivo', 'Foto', 'left');

        $column_arquivo->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/livros/paginas/".$value;
          $img->style = "width:70px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_numero);
        $this->datagrid->addColumn($column_livcodigo);
        $this->datagrid->addColumn($column_arquivo);
        $this->datagrid->addColumn($column_descricao);

        
        // creates two datagrid actions
        $action1 = new TDataGridAction(array($this, 'onEdit'));
        $action1->setUseButton(TRUE);
        $action1->setButtonClass('btn btn-default');
        $action1->setLabel(_t('Edit'));
        $action1->setImage('fa:pencil-square-o blue fa-lg');
        $action1->setField('id');
        
        $action2 = new TDataGridAction(array($this, 'onDelete'));
        $action2->setUseButton(TRUE);
        $action2->setButtonClass('btn btn-default');
        $action2->setLabel(_t('Delete'));
        $action2->setImage('fa:trash-o red fa-lg');
        $action2->setField('id');
        
        // add the actions to the datagrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Livro : <b><span id="livnome"><span></b>', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    
    function Operando($operando=false){
           if($operando):
            TEntry::enableField('form_LivroPagina', 'numero');
            TEntry::enableField('form_LivroPagina', 'descricao');
            TFile::enableField('form_LivroPagina', 'arquivo');
            else:
             TEntry::disableField('form_LivroPagina', 'numero');
             TEntry::disableField('form_LivroPagina', 'descricao');
             TFile::disableField('form_LivroPagina', 'arquivo');
            endif;

    }
    
     function onLoad($param){
        TSession::setValue('livcodigo',$param['livcodigo']);
        $this->onReload();
    }
    
    

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'conexao'
            TTransaction::open('conexao');
            $this->Operando(false);
            // creates a repository for LivroPagina
            $repository = new TRepository('LivroPagina');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $criteria->add(new TFilter('livcodigo','=',TSession::getValue('livcodigo')));
            $livro =  new Livro(TSession::getValue('livcodigo'));
             TScript::create('
              $("#livnome").html("'.$livro->livnome.'")    
            ');
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'id';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            
            if (TSession::getValue('LivroPagina_filter'))
            {
                // add the filter stored in the session to the criteria
                $criteria->add(TSession::getValue('LivroPagina_filter'));
            }
            
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }
            
            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);
            
            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit
            
            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
    }
    
    /**
     * Ask before deletion
     */
    public function onDelete($param)
    {
        // define the delete action
        $action = new TAction(array($this, 'Delete'));
        $action->setParameters($param); // pass the key parameter ahead
        
        // shows a dialog to the user
        new TQuestion(TAdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);
    }
    
    /**
     * Delete a record
     */
     public function onLimpar($param)
    {
        try
        {
            TTransaction::open('conexao'); // open a transaction with database
            $repo = new TRepository('LivroPagina');
            $criteria = new TCriteria;
            $criteria->add(new TFilter('livcodigo','=',TSession::getValue('livcodigo')));
            $paginas = $repo->load($criteria);
            if($paginas){
                foreach($paginas as $pag){
                    $path = 'files/livros/paginas/';
                    $arquivo  = $path.$pag->arquivo;
                    @unlink($arquivo);
                } 
            }          
            
            $repo->delete($criteria);
            TTransaction::close(); // close the transaction
            $this->onReload( $param ); // reload the listing
            new TMessage('info', 'Páginas Deletadas'); // success message
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
     
     
     
     
    public function Delete($param)
    {
        try
        {
            $key=$param['key']; // get the parameter $key
            TTransaction::open('conexao'); // open a transaction with database
            $object = new LivroPagina($key, FALSE); // instantiates the Active Record
            $object->delete(); // deletes the object from the database
            TTransaction::close(); // close the transaction
            $this->onReload( $param ); // reload the listing
            new TMessage('info', TAdiantiCoreTranslator::translate('Record deleted')); // success message
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
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
            
            $object = new LivroPagina;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->livcodigo = TSession::getValue('livcodigo');
            $object->store(); // save the object
            
            // get the generated id
            $data->id = $object->id;
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved')); // success message
            $this->onReload(); // reload the listing
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
        $this->onReload();
        $this->Operando(true);
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
                $object = new LivroPagina($key); // instantiates the Active Record
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
                $this->onReload();
            }
            else
            {
                $this->form->clear(TRUE);
            }
            $this->Operando(true);
            
            
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        parent::show();
    }
}
