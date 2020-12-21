<?php
/**
 * EmissoraList Listing
 * @author  <your name here>
 */
class EmissoraList extends TPage
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
        $this->form = new TQuickForm('form_search_Emissora');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Emissora');
        

        // create the form fields
        $emicodigo = new TEntry('emicodigo');
        $eminome = new TEntry('eminome');
        $emicidade = new TCombo('emicidade');
        $emicidade->addItems(DadosFixos::getPrefeituras());
     //   $emicidade = new TDBCombo('unidadeGestora', 'conexao', 'Prefeitura', 'codigoUnidGestora', '{precodigo}-{prenome}','codigoUnidGestora asc'  );
        
        $emicidade->enableSearch();



        // add the fields
        $this->form->addQuickField('Código', $emicodigo,  '100%' );
        $this->form->addQuickField('Nome', $eminome,  '100%' );
        $this->form->addQuickField('Cidade', $emicidade,  '100%' );
        
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Emissora_filter_data') );
        $this->form->setData( TSession::getValue('Emissora_filter_emicidade') );
        
        // add the search form actions
        $btn = $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction(_t('New'),  new TAction(array('EmissoraForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_emicodigo = new TDataGridColumn('emicodigo', 'Código', 'right');
        $column_emicidade = new TDataGridColumn('emicidade', 'Cidade', 'left');
        $column_eminome = new TDataGridColumn('eminome', 'Nome', 'left');
        $column_emifoto = new TDataGridColumn('emifoto', 'Foto', 'left');
        $column_emiimagem = new TDataGridColumn('emiimagem', 'Imagem', 'left');
        $column_emiendereco = new TDataGridColumn('emiendereco', 'Endereço', 'left');
        $column_emibairro = new TDataGridColumn('emibairro', 'Bairro', 'left');
        $column_emicep = new TDataGridColumn('emicep', 'Cep', 'left');
        $column_emicontato = new TDataGridColumn('emicontato', 'Contato', 'left');
        $column_emiemail = new TDataGridColumn('emiemail', 'Email', 'left');
        $column_emicidade = new TDataGridColumn('emicidade', 'Cidade', 'left');
        $column_emiestado = new TDataGridColumn('emiestado', 'Estado', 'left');
        $column_emioperador = new TDataGridColumn('emioperador', 'Operador', 'left');
        $column_emisobre = new TDataGridColumn('emisobre', 'Sobre', 'left');
        
        
        $column_emifoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/emissoras/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });
        $column_emiimagem->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "admin/files/emissoras/".$value;
          $img->style = "width:120px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_emicodigo);
        $this->datagrid->addColumn($column_emicidade);
        $this->datagrid->addColumn($column_eminome);
        $this->datagrid->addColumn($column_emifoto);
        $this->datagrid->addColumn($column_emiimagem);
        $this->datagrid->addColumn($column_emiendereco);
        $this->datagrid->addColumn($column_emibairro);
        $this->datagrid->addColumn($column_emicep);
        $this->datagrid->addColumn($column_emicontato);
        $this->datagrid->addColumn($column_emiemail);
        $this->datagrid->addColumn($column_emiestado);
        $this->datagrid->addColumn($column_emioperador);
        $this->datagrid->addColumn($column_emisobre);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('EmissoraForm', 'onEdit'));
        //$action_edit->setUseButton(TRUE);
        //$action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('emicodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        //$action_del->setUseButton(TRUE);
        //$action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('emicodigo');
        $this->datagrid->addAction($action_del);
        
        /** @aguarde
        // instrumentos
        $action_edit = new TDataGridAction(array('ApresentadorEmissora', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Apresentadores');
        $action_edit->setImage('fa:music blue fa-lg');
        $action_edit->setField('emicodigo');
        $this->datagrid->addAction($action_edit);
         * 
         */
        
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
        $container->add(TPanelGroup::pack('Emissoras', $this->form));
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
            $object = new Emissora($key); // instantiates the Active Record
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
        TSession::setValue('EmissoraList_filter_emicodigo',   NULL);
        TSession::setValue('EmissoraList_filter_eminome',   NULL);
        TSession::setValue('Emissora_filter_emicidade',   NULL);
       

        if (isset($data->emicodigo) AND ($data->emicodigo)) {
            $filter = new TFilter('emicodigo', 'like', "%{$data->emicodigo}%"); // create the filter
            TSession::setValue('EmissoraList_filter_emicodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->eminome) AND ($data->eminome)) {
            $filter = new TFilter('eminome', 'like', "%{$data->eminome}%"); // create the filter
            TSession::setValue('EmissoraList_filter_eminome',   $filter); // stores the filter in the session
        }
        
        if (isset($data->emicidade) AND ($data->emicidade)) {
            $filter = new TFilter('emicidade', 'like', "%{$data->emicidade}%"); // create the filter
            TSession::setValue('Emissora_filter_emicidade',   $filter); // stores the filter in the session
        }


       

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Emissora_filter_data', $data);
        
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
            
            // creates a repository for Emissora
            $repository = new TRepository('Emissora');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'emicodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('EmissoraList_filter_emicodigo')) {
                $criteria->add(TSession::getValue('EmissoraList_filter_emicodigo')); // add the session filter
            }


            if (TSession::getValue('EmissoraList_filter_eminome')) {
                $criteria->add(TSession::getValue('EmissoraList_filter_eminome')); // add the session filter
            }

            if (TSession::getValue('Emissora_filter_emicidade')) {
                $criteria->add(TSession::getValue('Emissora_filter_emicidade')); // add the session filter
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
            $object = new Emissora($key, FALSE); // instantiates the Active Record
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
