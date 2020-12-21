<?php
/**
 * LivroList Listing
 * @author  <your name here>
 */
class LivroList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $formgrid;
    private $loaded;
    private $deleteButton;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TQuickForm('form_search_Livro');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Livro');
        

        // create the form fields
      //  $livcodigo = new TEntry('livcodigo');
       // $livnome = new TEntry('livnome');
        //$livnome = new TDBCombo('livcodigo','conexao','Livro','livcodigo','{livnome} - {livcodigo}','livnome');
        $livnome = new TEntry('livnome');
        $livtipo = new TEntry('livtipo');
        $livisbn = new TEntry('livisbn');
        $livautor = new TEntry('livautor');
        $livgenero = new TEntry('livgenero');
        $livfoto = new TEntry('livfoto');
        $livimagem = new TEntry('livimagem');
        $livano = new TEntry('livano');
        $liveditora = new TEntry('liveditora');
        $livpagina = new TEntry('livpagina');
        $livresumo = new TEntry('livresumo');
        $livdisco = new TDBCombo('livdisco','conexao','Disco','discodigo','disnome','disnome');
        $fescodigo = new TDBCombo('fescodigo','conexao','Festival','fescodigo','{fesnome} - {fescodigo}','fesnome');

        //$livnome->enableSearch();
        
        $livdisco->enableSearch();
        $fescodigo->enableSearch();
        // add the fields
        //$this->form->addQuickField('Código', $livcodigo,  200 );
        $this->form->addQuickField('Nome do Livro', $livnome,  400 );
        $this->form->addQuickField('Disco', $livdisco,  400 );
        $this->form->addQuickField('Festival', $fescodigo,  400 );
        /*$this->form->addQuickField('Livisbn', $livisbn,  200 );
        $this->form->addQuickField('Livautor', $livautor,  200 );
        $this->form->addQuickField('Livgenero', $livgenero,  200 );
        $this->form->addQuickField('Livfoto', $livfoto,  200 );
        $this->form->addQuickField('Livimagem', $livimagem,  200 );
        $this->form->addQuickField('Livano', $livano,  200 );
        $this->form->addQuickField('Liveditora', $liveditora,  200 );
        $this->form->addQuickField('Livpagina', $livpagina,  200 );
        $this->form->addQuickField('Livresumo', $livresumo,  200 );*/

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Livro_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('LivroForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_livcodigo = new TDataGridColumn('livcodigo', 'Código', 'right', 50);
        $column_livnome = new TDataGridColumn('livnome', 'Nome', 'left');
        $column_livtipo = new TDataGridColumn('Tipo', 'Tipo', 'right');
        $column_livisbn = new TDataGridColumn('livisbn', 'ISBN', 'left');
        $column_livautor = new TDataGridColumn('Artista->artusual', 'Autor', 'left');
        $column_livgenero = new TDataGridColumn('livgenero', 'Gênero', 'right');
        $column_livfoto = new TDataGridColumn('livfoto', 'Foto', 'left');
        $column_livdiscoimg = new TDataGridColumn('Disco->disimagem', 'Disco', 'left');
        $column_livimagem = new TDataGridColumn('livimagem', 'Imagem', 'left');
        $column_livano = new TDataGridColumn('livano', 'Ano', 'left');
        $column_liveditora = new TDataGridColumn('liveditora', 'Editora', 'left');
        $column_livpagina = new TDataGridColumn('livpagina', 'Paginas', 'right');
        $column_livresumo = new TDataGridColumn('livresumo', 'Resumo', 'left');

        // criar na grade um ordenação
        $order_livnome = new TAction(array($this, 'onReload'));
        $order_livnome->setParameter('order', 'livnome');
        $column_livnome->setAction($order_livnome);
        
         $column_livfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/livros/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });
        
         $column_livdiscoimg->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/discos/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_livcodigo);
        $this->datagrid->addColumn($column_livnome);
        $this->datagrid->addColumn($column_livtipo);
        $this->datagrid->addColumn($column_livfoto);
        $this->datagrid->addColumn($column_livdiscoimg);
        $this->datagrid->addColumn($column_livautor);
        $this->datagrid->addColumn($column_livisbn);
        $this->datagrid->addColumn($column_livgenero);
        $this->datagrid->addColumn($column_livimagem);
        $this->datagrid->addColumn($column_livano);
        $this->datagrid->addColumn($column_liveditora);
        $this->datagrid->addColumn($column_livpagina);
        $this->datagrid->addColumn($column_livresumo);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('LivroForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('livcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setImage('fa:trash-o red');
        $action_del->setField('livcodigo');
        $this->datagrid->addAction($action_del);
        
        
         // paginas
        $action_edit = new TDataGridAction(array('LivroPaginaFormList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Páginas');
        $action_edit->setImage('fa:file blue');
        $action_edit->setField('livcodigo');
        $this->datagrid->addAction($action_edit);
        
         // paginas
        $action_edit = new TDataGridAction(array('LivroPaginaForm', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Pag.zip');
        $action_edit->setImage('fa:plus blue');
        $action_edit->setField('livcodigo');
        $this->datagrid->addAction($action_edit);
        
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
        $container->add(TPanelGroup::pack('Listagem de Livros Cancioneiros / Encartes', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    /**
     * Inline record editing
     * @param $param Array containing:
     *              key: object ID value
     *              field name: object attribute to be updated
     *              value: new attribute content 
     */
    public function onInlineEdit($param)
    {
        try
        {
            // get the parameter $key
            $field = $param['field'];
            $key   = $param['key'];
            $value = $param['value'];
            
            TTransaction::open('conexao'); // open a transaction with database
            $object = new Livro($key); // instantiates the Active Record
            $object->{$field} = $value;
            $object->store(); // update the object in the database
            TTransaction::close(); // close the transaction
            
            $this->onReload($param); // reload the listing
            new TMessage('info', "Record Updated");
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue('LivroList_filter_livcodigo',   NULL);
        TSession::setValue('LivroList_filter_livnome',   NULL);
        TSession::setValue('LivroList_filter_livtipo',   NULL);
        TSession::setValue('LivroList_filter_livisbn',   NULL);
        TSession::setValue('LivroList_filter_livautor',   NULL);
        TSession::setValue('LivroList_filter_livgenero',   NULL);
        TSession::setValue('LivroList_filter_livfoto',   NULL);
        TSession::setValue('LivroList_filter_livimagem',   NULL);
        TSession::setValue('LivroList_filter_livano',   NULL);
        TSession::setValue('LivroList_filter_liveditora',   NULL);
        TSession::setValue('LivroList_filter_livpagina',   NULL);
        TSession::setValue('LivroList_filter_livresumo',   NULL);
        TSession::setValue('LivroList_filter_livdisco',   NULL);
        TSession::setValue('LivroList_filter_fescodigo',   NULL);

        if (isset($data->fescodigo) AND ($data->fescodigo)) {
            $filter = new TFilter('fescodigo', '=', $data->fescodigo); // create the filter
            TSession::setValue('LivroList_filter_fescodigo',   $filter); // stores the filter in the session
        }

        if (isset($data->livcodigo) AND ($data->livcodigo)) {
            $filter = new TFilter('livcodigo', 'like', "%{$data->livcodigo}%"); // create the filter
            TSession::setValue('LivroList_filter_livcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->livnome) AND ($data->livnome)) {
            $filter = new TFilter('livnome', 'like', "%{$data->livnome}%"); // create the filter
            TSession::setValue('LivroList_filter_livnome',   $filter); // stores the filter in the session
        }


        if (isset($data->livtipo) AND ($data->livtipo)) {
            $filter = new TFilter('livtipo', 'like', "%{$data->livtipo}%"); // create the filter
            TSession::setValue('LivroList_filter_livtipo',   $filter); // stores the filter in the session
        }


        if (isset($data->livisbn) AND ($data->livisbn)) {
            $filter = new TFilter('livisbn', 'like', "%{$data->livisbn}%"); // create the filter
            TSession::setValue('LivroList_filter_livisbn',   $filter); // stores the filter in the session
        }


        if (isset($data->livautor) AND ($data->livautor)) {
            $filter = new TFilter('livautor', 'like', "%{$data->livautor}%"); // create the filter
            TSession::setValue('LivroList_filter_livautor',   $filter); // stores the filter in the session
        }


        if (isset($data->livgenero) AND ($data->livgenero)) {
            $filter = new TFilter('livgenero', 'like', "%{$data->livgenero}%"); // create the filter
            TSession::setValue('LivroList_filter_livgenero',   $filter); // stores the filter in the session
        }


        if (isset($data->livfoto) AND ($data->livfoto)) {
            $filter = new TFilter('livfoto', 'like', "%{$data->livfoto}%"); // create the filter
            TSession::setValue('LivroList_filter_livfoto',   $filter); // stores the filter in the session
        }


        if (isset($data->livimagem) AND ($data->livimagem)) {
            $filter = new TFilter('livimagem', 'like', "%{$data->livimagem}%"); // create the filter
            TSession::setValue('LivroList_filter_livimagem',   $filter); // stores the filter in the session
        }


        if (isset($data->livano) AND ($data->livano)) {
            $filter = new TFilter('livano', 'like', "%{$data->livano}%"); // create the filter
            TSession::setValue('LivroList_filter_livano',   $filter); // stores the filter in the session
        }


        if (isset($data->liveditora) AND ($data->liveditora)) {
            $filter = new TFilter('liveditora', 'like', "%{$data->liveditora}%"); // create the filter
            TSession::setValue('LivroList_filter_liveditora',   $filter); // stores the filter in the session
        }


        if (isset($data->livpagina) AND ($data->livpagina)) {
            $filter = new TFilter('livpagina', 'like', "%{$data->livpagina}%"); // create the filter
            TSession::setValue('LivroList_filter_livpagina',   $filter); // stores the filter in the session
        }


        if (isset($data->livresumo) AND ($data->livresumo)) {
            $filter = new TFilter('livresumo', 'like', "%{$data->livresumo}%"); // create the filter
            TSession::setValue('LivroList_filter_livresumo',   $filter); // stores the filter in the session
        }
        
        
        if (isset($data->livdisco) AND ($data->livdisco)) {
            $filter = new TFilter('livdisco', 'like', "%{$data->livdisco}%"); // create the filter
            TSession::setValue('LivroList_filter_livdisco',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Livro_filter_data', $data);
        
        $param=array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
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
            
            // creates a repository for Livro
            $repository = new TRepository('Livro');
            $limit = 100;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'livcodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('LivroList_filter_livcodigo')) {
                $criteria->add(TSession::getValue('LivroList_filter_livcodigo')); // add the session filter
            }

            if (TSession::getValue('LivroList_filter_fescodigo')) {
                $criteria->add(TSession::getValue('LivroList_filter_fescodigo')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livnome')) {
                $criteria->add(TSession::getValue('LivroList_filter_livnome')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livtipo')) {
                $criteria->add(TSession::getValue('LivroList_filter_livtipo')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livisbn')) {
                $criteria->add(TSession::getValue('LivroList_filter_livisbn')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livautor')) {
                $criteria->add(TSession::getValue('LivroList_filter_livautor')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livgenero')) {
                $criteria->add(TSession::getValue('LivroList_filter_livgenero')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livfoto')) {
                $criteria->add(TSession::getValue('LivroList_filter_livfoto')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livimagem')) {
                $criteria->add(TSession::getValue('LivroList_filter_livimagem')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livano')) {
                $criteria->add(TSession::getValue('LivroList_filter_livano')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_liveditora')) {
                $criteria->add(TSession::getValue('LivroList_filter_liveditora')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livpagina')) {
                $criteria->add(TSession::getValue('LivroList_filter_livpagina')); // add the session filter
            }


            if (TSession::getValue('LivroList_filter_livresumo')) {
                $criteria->add(TSession::getValue('LivroList_filter_livresumo')); // add the session filter
            }
            
            if (TSession::getValue('LivroList_filter_livdisco')) {
                $criteria->add(TSession::getValue('LivroList_filter_livdisco')); // add the session filter
            }

            
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            if (is_callable($this->transformCallback))
            {
                call_user_func($this->transformCallback, $objects, $param);
            }
            
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
            new TMessage('error', $e->getMessage());
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
        new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);
    }
    
    /**
     * Delete a record
     */
    public function Delete($param)
    {
        try
        {
            $key=$param['key']; // get the parameter $key
            TTransaction::open('conexao'); // open a transaction with database
            $object = new Livro($key, FALSE); // instantiates the Active Record
            $object->delete(); // deletes the object from the database
            TTransaction::close(); // close the transaction
            $this->onReload( $param ); // reload the listing
            new TMessage('info', AdiantiCoreTranslator::translate('Record deleted')); // success message
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
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }
}
