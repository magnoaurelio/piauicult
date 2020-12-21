<?php

//<fileHeader>

//</fileHeader>

class SecretariaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'conexao';
    private static $activeRecord = 'Secretaria';
    private static $primaryKey = 'seccodigo';
    private static $formName = 'formList_Secretaria';
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
        $this->form->setFormTitle("secretaria listagem");

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $seccodigo = new TEntry('seccodigo');
        $secnome = new TEntry('secnome');
        $secsecretario = new TEntry('secsecretario');
        $secusual = new TEntry('secusual');
        $precodigo = new TDBCombo('precodigo', 'conexao', 'Prefeitura', 'precodigo', '{precodigo}-{prenome}','prenome asc'  );

        $seccodigo->setSize(100);
        $secnome->setSize('100%');
        $secusual->setSize('100%');
        $secsecretario->setSize('100%');

        $seccodigo->setMaxLength(3);
        $secnome->setMaxLength(200);
        $secusual->setMaxLength(100);
        $secsecretario->setMaxLength(100);

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$seccodigo],[new TLabel("Nome Sec.:", null, '14px', null)],[$secnome]);
        $row2 = $this->form->addFields([new TLabel("Secretario(a):", null, '14px', null)],[$secsecretario],[new TLabel("Usual:", null, '14px', null)],[$secusual]);

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fa:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'fa:file #000000');
        $btn_onexportcsv->addStyleClass('btn-warning'); 

        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['SecretariaForm', 'onShow']), 'fa:plus #ffffff');
        $btn_onshow->addStyleClass('btn-success'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
    //    $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_seccodigo = new TDataGridColumn('seccodigo', "Código", 'center' , '70px');
        $column_precodigo = new TDataGridColumn('precodigo', "Cod", 'left');
        $column_prefeitura_prenome = new TDataGridColumn('<b style="color:#4169E1;">{prefeitura->prenome}</b>', "Prefeitura", 'left');
        $column_secnome = new TDataGridColumn('secnome', "Nome Sec.", 'left');
        $column_secsecretario = new TDataGridColumn('secsecretario', "Secretario(a)", 'left');
        $column_secsexo = new TDataGridColumn('secsexo', "Sexo", 'left');
        $column_secusual = new TDataGridColumn('secusual', "Usual", 'left');
        $column_secimagem = new TDataGridColumn('secimagem', "Imagem", 'left');
        $column_secfoto = new TDataGridColumn('secfoto', "Secretaria", 'left');
        $column_secfotor = new TDataGridColumn('secfotor', "Secretário(a)", 'left');
        $column_sechorario = new TDataGridColumn('sechorario', "Horário", 'left');
        $column_secendereco = new TDataGridColumn('secendereco', "Secendereco", 'left');
        $column_secbairro = new TDataGridColumn('secbairro', "Bairro", 'left');
         /** @ordena_campo <importante ORDENAR O CAMPO> */
        $order_seccodigo = new TAction(array($this, 'onReload'));
        $order_seccodigo->setParameter('order', 'seccodigo');
        $column_seccodigo->setAction($order_seccodigo);

        //<onBeforeColumnsCreation>
         /** @TRANSFORMA_DATA <importante FORMATO BRASIL> 
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
        */
        $column_secfoto->setTransformer( function($value, $object, $row) {
        $img = "files/secretarias/".$object->precodigo."/".$value;
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:120px; height:80px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
      
       
        $column_secfotor->setTransformer( function($value, $object, $row) {
        $img = "files/secretarias/".$object->precodigo."/".$value;
       
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:80px; height:80px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
       
        $column_secimagem->setTransformer( function($value, $object, $row) {
        $img = "files/secretarias/".$object->precodigo."/".$value;
       
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:120px; height:80px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
        //</onBeforeColumnsCreation>
        $this->datagrid->addColumn($column_seccodigo);
      //  $this->datagrid->addColumn($column_precodigo);
        $this->datagrid->addColumn($column_prefeitura_prenome);
        $this->datagrid->addColumn($column_secnome);
        $this->datagrid->addColumn($column_secsecretario);
        $this->datagrid->addColumn($column_secfotor);
        $this->datagrid->addColumn($column_secsexo);
        $this->datagrid->addColumn($column_secusual);
        $this->datagrid->addColumn($column_secimagem);
        $this->datagrid->addColumn($column_secfoto);
        $this->datagrid->addColumn($column_sechorario);
       
     //   $this->datagrid->addColumn($column_secendereco);
    //    $this->datagrid->addColumn($column_secbairro);

        //<onAfterColumnsCreation>

        //</onAfterColumnsCreation>

        $action_onEdit = new TDataGridAction(array('SecretariaForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('fa:edit fa-lg #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('SecretariaList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fa:trash fa-lg #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
  //      $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["PIAUICULT","SECRETARIA Listagem"]));
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
                $object = new Secretaria($key, FALSE); //</blockLine>

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

        if (isset($data->seccodigo) AND ( (is_scalar($data->seccodigo) AND $data->seccodigo !== '') OR (is_array($data->seccodigo) AND (!empty($data->seccodigo)) )) )
        {

            $filters[] = new TFilter('seccodigo', '=', $data->seccodigo);// create the filter 
        }

        if (isset($data->secnome) AND ( (is_scalar($data->secnome) AND $data->secnome !== '') OR (is_array($data->secnome) AND (!empty($data->secnome)) )) )
        {

            $filters[] = new TFilter('secnome', 'like', "%{$data->secnome}%");// create the filter 
        }

        if (isset($data->secsecretario) AND ( (is_scalar($data->secsecretario) AND $data->secsecretario !== '') OR (is_array($data->secsecretario) AND (!empty($data->secsecretario)) )) )
        {

            $filters[] = new TFilter('secsecretario', 'like', "%{$data->secsecretario}%");// create the filter 
        }

        if (isset($data->secusual) AND ( (is_scalar($data->secusual) AND $data->secusual !== '') OR (is_array($data->secusual) AND (!empty($data->secusual)) )) )
        {

            $filters[] = new TFilter('secusual', 'like', "%{$data->secusual}%");// create the filter 
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

            // creates a repository for Secretaria
            $repository = new TRepository(self::$activeRecord);
            $limit = 25;

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'seccodigo';    
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