<?php

//<fileHeader>

//</fileHeader>

class PrefeituraList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'conexao';
    private static $activeRecord = 'Prefeitura';
    private static $primaryKey = 'precodigo';
    private static $formName = 'formList_Prefeitura';
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
        $this->form->setFormTitle("Listagem de prefeitura ");

        //<onBeginPageCreation>
    
  
       
        //</onBeginPageCreation>

        $precodigo = new TEntry('precodigo');
        $prenome   = new TEntry('prenome');
        $prenomep  = new TEntry('prenomep');
        $prenomeu  = new TEntry('prenomeu');
        $predata  = new TEntry('predata');
        
     //   $predata->setDatabaseMask('yyyy-mm-dd');
     //   $predata->setMask('dd/mm/yyyy');
        $prenome->forceUpperCase();
        $prenomep->forceUpperCase();

        $precodigo->setSize(100);
        $prenome->setSize('100%');
        $prenomep->setSize('100%');
        $prenomeu->setSize('100%');

        $precodigo->setMaxLength(3);
        $prenome->setMaxLength(200);
        $prenomep->setMaxLength(200);
        $prenomeu->setMaxLength(100);

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$precodigo],[new TLabel("Nome:", null, '14px', null)],[$prenome]);
        $row2 = $this->form->addFields([new TLabel("Gestor:", null, '14px', null)],[$prenomep],[new TLabel("Nome usual:", null, '14px', null)],[$prenomeu]);

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fa:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'fa:file #000000');
        $btn_onexportcsv->addStyleClass('btn-warning'); 

        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['PrefeituraForm', 'onShow']), 'fa:plus #ffffff');
        $btn_onshow->addStyleClass('btn-success'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
   //     $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_precodigo = new TDataGridColumn('precodigo', "Código", 'center' , '52px');
        $column_prenome = new TDataGridColumn('prenome', "Município", 'left');
        $column_prenomep = new TDataGridColumn('prenomep', "Prefeito(a)", 'left');
        $column_prenomeu = new TDataGridColumn('prenomeu', "Nome usual", 'left');
        $column_predata = new TDataGridColumn('predata', "Data", 'left');
        $column_precep = new TDataGridColumn('precep', "CEP", 'left');
        $column_prebairro = new TDataGridColumn('prebairro', "Bairro", 'left');
        $column_precnpj = new TDataGridColumn('precnpj', "CNPJ", 'left');
        $column_preimagem = new TDataGridColumn('preimagem', "Imagem", 'left');
        $column_prefoto = new TDataGridColumn('prefoto', "Foto", 'left');
        $column_prelogo = new TDataGridColumn('prelogo', "Logomarca", 'left');
        $column_prebrasao = new TDataGridColumn('prebrasao', "Brasão", 'left');
        $column_prebandeira = new TDataGridColumn('prebandeira', "Bandeira", 'left');
        $column_preddd = new TDataGridColumn('preddd', "DDD", 'left');
        $column_prefone = new TDataGridColumn('prefone', "Fone / Celular", 'left');

        $order_precodigo = new TAction(array($this, 'onReload'));
        $order_precodigo->setParameter('order', 'precodigo');
        $column_precodigo->setAction($order_precodigo);
        
        $order_prenome = new TAction(array($this, 'onReload'));
        $order_prenome->setParameter('order', 'prenome');
        $column_prenome->setAction($order_prenome);
        
        $order_prenomep = new TAction(array($this, 'onReload'));
        $order_prenomep->setParameter('order', 'prenomep');
        $column_prenomep->setAction($order_prenomep);
        
        
        /** @TRANSFORMA_DATA <importante FORMATO BRASIL> */
         $column_predata->setTransformer(function($value, $object, $row)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });
        
        $column_prebrasao->setTransformer( function($value, $object, $row) {
        $img = "files/prefeituras/".$object->precodigo."/".$value;
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:60px; height:60px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
      
       
        $column_prelogo->setTransformer( function($value, $object, $row) {
        $img = "files/prefeituras/".$object->precodigo."/".$value;
       
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:100px; height:60px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
        $column_preimagem->setTransformer( function($value, $object, $row) {
        $img = "files/prefeituras/".$object->precodigo."/".$value;
       //  var_dump($img);
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:100px; height:60px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
    
        $column_prefoto->setTransformer( function($value, $object, $row) {
        $img = "files/prefeituras/".$object->precodigo."/".$value;
       //  var_dump($img);
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:60px; height:60px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
        $column_prebandeira->setTransformer( function($value, $object, $row) {
        $img = "files/prefeituras/".$object->precodigo."/".$value;
       //  var_dump($img);
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:100px; height:60px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
        //</onBeforeColumnsCreation>
        $this->datagrid->addColumn($column_precodigo);
        $this->datagrid->addColumn($column_prenome);
        $this->datagrid->addColumn($column_prenomep);
        $this->datagrid->addColumn($column_prenomeu);
    //    $this->datagrid->addColumn($column_predata);
        $this->datagrid->addColumn($column_prefoto);
     //   $this->datagrid->addColumn($column_precep);
     //   $this->datagrid->addColumn($column_prebairro);
     //   $this->datagrid->addColumn($column_precnpj);
        $this->datagrid->addColumn($column_preimagem);
     //   $this->datagrid->addColumn($column_prelogo);
        $this->datagrid->addColumn($column_prebrasao);
        $this->datagrid->addColumn($column_prebandeira);
     //   $this->datagrid->addColumn($column_preddd);
     //   $this->datagrid->addColumn($column_prefone);

        //<onAfterColumnsCreation>

        //</onAfterColumnsCreation>

        $action_onEdit = new TDataGridAction(array('PrefeituraForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('fa:edit  fa-lg #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('PrefeituraList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fa:trash  fa-lg #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
   //     $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["PIAUICULT","PREFEITURA Listagem"]));
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
                $object = new Prefeitura($key, FALSE); //</blockLine>

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

        if (isset($data->precodigo) AND ( (is_scalar($data->precodigo) AND $data->precodigo !== '') OR (is_array($data->precodigo) AND (!empty($data->precodigo)) )) )
        {

            $filters[] = new TFilter('precodigo', '=', $data->precodigo);// create the filter 
        }

        if (isset($data->prenome) AND ( (is_scalar($data->prenome) AND $data->prenome !== '') OR (is_array($data->prenome) AND (!empty($data->prenome)) )) )
        {

            $filters[] = new TFilter('prenome', 'like', "%{$data->prenome}%");// create the filter 
        }

        if (isset($data->prenomep) AND ( (is_scalar($data->prenomep) AND $data->prenomep !== '') OR (is_array($data->prenomep) AND (!empty($data->prenomep)) )) )
        {

            $filters[] = new TFilter('prenomep', 'like', "%{$data->prenomep}%");// create the filter 
        }

        if (isset($data->prenomeu) AND ( (is_scalar($data->prenomeu) AND $data->prenomeu !== '') OR (is_array($data->prenomeu) AND (!empty($data->prenomeu)) )) )
        {

            $filters[] = new TFilter('prenomeu', 'like', "%{$data->prenomeu}%");// create the filter 
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
            // open a transaction with database 'conexao'
            TTransaction::open(self::$database);

            // creates a repository for Prefeitura
            $repository = new TRepository(self::$activeRecord);
            $limit = 20;

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'precodigo';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'asc';
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