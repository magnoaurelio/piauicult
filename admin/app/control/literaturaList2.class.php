<?php
/**LiteraturaList Listing
 * @author  <your name here>
 */
class LiteraturaList extends TPage
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
        $this->form = new BootstrapFormBuilder('form_Literatura');
        $this->form->setFormTitle('LITERATURA - Publicar');
        

        // create the form fields
        $litcodigo = new TEntry('litcodigo');
        $litnome = new TEntry('litnome');
        $litpagina = new TEntry('litpagina');
        $artcodigo = new \Adianti\Widget\Wrapper\TDBCombo('artcodigo', 'conexao', 'Artista', 'artcodigo', 'artnome');
        $fescodigo = new \Adianti\Widget\Wrapper\TDBCombo('fescodigo', 'conexao', 'Festival', 'fescodigo', 'fesnome');
        $fesprecodigo = new \Adianti\Widget\Wrapper\TDBCombo('fesprcodigo', 'conexao', 'Festival_Premio', 'fesprecodigo', 'fesprenome');
        $litcategoria = new \Adianti\Widget\Wrapper\TDBCombo('litcategoria','conexao','LiteraturaCategoria','codigo','descricao','descricao');
        
        
        $artcodigo->enableSearch();
        $fescodigo->enableSearch();
        $litcategoria->enableSearch();


        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $litcodigo ] );
        $this->form->addFields( [ new TLabel('Nº Pag') ], [ $litpagina ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $litnome ] );
        $this->form->addFields( [ new TLabel('Artista') ], [ $artcodigo ] );
        $this->form->addFields( [ new TLabel('Festival') ], [ $fescodigo ] );
        $this->form->addFields( [ new TLabel('Premio') ], [ $fesprecodigo ] );
        $this->form->addFields( [ new TLabel('Categoria') ], [ $litcategoria ] );


        // set sizes
        $litcodigo->setSize('100%');
        $litpagina->setSize('100%');
        $litnome->setSize('100%');
        $artcodigo->setSize('100%');
        $fescodigo->setSize('100%');
        $fesprecodigo->setSize('100%');
        $litcategoria->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('literatura_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'), new TAction(['LiteraturaForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_litcodigo = new TDataGridColumn('litcodigo', 'Código', 'right');
        $column_litpagina = new TDataGridColumn('litpagina', 'Nº Pag', 'left', 100);
        $column_litnome = new TDataGridColumn('litnome', 'Nome_Desenho', 'left', 100);
        $column_artcodigo = new TDataGridColumn('artista->artusual', 'Artista', 'left', 80);
        $column_artfoto = new TDataGridColumn('artista->artfoto', 'Foto', 'center');
        $column_fescodigo = new TDataGridColumn('festival->fesnome', 'Festival', 'left');
        $column_fesprefoto = new TDataGridColumn('Festival_Premio->fesprefoto', 'Premio', 'left');
        $column_fesprecodigo = new TDataGridColumn('Festival_Premio->fesprenome', 'Colocação', 'left');
        $column_litcategoria = new TDataGridColumn('{categoria->descricao}', 'Categoria', 'right');
        $column_litarquivo = new TDataGridColumn('litarquivo', 'Desenho', 'left');
        $column_litsobre = new TDataGridColumn('litsobre', 'Sobre', 'left');
     
  // var_dump($column_litarquivo);
        $column_litarquivo->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/literatura/".$value;
          $img->style = "width:60px; height:70px;";
            return $img;
        });
        
       
        $column_artfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
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
        $this->datagrid->addColumn($column_litcodigo);
        $this->datagrid->addColumn($column_fescodigo);
        $this->datagrid->addColumn($column_litpagina);
        $this->datagrid->addColumn($column_litnome);
        $this->datagrid->addColumn($column_litarquivo);
        $this->datagrid->addColumn($column_litcategoria);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artfoto);
        $this->datagrid->addColumn($column_fesprecodigo);
        $this->datagrid->addColumn($column_fesprefoto);
        $this->datagrid->addColumn($column_litsobre);
       
        
        // create EDIT action
        $action_edit = new TDataGridAction(['LiteraturaForm', 'onEdit']);
        //$action_edit->setUseButton(TRUE);
        //$action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('litcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        //$action_del->setUseButton(TRUE);
        //$action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('litcodigo');
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
            $object = new Literatura($key); // instantiates the Active Record
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
        TSession::setValue('LiteraturaList_filter_litcodigo',   NULL);
        TSession::setValue('LiteraturaList_filter_litnome',   NULL);
        TSession::setValue('LiteraturaList_filter_artcodigo',   NULL);
        TSession::setValue('LiteraturaList_filter_fescodigo',   NULL);
        TSession::setValue('LiteraturaList_filter_litcategoria',   NULL);

        if (isset($data->litcodigo) AND ($data->litcodigo)) {
            $filter = new TFilter('litcodigo', '=', "$data->litcodigo"); // create the filter
            TSession::setValue('LiteraturaListt_filter_litcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->litnome) AND ($data->litnome)) {
            $filter = new TFilter('litnome', 'like', "%{$data->litnome}%"); // create the filter
            TSession::setValue('LiteraturaList_filter_litnome',   $filter); // stores the filter in the session
        }


        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', '=', "$data->artcodigo"); // create the filter
            TSession::setValue('LiteraturaList_filter_artcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->fescodigo) AND ($data->fescodigo)) {
            $filter = new TFilter('fescodigo', '=', "$data->fescodigo"); // create the filter
            TSession::setValue('LiteraturaList_filter_fescodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->litcategoria) AND ($data->litcategoria)) {
            $filter = new TFilter('litcategoria', 'like', "%{$data->litcategoria}%"); // create the filter
            TSession::setValue('LiteraturaList_filter_litcategoria',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('litor_filter_data', $data);
        
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
            
            // creates a repository for litor
            $repository = new TRepository('Literatura');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'litcodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('LiteraturaList_filter_litcodigo')) {
                $criteria->add(TSession::getValue('LiteraturaList_filter_litcodigo')); // add the session filter
            }


            if (TSession::getValue('LiteraturaList_filter_litnome')) {
                $criteria->add(TSession::getValue('LiteraturaList_filter_litnome')); // add the session filter
            }


            if (TSession::getValue('LiteraturaList_filter_artcodigo')) {
                $criteria->add(TSession::getValue('LiteraturaList_filter_artcodigo')); // add the session filter
            }


            if (TSession::getValue('LiteraturaList_filter_fescodigo')) {
                $criteria->add(TSession::getValue('LiteraturaList_filter_fescodigo')); // add the session filter
            }


            if (TSession::getValue('LiteraturaList_filter_litcategoria')) {
                $criteria->add(TSession::getValue('LiteraturaList_filter_litcategoria')); // add the session filter
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
            $object = new litor($key, FALSE); // instantiates the Active Record
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
