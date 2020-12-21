<?php
/**
 * PrefeituraList Listing
 * @author  <your name here>
 */
class PrefeituraList extends TPage
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
        $this->form = new TQuickForm('form_search_Prefeitura');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Prefeitura Listagem');
        

        // create the form fields
        $codigoUnidGestora = new TEntry('codigoUnidGestora');
        $prenome = new TEntry('prenome');
      
        $prenomep = new TEntry('prenomep');
        $preampar = new TCombo('preampar');
        $preampar->addItems(['ampar'=>'SIM']);

        // add the fields
        $this->form->addQuickField('Unidade Gestora', $codigoUnidGestora,  200 );
        $this->form->addQuickField('Cidade', $prenome,  200 );
        $this->form->addQuickField('Prefeito', $prenomep,  200 );
        $this->form->addQuickField('Ampar', $preampar,  200 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Prefeitura_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');

        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';        
        $this->datagrid->enablePopover('DETALHES', "Contato: {prefone}");
        

        // creates the datagrid columns
        $column_precodigo = new TDataGridColumn('precodigo', 'CÓDIGO', 'left');
        $column_codigoUnidGestora = new TDataGridColumn('codigoUnidGestora', 'UND. GESTORA', 'left');
        $column_prenome = new TDataGridColumn('prenome', 'NOME', 'left');
        $column_prenomep = new TDataGridColumn('prenomep', 'PREFEITO', 'left');
        $column_prebrasao = new TDataGridColumn('prebrasao', 'BRASÃO', 'center');
        $column_preemail = new TDataGridColumn('preemail', 'EMAIL', 'left');
     //   $column_pretema = new TDataGridColumn('pretema', 'Tema', 'left');
       
        $column_prebrasao->setTransformer( function($value, $object, $row) {
        $img = "files/prefeituras/201001/".$value;
       //  var_dump($img);
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:90px; height:80px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
        
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_precodigo);
        $this->datagrid->addColumn($column_codigoUnidGestora);
        $this->datagrid->addColumn($column_prenome);
        $this->datagrid->addColumn($column_prenomep);
        $this->datagrid->addColumn($column_preemail);
        $this->datagrid->addColumn($column_prebrasao);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('PrefeituraForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('precodigo');
        $this->datagrid->addAction($action_edit);


        $action_edit = new TDataGridAction(array('PrefeituraDadosForm', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Dados Históricos');
        $action_edit->setImage('fa:data  blue fa-lg');
        $action_edit->setField('precodigo');
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
        $container->add(TPanelGroup::pack('Listagem de Prefeituras', $this->form));
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
            $object = new Prefeitura($key); // instantiates the Active Record
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
        TSession::setValue('PrefeituraList_filter_codigoUnidGestora',   NULL);
        TSession::setValue('PrefeituraList_filter_prenome',   NULL);
        TSession::setValue('PrefeituraList_filter_prenomep',   NULL);
        TSession::setValue('PrefeituraList_filter_preampar',   NULL);

        if (isset($data->codigoUnidGestora) AND ($data->codigoUnidGestora)) {
            $filter = new TFilter('codigoUnidGestora', 'like', "%{$data->codigoUnidGestora}%"); // create the filter
            TSession::setValue('PrefeituraList_filter_codigoUnidGestora',   $filter); // stores the filter in the session
        }


        if (isset($data->prenome) AND ($data->prenome)) {
            $filter = new TFilter('prenome', 'like', "%{$data->prenome}%"); // create the filter
            TSession::setValue('PrefeituraList_filter_prenome',   $filter); // stores the filter in the session
        }


        if (isset($data->prenomep) AND ($data->prenomep)) {
            $filter = new TFilter('prenomep', 'like', "%{$data->prenomep}%"); // create the filter
            TSession::setValue('PrefeituraList_filter_prenomep',   $filter); // stores the filter in the session
        }


        if (isset($data->preampar) AND ($data->preampar)) {
            $filter = new TFilter('preampar', '=', "$data->preampar"); // create the filter
            TSession::setValue('PrefeituraList_filter_preampar',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Prefeitura_filter_data', $data);
        
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
            
            // creates a repository for Prefeitura
            $repository = new TRepository('Prefeitura');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'precodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('PrefeituraList_filter_codigoUnidGestora')) {
                $criteria->add(TSession::getValue('PrefeituraList_filter_codigoUnidGestora')); // add the session filter
            }


            if (TSession::getValue('PrefeituraList_filter_prenome')) {
                $criteria->add(TSession::getValue('PrefeituraList_filter_prenome')); // add the session filter
            }


            if (TSession::getValue('PrefeituraList_filter_prenomep')) {
                $criteria->add(TSession::getValue('PrefeituraList_filter_prenomep')); // add the session filter
            }


            if (TSession::getValue('PrefeituraList_filter_preampar')) {
                $criteria->add(TSession::getValue('PrefeituraList_filter_preampar')); // add the session filter
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
            $object = new Prefeitura($key, FALSE); // instantiates the Active Record
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
