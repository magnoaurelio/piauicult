<?php
/**
 * ApresentadorList Listing
 * @author  <your name here>
 */
class ApresentadorList extends TPage
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
        $this->form = new TQuickForm('form_search_Apresentador');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Apresentador');
        

        // create the form fields
        $aprcodigo = new TEntry('aprcodigo');
        $aprnome = new TEntry('aprnome');
        $apremissora = new TDBCombo('apremissora','conexao','Emissora','emicodigo','{emicodigo}-{eminome}','eminome');
       
	$apremissora->enableSearch();


        // add the fields
        $this->form->addQuickField('Código', $aprcodigo,  '50%' );
        $this->form->addQuickField('Nome', $aprnome,  '50%' );
        $this->form->addQuickField('Emissora', $apremissora,  '50%' );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Apresentador_filter_data') );
        $this->form->setData( TSession::getValue('Apresentador_filter_$apremissora') );
        
        // add the search form actions
        $btn = $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction(_t('New'),  new TAction(array('ApresentadorForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_aprcodigo = new TDataGridColumn('aprcodigo', 'Código', 'right');
   //     $column_apremissora = new TDataGridColumn('apremissora', 'Cidde', 'left');
        $column_aprnome = new TDataGridColumn('aprnome', 'Nome', 'left');
        $column_aprfuncao = new TDataGridColumn('aprfuncao', 'Função', 'left');
        $column_aprfoto = new TDataGridColumn('aprfoto', 'Foto', 'left');
        $column_apremissora = new TDataGridColumn('Emissora->eminome', 'Emissora', 'right');
        $column_aprcontato = new TDataGridColumn('aprcontato', 'Contato', 'left');
        $column_apremail = new TDataGridColumn('apremail', 'Email', 'left');
        
        
         $column_aprfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/apresentador/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_aprcodigo);
        $this->datagrid->addColumn($column_apremissora);
        $this->datagrid->addColumn($column_aprnome);
        $this->datagrid->addColumn($column_aprfuncao);
        $this->datagrid->addColumn($column_aprfoto);
    
        $this->datagrid->addColumn($column_aprcontato);
        $this->datagrid->addColumn($column_apremail);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('ApresentadorForm', 'onEdit'));
        //$action_edit->setUseButton(TRUE);
        //$action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('aprcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        //$action_del->setUseButton(TRUE);
        //$action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('aprcodigo');
        $this->datagrid->addAction($action_del);
        
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
        $container->add(TPanelGroup::pack('Apresentador Listagem', $this->form));
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
            $object = new Apresentador($key); // instantiates the Active Record
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
        TSession::setValue('ApresentadorList_filter_aprcodigo',   NULL);
        TSession::setValue('ApresentadorList_filter_aprnome',   NULL);
        TSession::setValue('ApresentadorList_filter_apremissora',   NULL);

        if (isset($data->aprcodigo) AND ($data->aprcodigo)) {
            $filter = new TFilter('aprcodigo', 'like', "%{$data->aprcodigo}%"); // create the filter
            TSession::setValue('ApresentadorList_filter_aprcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->aprnome) AND ($data->aprnome)) {
            $filter = new TFilter('aprnome', 'like', "%{$data->aprnome}%"); // create the filter
            TSession::setValue('ApresentadorList_filter_aprnome',   $filter); // stores the filter in the session
        }


        if (isset($data->apremissora) AND ($data->apremissora)) {
            $filter = new TFilter('apremissora', '=', "$data->apremissora"); // create the filter
            TSession::setValue('ApresentadorList_filter_apremissora',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Apresentador_filter_data', $data);
        
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
            
            // creates a repository for Apresentador
            $repository = new TRepository('Apresentador');
            $limit = 15;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'aprcodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('ApresentadorList_filter_aprcodigo')) {
                $criteria->add(TSession::getValue('ApresentadorList_filter_aprcodigo')); // add the session filter
            }


            if (TSession::getValue('ApresentadorList_filter_aprnome')) {
                $criteria->add(TSession::getValue('ApresentadorList_filter_aprnome')); // add the session filter
            }


            if (TSession::getValue('ApresentadorList_filter_apremissora')) {
                $criteria->add(TSession::getValue('ApresentadorList_filter_apremissora')); // add the session filter
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
            $object = new Apresentador($key, FALSE); // instantiates the Active Record
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
