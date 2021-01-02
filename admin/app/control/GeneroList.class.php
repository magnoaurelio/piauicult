<?php
//<fileHeader>

//</fileHeader>

class GeneroList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'conexao';
    private static $activeRecord = 'Genero';
    private static $primaryKey = 'gencodigo';
    private static $formName = 'formList_Genero';
    private $showMethods = ['onReload', 'onSearch'];

    //<classProperties>

    //</classProperties>

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Listagem de gÊnero listagem");

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $gencodigo = new TEntry('gencodigo');
        $gennome = new TEntry('gennome');
        $genimagem = new TEntry('genimagem');

       // $gennome->setValue('1');

        $gencodigo->setSize(100);
        $gennome->setSize('100%');

        $gencodigo->setMaxLength(5);
        $gennome->setMaxLength(100);

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("ID_Gen:", null, '14px', null, '100%'),$gencodigo],[new TLabel("Nome:", null, '14px', null, '100%'),$gennome]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fa:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'fa:file #000000');
        $btn_onexportcsv->addStyleClass('btn-warning'); 

        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['GeneroForm', 'onShow']), 'fa:plus #ffffff');
        $btn_onshow->addStyleClass('btn-success'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
      //  $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_gencodigo = new TDataGridColumn('gencodigo', "ID_Gen", 'center' , '70px');
        $column_gennome = new TDataGridColumn('gennome', "Nome", 'left');
        $column_genorigem = new TDataGridColumn('genorigem', "Origem", 'left');
        $column_genimagem = new TDataGridColumn('genimagem', "Imagem", 'left');

     //   $column_genorigem->enableAutoHide('50');

        $order_gencodigo = new TAction(array($this, 'onReload'));
        $order_gencodigo->setParameter('order', 'gencodigo');
        $column_gencodigo->setAction($order_gencodigo);
        
        $order_gennome = new TAction(array($this, 'onReload'));
        $order_gennome->setParameter('order', 'gennome');
        $column_gennome->setAction($order_gennome);

        //<onBeforeColumnsCreation>
        $column_genimagem->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/instrumento/".$value;
            $img->style = "width:100px; height:100px;";
            return $img;
        });
        //</onBeforeColumnsCreation>
        $this->datagrid->addColumn($column_gencodigo);
        $this->datagrid->addColumn($column_gennome);
        $this->datagrid->addColumn($column_genorigem);
        $this->datagrid->addColumn($column_genimagem);

        //<onAfterColumnsCreation>

        //</onAfterColumnsCreation>

        $action_onEdit = new TDataGridAction(array('GeneroForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('fa:edit fa-lg #478fca');
        $action_onEdit->setField(self::$primaryKey);
        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('GeneroList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fa:trash fa-lg #dd5a43');
        $action_onDelete->setField(self::$primaryKey);
        $this->datagrid->addAction($action_onDelete);
        
        // instrumentos
        $action_editar = new TDataGridAction(array('GeneroInstrumentoList', 'onLoad'));
        $action_editar->setUseButton(TRUE);
        $action_editar->setButtonClass('btn btn-default');
        $action_editar->setLabel('Instrumentos');
        $action_editar->setImage('fa:music blue fa-lg');
        $action_editar->setField('gencodigo');
        $this->datagrid->addAction($action_editar);
        
        // instrumentos
        $action_editarArt = new TDataGridAction(array('GeneroArtistaList', 'onLoad'));
        $action_editarArt->setUseButton(TRUE);
        $action_editarArt->setButtonClass('btn btn-default');
        $action_editarArt->setLabel('Artistas');
        $action_editarArt->setImage('fa:star blue fa-lg');
        $action_editarArt->setField('gencodigo');
        $this->datagrid->addAction($action_editarArt);
        
        /** @aguarde // create EDIT action
        $action_editarArt = new TDataGridAction(array('GeneroArtistaList', 'onLoad'));
        $action_editarArt->setUseButton(TRUE);
        $action_editarArt->setButtonClass('btn btn-default');
        $action_editarArt->setLabel('Artistas');
        $action_editarArt->setImage('fa:star blue fa-lg');
        $action_editarArt->setField('gencodigo');
        $this->datagrid->addAction($action_editarArt);
         * 
         */

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
    //    $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["PIAUICULT","GÊNERO Listagem"]));
        $container->add($this->form);
        $container->add($panel);

        //<onAfterPageCreation>

        //</onAfterPageCreation>

        parent::add($container);

    }

//<generated-DatagridAction-onDelete>
    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new Genero($key, FALSE); //</blockLine>

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }
//</generated-DatagridAction-onDelete>
//<generated-FormAction-onExportCsv>
    public function onExportCsv($param = null) 
    {
        try
        {
            $this->onSearch();

            TTransaction::open(self::$database); // open a transaction
            $repository = new TRepository(self::$activeRecord); // creates a repository for Customer
            $criteria = $this->filter_criteria;

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            $records = $repository->load($criteria); // load the objects according to criteria
            if ($records)
            {
                $file = 'tmp/'.uniqid().'.csv';
                $handle = fopen($file, 'w');
                $columns = $this->datagrid->getColumns();

                $csvColumns = [];
                foreach($columns as $column)
                {
                    $csvColumns[] = $column->getLabel();
                }
                fputcsv($handle, $csvColumns, ';');

                foreach ($records as $record)
                {
                    $csvColumns = [];
                    foreach($columns as $column)
                    {
                        $name = $column->getName();
                        $csvColumns[] = $record->{$name};
                    }
                    fputcsv($handle, $csvColumns, ';');
                }
                fclose($handle);

                TPage::openFile($file);
            }
            else
            {
                new TMessage('info', _t('No records found'));       
            }

            TTransaction::close(); // close the transaction
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
//</generated-FormAction-onExportCsv>

    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        //<onBeforeDatagridSearch>

        //</onBeforeDatagridSearch> 

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->gencodigo) AND ( (is_scalar($data->gencodigo) AND $data->gencodigo !== '') OR (is_array($data->gencodigo) AND (!empty($data->gencodigo)) )) )
        {

            $filters[] = new TFilter('gencodigo', '=', $data->gencodigo);// create the filter 
        }

        if (isset($data->gennome) AND ( (is_scalar($data->gennome) AND $data->gennome !== '') OR (is_array($data->gennome) AND (!empty($data->gennome)) )) )
        {

            $filters[] = new TFilter('gennome', 'like', "%{$data->gennome}%");// create the filter 
        }

        $param = array();
        $param['offset']     = 0;
        $param['first_page'] = 1;

        //<onDatagridSearch>

        //</onDatagridSearch>

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload($param);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'portaltransparencia'
            TTransaction::open(self::$database);

            // creates a repository for Genero
            $repository = new TRepository(self::$activeRecord);
            $limit = 20;

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'gencodigo';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            //<onBeforeDatagridLoad>

            //</onBeforeDatagridLoad>

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    //<onBeforeDatagridAddItem>

                    //</onBeforeDatagridAddItem>
                    $this->datagrid->addItem($object);
                    //<onAfterDatagridAddItem>

                    //</onAfterDatagridAddItem>
                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit

            //<onBeforeDatagridTransactionClose>

            //</onBeforeDatagridTransactionClose>

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

    public function onShow($param = null)
    {
        //<onShow>

        //</onShow>
    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
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

    //</hideLine> <addUserFunctionsCode/>

    //<userCustomFunctions>

    //</userCustomFunctions>

}