<?php
/**
 * EventosLocalList Listing
 * @author  <your name here>
 */
class EventosLocalList extends TPage
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
        $this->form = new TQuickForm('form_search_EventosLocal');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('EventosLocal');
        

        // create the form fields
        $loccodigo = new TEntry('loccodigo');
       // $locnome = new TEntry('locnome');
        $locnome = new TDBCombo('locnome','conexao','EventosLocal','loccodigo',['locnome']);
      //  $loccidade = new TDBCombo('loccodigo','conexao','Cidade','loccodigo',['cidnome']);
        $loccidade = new TEntry('loccidade');
        
      
        $locnome->enableSearch();
       // $loccidade->enableSearch();
     
        // add the fields
        $this->form->addQuickField('Código', $loccodigo,  200 );
        $this->form->addQuickField('Nome do Local de Evento', $locnome,  300 );
        $this->form->addQuickField('Cidade', $loccidade,  300 );
        

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('EventosLocal_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('EventosLocalForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_loccodigo = new TDataGridColumn('loccodigo', 'Cód', 'right');
        $column_locnome = new TDataGridColumn('locnome', 'Local', 'left');
        $column_loccidade = new TDataGridColumn('loccidade', 'Cidade', 'left');
        $column_locendereco = new TDataGridColumn('locendereco', 'Endereço', 'left');
        $column_locbairro = new TDataGridColumn('locbairro', 'Bairro', 'left');
        $column_loccep = new TDataGridColumn('loccep', 'Cep', 'left');
        $column_loccomplemento = new TDataGridColumn('loccomplemento', 'Complemento', 'left');
        $column_locimagem1 = new TDataGridColumn('locimagem1', 'Imagem', 'left');
        $column_locimagem2 = new TDataGridColumn('locimagem2', 'Imagem', 'left');
        $column_locimagem3 = new TDataGridColumn('locimagem3', 'Imagem', 'left');
        $column_locimagem4 = new TDataGridColumn('locimagem4', 'Imagem', 'left');
        $column_locimagem5 = new TDataGridColumn('locimagem5', 'Imagem', 'left');
        $column_locimagem6 = new TDataGridColumn('locimagem6', 'Imagem', 'left');
        
        $column_locfone = new TDataGridColumn('locfone', 'Fone', 'left');
        $column_loccelular = new TDataGridColumn('loccelular', 'Celular', 'left');
        $column_locresponsavel = new TDataGridColumn('locresponsavel', 'Responsável', 'left');
        $column_locfoto = new TDataGridColumn('locfoto', 'Responsavel', 'left');

         $column_locfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/local/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        $column_locimagem1->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/local/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
         $column_locimagem2->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/local/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
         $column_locimagem3->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/local/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
         $column_locimagem4->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/local/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
         $column_locimagem5->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/local/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
         $column_locimagem6->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/local/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_loccodigo);
        $this->datagrid->addColumn($column_loccidade);
        $this->datagrid->addColumn($column_locnome);
        $this->datagrid->addColumn($column_locimagem1);
        $this->datagrid->addColumn($column_locfoto);
        $this->datagrid->addColumn($column_locendereco);
        $this->datagrid->addColumn($column_locbairro);
        $this->datagrid->addColumn($column_locresponsavel);
        $this->datagrid->addColumn($column_loccep);
        $this->datagrid->addColumn($column_loccomplemento);
        $this->datagrid->addColumn($column_locfone);
        $this->datagrid->addColumn($column_loccelular);
        $this->datagrid->addColumn($column_locimagem2);
        $this->datagrid->addColumn($column_locimagem3);
        $this->datagrid->addColumn($column_locimagem4);
        $this->datagrid->addColumn($column_locimagem5);
        $this->datagrid->addColumn($column_locimagem6);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('EventosLocalForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
       // $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('loccodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
      //  $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('loccodigo');
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
        $container->add(TPanelGroup::pack('Eventos Local Listagem', $this->form));
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
            $object = new EventosLocal($key); // instantiates the Active Record
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
        TSession::setValue('EventosLocalList_filter_loccodigo',   NULL);
        TSession::setValue('EventosLocalList_filter_locnome',   NULL);

        if (isset($data->loccodigo) AND ($data->loccodigo)) {
            $filter = new TFilter('loccodigo', 'like', "%{$data->loccodigo}%"); // create the filter
            TSession::setValue('EventosLocalList_filter_loccodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->locnome) AND ($data->locnome)) {
            $filter = new TFilter('locnome', 'like', "%{$data->locnome}%"); // create the filter
            TSession::setValue('EventosLocalList_filter_locnome',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('EventosLocal_filter_data', $data);
        
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
            
            // creates a repository for EventosLocal
            $repository = new TRepository('EventosLocal');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'loccodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('EventosLocalList_filter_loccodigo')) {
                $criteria->add(TSession::getValue('EventosLocalList_filter_loccodigo')); // add the session filter
            }


            if (TSession::getValue('EventosLocalList_filter_locnome')) {
                $criteria->add(TSession::getValue('EventosLocalList_filter_locnome')); // add the session filter
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
            $object = new EventosLocal($key, FALSE); // instantiates the Active Record
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
