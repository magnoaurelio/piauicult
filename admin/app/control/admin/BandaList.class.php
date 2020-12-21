<?php
/**
 * BandaList Listing
 * @author  <your name here>
 */
class BandaList extends TPage
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
        $this->form = new TQuickForm('form_search_Banda');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Grupo Listagem');
        

        // create the form fields
        $bannome = new TEntry('bannome');


        // add the fields
        $this->form->addQuickField('Nome', $bannome,  200 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Banda_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('BandaForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_bancodigo = new TDataGridColumn('bancodigo', 'Código', 'right');
        $column_bantipocodigo = new TDataGridColumn('bantipocodigo', 'Código', 'right');
        $column_bannome = new TDataGridColumn('bannome', 'Nome', 'left');
        $column_bancep = new TDataGridColumn('bancep', 'CEP', 'left');
        $column_banendereco = new TDataGridColumn('banendereco', 'Endereço', 'left');
        $column_banbairro = new TDataGridColumn('banbairro', 'Bairro', 'left');
        $column_bannumero = new TDataGridColumn('bannumero', 'Número', 'right');
        $column_bancontato = new TDataGridColumn('bancontato', 'Contato', 'left');
        $column_banemail = new TDataGridColumn('banemail', 'Email', 'left');
        $column_banresponsavel = new TDataGridColumn('banresponsavel', 'Responsável', 'left');
        $column_banmusicos = new TDataGridColumn('banmusicos', 'Músicos', 'left');
        $column_banfoto1 = new TDataGridColumn('banfoto1', 'Foto1', 'left');
        $column_banfoto2 = new TDataGridColumn('banfoto2', 'Foto2', 'left');
        $column_banfoto3 = new TDataGridColumn('banfoto3', 'Foto3', 'left');
        $column_banfoto4 = new TDataGridColumn('banfoto4', 'Foto4', 'left');
        $column_banfoto5 = new TDataGridColumn('banfoto5', 'Foto5', 'left');
        $column_bandetalhe = new TDataGridColumn('bandetalhe', 'Detalhe', 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_bancodigo);
        $this->datagrid->addColumn($column_bantipocodigo);
        $this->datagrid->addColumn($column_bannome);
        $this->datagrid->addColumn($column_bancep);
        $this->datagrid->addColumn($column_banendereco);
        $this->datagrid->addColumn($column_banbairro);
        $this->datagrid->addColumn($column_bannumero);
        $this->datagrid->addColumn($column_bancontato);
        $this->datagrid->addColumn($column_banemail);
        $this->datagrid->addColumn($column_banresponsavel);
      //  $this->datagrid->addColumn($column_banmusicos);
      //  $this->datagrid->addColumn($column_banfoto1);
       // $this->datagrid->addColumn($column_banfoto2);
       // $this->datagrid->addColumn($column_banfoto3);
       // $this->datagrid->addColumn($column_banfoto4);
        //$this->datagrid->addColumn($column_banfoto5);
       // $this->datagrid->addColumn($column_bandetalhe);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('BandaForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('bancodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('bancodigo');
        $this->datagrid->addAction($action_del);
        
        
         // instrumentos
        $action_edit = new TDataGridAction(array('BandaComponentes', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Componentes');
        $action_edit->setImage('fa:users blue fa-lg');
        $action_edit->setField('bancodigo');
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
        $container->add(TPanelGroup::pack('Banda Listagem', $this->form));
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
            $object = new Banda($key); // instantiates the Active Record
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
        TSession::setValue('BandaList_filter_bannome',   NULL);

        if (isset($data->bannome) AND ($data->bannome)) {
            $filter = new TFilter('bannome', 'like', "%{$data->bannome}%"); // create the filter
            TSession::setValue('BandaList_filter_bannome',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Banda_filter_data', $data);
        
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
            
            // creates a repository for Banda
            $repository = new TRepository('Banda');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'bancodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('BandaList_filter_bannome')) {
                $criteria->add(TSession::getValue('BandaList_filter_bannome')); // add the session filter
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
            $object = new Banda($key, FALSE); // instantiates the Active Record
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
