<?php
/**
 * CinemaList Listing
 * @author  <your name here>
 */
class CinemaList extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Cinema');
        $this->form->setFormTitle('Cinema');
        

        // create the form fields
        $cincodigo = new TEntry('cincodigo');
        $cinnome = new TEntry('cinnome');
        $cingenero = new \Adianti\Widget\Wrapper\TDBCombo('cingenero', 'conexao', 'CinemaGenero', 'codigo', 'descricao');
        $fescodigo = new \Adianti\Widget\Wrapper\TDBCombo('fescodigo', 'conexao', 'Festival', 'fescodigo', 'fesnome');
        $fesprecodigo = new \Adianti\Widget\Wrapper\TDBCombo('fesprcodigo', 'conexao', 'Festival_Premio', 'fesprecodigo', 'fesprenome');


        $cingenero->enableSearch();
        $fescodigo->enableSearch();

        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $cincodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $cinnome ] );
        $this->form->addFields( [ new TLabel('Gênero') ], [ $cingenero ] );
        $this->form->addFields( [ new TLabel('Festival') ], [ $fescodigo ] );


        // set sizes
        $cincodigo->setSize('100%');
        $cinnome->setSize('100%');
        $cingenero->setSize('100%');
        $fescodigo->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Cinema_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'), new TAction(['CinemaForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_cincodigo = new TDataGridColumn('cincodigo', 'Código', 'right');
        $column_cinnome = new TDataGridColumn('cinnome', 'Nome', 'left');
        $column_cingenero = new TDataGridColumn('genero->descricao', 'Gênero', 'right');
        $column_cinduracao = new TDataGridColumn('cinduracao', 'Duração', 'right');
        $column_cinsobre = new TDataGridColumn('cinsobre', 'Sobre', 'left');
        $column_cindata = new TDataGridColumn('cindata', 'Data', 'left');
        $column_cinimagem = new TDataGridColumn('cinimagem', 'Imagem', 'right');
        $column_fescodigo = new TDataGridColumn('festival->fesnome', 'Festival', 'left');
        $column_fesprefoto = new TDataGridColumn('Festival_Premio->fesprefoto', 'Premio', 'left');
        $column_fesprecodigo = new TDataGridColumn('Festival_Premio->fesprenome', 'Colocação', 'left');

        $column_cindata->setTransformer( function($value, $object, $row) {
            return \Adianti\Widget\Form\TDate::date2br($value);
        });


        $column_cinimagem->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/cinema/".$value;
            $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        $column_fesprefoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/festivais/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_cincodigo);
        $this->datagrid->addColumn($column_cinnome);
        $this->datagrid->addColumn($column_cingenero);
        $this->datagrid->addColumn($column_cinimagem);
        $this->datagrid->addColumn($column_cinduracao);
        $this->datagrid->addColumn($column_fesprefoto);
        $this->datagrid->addColumn($column_fesprecodigo);
        $this->datagrid->addColumn($column_cindata);
        $this->datagrid->addColumn($column_fescodigo);
        $this->datagrid->addColumn($column_cinsobre);
       

        
        // create EDIT action
        $action_edit = new TDataGridAction(['CinemaForm', 'onEdit']);
        //$action_edit->setUseButton(TRUE);
        //$action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('cincodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        //$action_del->setUseButton(TRUE);
        //$action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('cincodigo');
        $this->datagrid->addAction($action_del);

        $action_del = new TDataGridAction(array('CinemaElencoFormList', 'onLoad'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel('Elenco');
        $action_del->setImage('fa:star yellow fa-lg');
        $action_del->setField('cincodigo');
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
            $object = new Cinema($key); // instantiates the Active Record
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
        TSession::setValue('CinemaList_filter_cincodigo',   NULL);
        TSession::setValue('CinemaList_filter_cinnome',   NULL);
        TSession::setValue('CinemaList_filter_cingenero',   NULL);
        TSession::setValue('CinemaList_filter_fescodigo',   NULL);

        if (isset($data->cincodigo) AND ($data->cincodigo)) {
            $filter = new TFilter('cincodigo', '=', "$data->cincodigo"); // create the filter
            TSession::setValue('CinemaList_filter_cincodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->cinnome) AND ($data->cinnome)) {
            $filter = new TFilter('cinnome', 'like', "%{$data->cinnome}%"); // create the filter
            TSession::setValue('CinemaList_filter_cinnome',   $filter); // stores the filter in the session
        }


        if (isset($data->cingenero) AND ($data->cingenero)) {
            $filter = new TFilter('cingenero', '=', "$data->cingenero"); // create the filter
            TSession::setValue('CinemaList_filter_cingenero',   $filter); // stores the filter in the session
        }


        if (isset($data->fescodigo) AND ($data->fescodigo)) {
            $filter = new TFilter('fescodigo', '=', "$data->fescodigo"); // create the filter
            TSession::setValue('CinemaList_filter_fescodigo',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Cinema_filter_data', $data);
        
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
            
            // creates a repository for Cinema
            $repository = new TRepository('Cinema');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'cincodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('CinemaList_filter_cincodigo')) {
                $criteria->add(TSession::getValue('CinemaList_filter_cincodigo')); // add the session filter
            }


            if (TSession::getValue('CinemaList_filter_cinnome')) {
                $criteria->add(TSession::getValue('CinemaList_filter_cinnome')); // add the session filter
            }


            if (TSession::getValue('CinemaList_filter_cingenero')) {
                $criteria->add(TSession::getValue('CinemaList_filter_cingenero')); // add the session filter
            }


            if (TSession::getValue('CinemaList_filter_fescodigo')) {
                $criteria->add(TSession::getValue('CinemaList_filter_fescodigo')); // add the session filter
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
            $object = new Cinema($key, FALSE); // instantiates the Active Record
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
