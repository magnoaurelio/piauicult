<?php
/**
 * HumorList Listing
 * @author  <your name here>
 */
class HumorList extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Humor');
        $this->form->setFormTitle('Humor');
        

        // create the form fields
        $humcodigo = new TEntry('humcodigo');
        $humnome = new TEntry('humnome');
        $artcodigo = new \Adianti\Widget\Wrapper\TDBCombo('artcodigo', 'conexao', 'Artista', 'artcodigo', 'artnome');
        $fescodigo = new \Adianti\Widget\Wrapper\TDBCombo('fescodigo', 'conexao', 'Festival', 'fescodigo', 'fesnome');
        $humcategoria = new \Adianti\Widget\Wrapper\TDBCombo('humcategoria','conexao','HumorCategoria','codigo','descricao','descricao');
        
        
        $artcodigo->enableSearch();
        $fescodigo->enableSearch();
        $humcategoria->enableSearch();


        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $humcodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $humnome ] );
        $this->form->addFields( [ new TLabel('Artista') ], [ $artcodigo ] );
        $this->form->addFields( [ new TLabel('Festival') ], [ $fescodigo ] );
        $this->form->addFields( [ new TLabel('Categoria') ], [ $humcategoria ] );


        // set sizes
        $humcodigo->setSize('100%');
        $humnome->setSize('100%');
        $artcodigo->setSize('100%');
        $fescodigo->setSize('100%');
        $humcategoria->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Humor_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'), new TAction(['HumorForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_humcodigo = new TDataGridColumn('humcodigo', 'Código', 'right');
        $column_humnome = new TDataGridColumn('humnome', 'Nome', 'left');
        $column_artcodigo = new TDataGridColumn('artista->artnome', 'Artista', 'right');
        $column_fescodigo = new TDataGridColumn('festival->fesnome', 'Festival', 'right');
        $column_humsobre = new TDataGridColumn('humsobre', 'Sobre', 'left');
        $column_humcategoria = new TDataGridColumn('{categoria->descricao}', 'Categoria', 'right');
        $column_humarquivo = new TDataGridColumn('humarquivo', 'Arquivo', 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_humcodigo);
        $this->datagrid->addColumn($column_humnome);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_fescodigo);
        $this->datagrid->addColumn($column_humsobre);
        $this->datagrid->addColumn($column_humcategoria);
        $this->datagrid->addColumn($column_humarquivo);

        $column_humarquivo->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "./files/humor/".$value;
            $img->style = "width:60px; height:60px;";
            return $img;
        });

        
        // create EDIT action
        $action_edit = new TDataGridAction(['HumorForm', 'onEdit']);
        //$action_edit->setUseButton(TRUE);
        //$action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('humcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        //$action_del->setUseButton(TRUE);
        //$action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('humcodigo');
        $this->datagrid->addAction($action_del);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
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
            $object = new Humor($key); // instantiates the Active Record
            $object->{$field} = $value;
            $object->store(); // update the object in the database
            TTransaction::close(); // close the transaction
            
            $this->onReload($param); // reload the listing
            new TMessage('info', "Record Updated");
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
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
        TSession::setValue('HumorList_filter_humcodigo',   NULL);
        TSession::setValue('HumorList_filter_humnome',   NULL);
        TSession::setValue('HumorList_filter_artcodigo',   NULL);
        TSession::setValue('HumorList_filter_fescodigo',   NULL);
        TSession::setValue('HumorList_filter_humcategoria',   NULL);

        if (isset($data->humcodigo) AND ($data->humcodigo)) {
            $filter = new TFilter('humcodigo', '=', "$data->humcodigo"); // create the filter
            TSession::setValue('HumorList_filter_humcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->humnome) AND ($data->humnome)) {
            $filter = new TFilter('humnome', 'like', "%{$data->humnome}%"); // create the filter
            TSession::setValue('HumorList_filter_humnome',   $filter); // stores the filter in the session
        }


        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', '=', "$data->artcodigo"); // create the filter
            TSession::setValue('HumorList_filter_artcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->fescodigo) AND ($data->fescodigo)) {
            $filter = new TFilter('fescodigo', '=', "$data->fescodigo"); // create the filter
            TSession::setValue('HumorList_filter_fescodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->humcategoria) AND ($data->humcategoria)) {
            $filter = new TFilter('humcategoria', 'like', "%{$data->humcategoria}%"); // create the filter
            TSession::setValue('HumorList_filter_humcategoria',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Humor_filter_data', $data);
        
        $param = array();
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
            
            // creates a repository for Humor
            $repository = new TRepository('Humor');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'humcodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('HumorList_filter_humcodigo')) {
                $criteria->add(TSession::getValue('HumorList_filter_humcodigo')); // add the session filter
            }


            if (TSession::getValue('HumorList_filter_humnome')) {
                $criteria->add(TSession::getValue('HumorList_filter_humnome')); // add the session filter
            }


            if (TSession::getValue('HumorList_filter_artcodigo')) {
                $criteria->add(TSession::getValue('HumorList_filter_artcodigo')); // add the session filter
            }


            if (TSession::getValue('HumorList_filter_fescodigo')) {
                $criteria->add(TSession::getValue('HumorList_filter_fescodigo')); // add the session filter
            }


            if (TSession::getValue('HumorList_filter_humcategoria')) {
                $criteria->add(TSession::getValue('HumorList_filter_humcategoria')); // add the session filter
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
    public static function onDelete($param)
    {
        // define the delete action
        $action = new TAction([__CLASS__, 'Delete']);
        $action->setParameters($param); // pass the key parameter ahead
        
        // shows a dialog to the user
        new TQuestion(TAdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);
    }
    
    /**
     * Delete a record
     */
    public static function Delete($param)
    {
        try
        {
            $key=$param['key']; // get the parameter $key
            TTransaction::open('conexao'); // open a transaction with database
            $object = new Humor($key, FALSE); // instantiates the Active Record
            $object->delete(); // deletes the object from the database
            TTransaction::close(); // close the transaction
            
            $pos_action = new TAction([__CLASS__, 'onReload']);
            new TMessage('info', TAdiantiCoreTranslator::translate('Record deleted'), $pos_action); // success message
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
