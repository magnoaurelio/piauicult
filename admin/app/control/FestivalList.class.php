<?php
/**
 * FestivalList Listing
 * @author  <your name here>
 */
class FestivalList extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Festival');
        $this->form->setFormTitle('Festival Diversos');
        

        // create the form fields
        $fescodigo = new TEntry('fescodigo');
        $fesnome = new TEntry('fesnome');


        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $fescodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $fesnome ] );


        // set sizes
        $fescodigo->setSize('100%');
        $fesnome->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Festival_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'),  new TAction(array('FestivalForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
       // $column_artcodigo = new TDataGridColumn('artista->artusual', 'Artista', 'left');  
       // $column_artfoto = new TDataGridColumn('artista->artfoto', 'Artista', 'center');  
        // creates the datagrid columns
        $column_fescodigo = new TDataGridColumn('fescodigo', 'Código', 'right');
        $column_fesnome = new TDataGridColumn('fesnome', 'Nome', 'left');
        $column_festema = new TDataGridColumn('festema', 'Temática', 'left');
        $column_festiponome = new TDataGridColumn('tipo->festiponome', 'Tipo Festival', 'left'); // festipocodigo
        $column_fesimagem = new TDataGridColumn('fesimagem', 'Imagem', 'left');
        $column_fesfoto1 = new TDataGridColumn('fesfoto1', 'Foto1', 'left');
        $column_fesfoto2 = new TDataGridColumn('fesfoto2', 'Foto2', 'left');
        $column_fesfoto3 = new TDataGridColumn('fesfoto3', 'Foto3', 'left');
        $column_fesdata = new TDataGridColumn('fesdata', 'Data', 'left');
        $column_fesperiodo = new TDataGridColumn('fesperiodo', 'Periodo', 'left');
        $column_precodigo = new TDataGridColumn('precodigo', 'Precodigo', 'left');
        $column_fessobre = new TDataGridColumn('fessobre', 'Sobre', 'left');
        $column_fesoutros = new TDataGridColumn('fesoutros', 'Outros', 'left');
        $column_festipocodigo = new TDataGridColumn('festipocodigo', 'Tipo Festival', 'left');
        $column_procodigo = new TDataGridColumn('procodigo', 'Nome Projeto', 'right');
        $column_fesprodutor = new TDataGridColumn('fesprodutor', 'Produtor', 'left');

        
     //   $column_fesprodutor->setTransformer( function($value, $object, $row) {
     //       $img  = new TElement('img');
     //       $img->src = "files/artistas/".$value;
     //       $img->title = $object->artusual;
     //       $img->style = "width:60px; height:60px;";
     //       return $img;
     //   });
        
         $column_fesimagem->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/festivais/".$value;
            $img->title = $object->artusual;
            $img->style = "width:60px; height:60px;";
            return $img;
        });
        
         $column_fesfoto1->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/festivais/".$value;
            $img->title = $object->artusual;
            $img->style = "width:90px; height:60px;";
            return $img;
        });
                
        $column_fesfoto2->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/festivais/".$value;
            $img->title = $object->artusual;
            $img->style = "width:90px; height:60px;";
            return $img;
        });
        
         $column_fesfoto3->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/festivais/".$value;
            $img->title = $object->artusual;
            $img->style = "width:90px; height:60px;";
            return $img;
        });
        

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_fescodigo);
        $this->datagrid->addColumn($column_fesnome);
        $this->datagrid->addColumn($column_fesnome);
        $this->datagrid->addColumn($column_fesprodutor);
        $this->datagrid->addColumn($column_fesimagem);
        $this->datagrid->addColumn($column_fesfoto1);
        $this->datagrid->addColumn($column_fesfoto2);
        $this->datagrid->addColumn($column_fesfoto3);
        $this->datagrid->addColumn($column_fesdata);
        $this->datagrid->addColumn($column_fesperiodo);
        $this->datagrid->addColumn($column_festiponome);
        $this->datagrid->addColumn($column_precodigo);
        $this->datagrid->addColumn($column_procodigo);
        $this->datagrid->addColumn($column_fessobre);
        $this->datagrid->addColumn($column_fesoutros);
        
        
       
      


    
        
        // create EDIT action
        $action_edit = new TDataGridAction(['FestivalForm', 'onEdit']);
        //$action_edit->setUseButton(TRUE);
        //$action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('fescodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        //$action_del->setUseButton(TRUE);
        //$action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('fescodigo');
        $this->datagrid->addAction($action_del);

        $action_group = new TDataGridActionGroup('Opções ', 'bs:th');
        $action_group->addHeader('Composições');

        $action_edit = new TDataGridAction(array('FestivalArtistaList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Artistas');
        $action_edit->setImage('fa:group blue fa-lg');
        $action_edit->setField('fescodigo');
        $action_group->addAction($action_edit);


        $action_edit = new TDataGridAction(array('FestivalMusicaList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Músicas');
        $action_edit->setImage('fa:music blue fa-lg');
        $action_edit->setField('fescodigo');
        $action_group->addAction($action_edit);


        $this->datagrid->addActionGroup($action_group);
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
            $object = new Festival($key); // instantiates the Active Record
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
        TSession::setValue('FestivalList_filter_fescodigo',   NULL);
        TSession::setValue('FestivalList_filter_fesnome',   NULL);

        if (isset($data->fescodigo) AND ($data->fescodigo)) {
            $filter = new TFilter('fescodigo', 'like', "%{$data->fescodigo}%"); // create the filter
            TSession::setValue('FestivalList_filter_fescodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->fesnome) AND ($data->fesnome)) {
            $filter = new TFilter('fesnome', 'like', "%{$data->fesnome}%"); // create the filter
            TSession::setValue('FestivalList_filter_fesnome',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Festival_filter_data', $data);
        
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
            
            // creates a repository for Festival
            $repository = new TRepository('Festival');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'fescodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('FestivalList_filter_fescodigo')) {
                $criteria->add(TSession::getValue('FestivalList_filter_fescodigo')); // add the session filter
            }


            if (TSession::getValue('FestivalList_filter_fesnome')) {
                $criteria->add(TSession::getValue('FestivalList_filter_fesnome')); // add the session filter
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
            $object = new Festival($key, FALSE); // instantiates the Active Record
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
