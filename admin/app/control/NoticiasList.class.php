<?php
/**
 * NoticiasList Listing
 * @author  <your name here>
 */
class NoticiasList extends TPage
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
        $this->form = new TQuickForm('form_search_Noticias');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Noticias');
        

        // create the form fields
        $notid = new TEntry('notid');
      //  $nottitulo = new TEntry('nottitulo');
        $nottitulo = new TEntry('nottitulo');
        $notfoto =  new TEntry('notfoto');
        $notfoto1 = new TEntry('notfoto1');
        $notfoto2 = new TEntry('notfoto2');
        $notfoto3 = new TEntry('notfoto3');
        $notfoto4 = new TEntry('notfoto4');
        $notfoto5 = new TEntry('notfoto5');
        $notfoto6 = new TEntry('notfoto6');
        $notnoticia = new TEntry('notnoticia');
        $notdata = new TEntry('notdata');
    //    $artcodigo = new TEntry('artcodigo');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','artusual','artusual');
        $notvisita = new TEntry('notvisita');
        $nottipo = new TEntry('nottipo');
        $notestado = new TEntry('notestado');
        $notinclui = new TEntry('notinclui');
        $notaltera = new TEntry('notaltera');
        $notexclui = new TEntry('notexclui');
        $notmesano = new TEntry('notmesano');
        $usuid = new TEntry('usuid');
        $home = new TEntry('home');
        
        $artcodigo->enableSearch();
        // add the fields

        $this->form->addQuickField('Título', $nottitulo,  300 );
        $this->form->addQuickField('Artista', $artcodigo,  300 );
        

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Noticias_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('NoticiasForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_notid = new TDataGridColumn('notid', 'ID', 'right');
        $column_nottitulo = new TDataGridColumn('nottitulo', 'Título', 'left');
        $column_notfoto = new TDataGridColumn('notfoto', 'Imagem', 'left');
        $column_notfoto1 = new TDataGridColumn('notfoto1', 'Notfoto1', 'left');
        $column_notfoto2 = new TDataGridColumn('notfoto2', 'Notfoto2', 'left');
        $column_notfoto3 = new TDataGridColumn('notfoto3', 'Notfoto3', 'left');
        $column_notfoto4 = new TDataGridColumn('notfoto4', 'Notfoto4', 'left');
        $column_notfoto5 = new TDataGridColumn('notfoto5', 'Notfoto5', 'left');
        $column_notfoto6 = new TDataGridColumn('notfoto6', 'Notfoto6', 'left');
        $column_notnoticia = new TDataGridColumn('notnoticia', 'Notnoticia', 'left');
        $column_notdata = new TDataGridColumn('notdata', 'Notdata', 'left');
        $column_artcodigo = new TDataGridColumn('Artista->artusual', 'Artista', 'left');
        $column_artfoto = new TDataGridColumn('Artista->artfoto', 'Foto', 'left');
        $column_notvisita = new TDataGridColumn('notvisita', 'Notvisita', 'right');
        $column_nottipo = new TDataGridColumn('nottipo', 'Nottipo', 'left');
        $column_notestado = new TDataGridColumn('notestado', 'Notestado', 'left');
        $column_notinclui = new TDataGridColumn('notinclui', 'Notinclui', 'left');
        $column_notaltera = new TDataGridColumn('notaltera', 'Notaltera', 'left');
        $column_notexclui = new TDataGridColumn('notexclui', 'Notexclui', 'left');
        $column_notmesano = new TDataGridColumn('notmesano', 'Notmesano', 'left');
        $column_usuid = new TDataGridColumn('usuid', 'Usuid', 'right');
        $column_home = new TDataGridColumn('home', 'Home', 'right');

        
        $column_notfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/noticias/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
          
       $column_artfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_notid);
        $this->datagrid->addColumn($column_nottitulo);
        $this->datagrid->addColumn($column_notfoto);
       // $this->datagrid->addColumn($column_notfoto1);
       // $this->datagrid->addColumn($column_notfoto2);
       // $this->datagrid->addColumn($column_notfoto3);
       // $this->datagrid->addColumn($column_notfoto4);
        //$this->datagrid->addColumn($column_notfoto5);
        //$this->datagrid->addColumn($column_notfoto6);
       // $this->datagrid->addColumn($column_notnoticia);
       // $this->datagrid->addColumn($column_notdata);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artfoto);
       // $this->datagrid->addColumn($column_notvisita);
       // $this->datagrid->addColumn($column_nottipo);
       // $this->datagrid->addColumn($column_notestado);
       // $this->datagrid->addColumn($column_notinclui);
       // $this->datagrid->addColumn($column_notaltera);
       // $this->datagrid->addColumn($column_notexclui);
       // $this->datagrid->addColumn($column_notmesano);
       // $this->datagrid->addColumn($column_usuid);
        $this->datagrid->addColumn($column_home);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('NoticiasForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('notid');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('notid');
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
        $container->add(TPanelGroup::pack('Notícia Listagem', $this->form));
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
            $object = new Noticias($key); // instantiates the Active Record
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
        TSession::setValue('NoticiasList_filter_notid',   NULL);
        TSession::setValue('NoticiasList_filter_nottitulo',   NULL);
        TSession::setValue('NoticiasList_filter_notfoto',   NULL);
        TSession::setValue('NoticiasList_filter_notfoto1',   NULL);
        TSession::setValue('NoticiasList_filter_notfoto2',   NULL);
        TSession::setValue('NoticiasList_filter_notfoto3',   NULL);
        TSession::setValue('NoticiasList_filter_notfoto4',   NULL);
        TSession::setValue('NoticiasList_filter_notfoto5',   NULL);
        TSession::setValue('NoticiasList_filter_notfoto6',   NULL);
        TSession::setValue('NoticiasList_filter_notnoticia',   NULL);
        TSession::setValue('NoticiasList_filter_notdata',   NULL);
        TSession::setValue('NoticiasList_filter_artcodigo',   NULL);
        TSession::setValue('NoticiasList_filter_notvisita',   NULL);
        TSession::setValue('NoticiasList_filter_nottipo',   NULL);
        TSession::setValue('NoticiasList_filter_notestado',   NULL);
        TSession::setValue('NoticiasList_filter_notinclui',   NULL);
        TSession::setValue('NoticiasList_filter_notaltera',   NULL);
        TSession::setValue('NoticiasList_filter_notexclui',   NULL);
        TSession::setValue('NoticiasList_filter_notmesano',   NULL);
        TSession::setValue('NoticiasList_filter_usuid',   NULL);
        TSession::setValue('NoticiasList_filter_home',   NULL);

        if (isset($data->notid) AND ($data->notid)) {
            $filter = new TFilter('notid', 'like', "%{$data->notid}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notid',   $filter); // stores the filter in the session
        }


        if (isset($data->nottitulo) AND ($data->nottitulo)) {
            $filter = new TFilter('nottitulo', 'like', "%{$data->nottitulo}%"); // create the filter
            TSession::setValue('NoticiasList_filter_nottitulo',   $filter); // stores the filter in the session
        }


        if (isset($data->notfoto) AND ($data->notfoto)) {
            $filter = new TFilter('notfoto', 'like', "%{$data->notfoto}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notfoto',   $filter); // stores the filter in the session
        }


        if (isset($data->notfoto1) AND ($data->notfoto1)) {
            $filter = new TFilter('notfoto1', 'like', "%{$data->notfoto1}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notfoto1',   $filter); // stores the filter in the session
        }


        if (isset($data->notfoto2) AND ($data->notfoto2)) {
            $filter = new TFilter('notfoto2', 'like', "%{$data->notfoto2}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notfoto2',   $filter); // stores the filter in the session
        }


        if (isset($data->notfoto3) AND ($data->notfoto3)) {
            $filter = new TFilter('notfoto3', 'like', "%{$data->notfoto3}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notfoto3',   $filter); // stores the filter in the session
        }


        if (isset($data->notfoto4) AND ($data->notfoto4)) {
            $filter = new TFilter('notfoto4', 'like', "%{$data->notfoto4}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notfoto4',   $filter); // stores the filter in the session
        }


        if (isset($data->notfoto5) AND ($data->notfoto5)) {
            $filter = new TFilter('notfoto5', 'like', "%{$data->notfoto5}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notfoto5',   $filter); // stores the filter in the session
        }


        if (isset($data->notfoto6) AND ($data->notfoto6)) {
            $filter = new TFilter('notfoto6', 'like', "%{$data->notfoto6}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notfoto6',   $filter); // stores the filter in the session
        }


        if (isset($data->notnoticia) AND ($data->notnoticia)) {
            $filter = new TFilter('notnoticia', 'like', "%{$data->notnoticia}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notnoticia',   $filter); // stores the filter in the session
        }


        if (isset($data->notdata) AND ($data->notdata)) {
            $filter = new TFilter('notdata', 'like', "%{$data->notdata}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notdata',   $filter); // stores the filter in the session
        }


        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', 'like', "%{$data->artcodigo}%"); // create the filter
            TSession::setValue('NoticiasList_filter_artcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->notvisita) AND ($data->notvisita)) {
            $filter = new TFilter('notvisita', 'like', "%{$data->notvisita}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notvisita',   $filter); // stores the filter in the session
        }


        if (isset($data->nottipo) AND ($data->nottipo)) {
            $filter = new TFilter('nottipo', 'like', "%{$data->nottipo}%"); // create the filter
            TSession::setValue('NoticiasList_filter_nottipo',   $filter); // stores the filter in the session
        }


        if (isset($data->notestado) AND ($data->notestado)) {
            $filter = new TFilter('notestado', 'like', "%{$data->notestado}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notestado',   $filter); // stores the filter in the session
        }


        if (isset($data->notinclui) AND ($data->notinclui)) {
            $filter = new TFilter('notinclui', 'like', "%{$data->notinclui}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notinclui',   $filter); // stores the filter in the session
        }


        if (isset($data->notaltera) AND ($data->notaltera)) {
            $filter = new TFilter('notaltera', 'like', "%{$data->notaltera}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notaltera',   $filter); // stores the filter in the session
        }


        if (isset($data->notexclui) AND ($data->notexclui)) {
            $filter = new TFilter('notexclui', 'like', "%{$data->notexclui}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notexclui',   $filter); // stores the filter in the session
        }


        if (isset($data->notmesano) AND ($data->notmesano)) {
            $filter = new TFilter('notmesano', 'like', "%{$data->notmesano}%"); // create the filter
            TSession::setValue('NoticiasList_filter_notmesano',   $filter); // stores the filter in the session
        }


        if (isset($data->usuid) AND ($data->usuid)) {
            $filter = new TFilter('usuid', 'like', "%{$data->usuid}%"); // create the filter
            TSession::setValue('NoticiasList_filter_usuid',   $filter); // stores the filter in the session
        }


        if (isset($data->home) AND ($data->home)) {
            $filter = new TFilter('home', 'like', "%{$data->home}%"); // create the filter
            TSession::setValue('NoticiasList_filter_home',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Noticias_filter_data', $data);
        
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
            
            // creates a repository for Noticias
            $repository = new TRepository('Noticias');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'notid';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('NoticiasList_filter_notid')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notid')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_nottitulo')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_nottitulo')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notfoto')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notfoto')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notfoto1')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notfoto1')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notfoto2')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notfoto2')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notfoto3')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notfoto3')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notfoto4')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notfoto4')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notfoto5')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notfoto5')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notfoto6')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notfoto6')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notnoticia')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notnoticia')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notdata')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notdata')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_artcodigo')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_artcodigo')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notvisita')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notvisita')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_nottipo')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_nottipo')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notestado')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notestado')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notinclui')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notinclui')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notaltera')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notaltera')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notexclui')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notexclui')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_notmesano')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_notmesano')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_usuid')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_usuid')); // add the session filter
            }


            if (TSession::getValue('NoticiasList_filter_home')) {
                $criteria->add(TSession::getValue('NoticiasList_filter_home')); // add the session filter
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
            $object = new Noticias($key, FALSE); // instantiates the Active Record
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
