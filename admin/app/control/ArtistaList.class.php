<?php
/**
 * ArtistaList Listing
 * @author  <your name here>
 */
class ArtistaList extends TPage
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
        $this->form = new TQuickForm('form_search_Artista');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Listagem de Artistas');
        

        // create the form fields
        // $artcodigo = new TEntry('artcodigo');
        $artnome = new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual} - {artcodigo}','artusual');
       // $artnome = new TEntry('artnome');
        $cidade = new TDBCombo('cidade','conexao','Prefeitura','precodigo','{prenome} - {precodigo}','prenome');
      //  $cidade = new \Adianti\Widget\Form\TCombo('cidade');
    //    $cidade->addItems(DadosFixos::getPrefeituras());

        $artnome->enableSearch();
        $cidade->enableSearch();
        
        // add the fields
        $this->form->addQuickField('Nome Usual Artista', $artnome,  300 );
        $this->form->addQuickField('Cidade Origem', $cidade,  '50%' );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Artista_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('ArtistaForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_artcodigo = new TDataGridColumn('artcodigo', 'Código', 'right');
        $column_artnome = new TDataGridColumn('artnome', 'Nome do Artista', 'left');
        $column_artusual = new TDataGridColumn('artusual', 'Nome Usual', 'left');
        $column_artdatanasc = new TDataGridColumn('artdatanasc', 'Dt.nasc', 'left');
        $column_artendereco = new TDataGridColumn('artendereco', 'Endereço', 'left');
        $column_artbairro = new TDataGridColumn('artbairro', 'Bairro', 'left');
        $column_artcep = new TDataGridColumn('artcep', 'Cep', 'left');
        $column_artuf = new TDataGridColumn('artuf', 'UF', 'left');
        $column_artcidade = new TDataGridColumn('artcidade', 'Cidade', 'left');
        $column_artcomplemento = new TDataGridColumn('artcomplemento', 'Complemento', 'left');
        $column_artsexo = new TDataGridColumn('artsexo', 'Sexo', 'left');
        $column_artfone = new TDataGridColumn('artfone', 'Fone', 'left');
        $column_artcelular = new TDataGridColumn('artcelular', 'Celular', 'left');
        $column_artemail = new TDataGridColumn('artemail', 'Email', 'left');
        $column_artsite = new TDataGridColumn('artsite', 'Site', 'left');
        $column_artfoto = new TDataGridColumn('artfoto', 'Foto', 'left');
        $column_artbiografia = new TDataGridColumn('artbiografia', 'Biografia', 'left');
        $column_arttipocodigo = new TDataGridColumn('arttipocodigo', 'Tipo', 'left');

// criar na grade um ordenação
        $order_artnome = new TAction(array($this, 'onReload'));
        $order_artnome->setParameter('order', 'artnome');
        $column_artnome->setAction($order_artnome);

        $order_artcodigo = new TAction(array($this, 'onReload'));
        $order_artcodigo->setParameter('order', 'artcodigo');
        $column_artcodigo->setAction($order_artcodigo);

         $column_artdatanasc->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });
        
         $column_artfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artnome);
        $this->datagrid->addColumn($column_artusual);
        $this->datagrid->addColumn($column_artfoto);
        $this->datagrid->addColumn($column_arttipocodigo);
        $this->datagrid->addColumn($column_artdatanasc);
        $this->datagrid->addColumn($column_artendereco);
        $this->datagrid->addColumn($column_artbairro);
        $this->datagrid->addColumn($column_artcep);
        $this->datagrid->addColumn($column_artuf);
        $this->datagrid->addColumn($column_artcidade);
        $this->datagrid->addColumn($column_artcomplemento);
        $this->datagrid->addColumn($column_artsexo);
        $this->datagrid->addColumn($column_artfone);
        $this->datagrid->addColumn($column_artcelular);
        $this->datagrid->addColumn($column_artemail);
        $this->datagrid->addColumn($column_artsite); 
        $this->datagrid->addColumn($column_artbiografia);
       
        
        // create EDIT action
        $action_edit = new TDataGridAction(array('ArtistaForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('artcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('artcodigo');
        $this->datagrid->addAction($action_del);
        
         // instrumentos
        $action_edit = new TDataGridAction(array('ArtistaInstrumentoList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Instrumentos');
        $action_edit->setImage('fa:music blue fa-lg');
        $action_edit->setField('artcodigo');
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
        $container->add(TPanelGroup::pack('Artistas Listagem', $this->form));
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
            $object = new Artista($key); // instantiates the Active Record
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
        TSession::setValue('ArtistaList_filter_artnome',   NULL);
        TSession::setValue('ArtistaList_filter_cidade',   NULL);

        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', '=', $data->artcodigo); // create the filter
            TSession::setValue('ArtistaList_filter_artnome',   $filter); // stores the filter in the session
        }

        if (isset($data->cidade) AND ($data->cidade)) {
            $filter = new TFilter('artvinculo', '=', "{$data->cidade}"); // create the filter
            TSession::setValue('ArtistaList_filter_cidade',   $filter); // stores the filter in the session
        }



        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Artista_filter_data', $data);
        
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
            
            // creates a repository for Artista
            $repository = new TRepository('Artista');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $artuser = (int)TSession::getValue('artuser');
            if ($artuser > 0)
                $criteria->add(new TFilter('artcodigo','=',$artuser));
            
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'artcodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('ArtistaList_filter_artnome')) {
                $criteria->add(TSession::getValue('ArtistaList_filter_artnome')); // add the session filter
            }

            if (TSession::getValue('ArtistaList_filter_cidade')) {
                $criteria->add(TSession::getValue('ArtistaList_filter_cidade')); // add the session filter
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
            $object = new Artista($key, FALSE); // instantiates the Active Record
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
