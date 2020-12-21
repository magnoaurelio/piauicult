<?php
/**
 * ProjetoList Listing
 * @author  <your name here>
 */
class ProjetoList extends TPage
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
        $this->form = new TQuickForm('form_search_Projeto');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Projetos Artísticos');
        

        // create the form fields
       // $procodigo = new TEntry('procodigo');
       // $pronome = new TEntry('pronome');
        $pronome = new TDBCombo('procodigo','conexao','Projeto','procodigo','{pronome} - {procodigo}','pronome');
        $proendereco = new TEntry('proendereco');
        $probairro = new TEntry('probairro');
        $procep = new TEntry('procep');
        $procomplemento = new TEntry('procomplemento');
        $proimagem = new TEntry('proimagem');
        $prologo = new TEntry('prologo');
        $profone = new TEntry('profone');
        $procelular = new TEntry('procelular');
        $proresponsavel = new TEntry('proresponsavel');
        $profoto = new TEntry('profoto');
        $procordenadas = new TEntry('procordenadas');
        $prosobre = new TEntry('prosobre');
        $procidade = new TEntry('procidade');
        $protipo = new TEntry('protipo');
        $proorgao = new TEntry('proorgao');
        
        $pronome->enableSearch();

        // add the fields
       // $this->form->addQuickField('Código', $procodigo,  200 );
        $this->form->addQuickField('Nome do Projeto', $pronome,  400 );
        

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Projeto_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('ProjetoForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_procodigo = new TDataGridColumn('procodigo', 'Código', 'right');
        $column_pronome = new TDataGridColumn('pronome', 'Nome', 'left');
        $column_procidade = new TDataGridColumn('procidade', 'Cidade', 'left');
        $column_proesfera = new TDataGridColumn('proesfera', 'Esfera', 'left');
        $column_proorgao = new TDataGridColumn('proorgao', 'Secretaria', 'left');
        $column_proendereco = new TDataGridColumn('proendereco', 'Endereço', 'left');
        $column_probairro = new TDataGridColumn('probairro', 'Bairro', 'left');
        $column_procep = new TDataGridColumn('procep', 'CEP', 'left');
        $column_procomplemento = new TDataGridColumn('procomplemento', 'Complemento', 'left');
        $column_proimagem = new TDataGridColumn('proimagem', 'Imagem', 'left');
        $column_prologo = new TDataGridColumn('prologo', 'Logomarca', 'center');
        $column_profone = new TDataGridColumn('profone', 'Fone', 'left');
        $column_procelular = new TDataGridColumn('procelular', 'Celular', 'left');
        $column_proresponsavel = new TDataGridColumn('proresponsavel', 'Responsável', 'left');
        $column_profoto = new TDataGridColumn('profoto', 'Foto', 'left');
        $column_procordenadas = new TDataGridColumn('procordenadas', 'Cordenadas', 'left');
        $column_prosobre = new TDataGridColumn('prosobre', 'Sobre', 'left');

        $column_prologo->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/projetos/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        $column_proimagem->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/projetos/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
        $column_profoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/projetos/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_procodigo);
        $this->datagrid->addColumn($column_procidade);
        $this->datagrid->addColumn($column_proesfera);
        $this->datagrid->addColumn($column_proorgao);
        $this->datagrid->addColumn($column_pronome);
        $this->datagrid->addColumn($column_proimagem);
        $this->datagrid->addColumn($column_prologo);
        $this->datagrid->addColumn($column_profoto);
        $this->datagrid->addColumn($column_proresponsavel);  
        $this->datagrid->addColumn($column_profone);
        $this->datagrid->addColumn($column_procelular);
        $this->datagrid->addColumn($column_proendereco);
        $this->datagrid->addColumn($column_probairro);
        $this->datagrid->addColumn($column_procep);
        $this->datagrid->addColumn($column_procomplemento);
        $this->datagrid->addColumn($column_procordenadas);
        $this->datagrid->addColumn($column_prosobre);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('ProjetoForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('procodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('procodigo');
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
        $container->add(TPanelGroup::pack('Projeto Listagem', $this->form));
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
            $object = new Projeto($key); // instantiates the Active Record
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
        TSession::setValue('ProjetoList_filter_procodigo',   NULL);
        TSession::setValue('ProjetoList_filter_pronome',   NULL);
        TSession::setValue('ProjetoList_filter_proesfera',   NULL);
        TSession::setValue('ProjetoList_filter_proorgao',   NULL);
        TSession::setValue('ProjetoList_filter_proendereco',   NULL);
        TSession::setValue('ProjetoList_filter_probairro',   NULL);
        TSession::setValue('ProjetoList_filter_procep',   NULL);
        TSession::setValue('ProjetoList_filter_procomplemento',   NULL);
        TSession::setValue('ProjetoList_filter_proimagem',   NULL);
        TSession::setValue('ProjetoList_filter_prologo',   NULL);
        TSession::setValue('ProjetoList_filter_profone',   NULL);
        TSession::setValue('ProjetoList_filter_procelular',   NULL);
        TSession::setValue('ProjetoList_filter_proresponsavel',   NULL);
        TSession::setValue('ProjetoList_filter_profoto',   NULL);
        TSession::setValue('ProjetoList_filter_procordenadas',   NULL);
        TSession::setValue('ProjetoList_filter_prosobre',   NULL);

        if (isset($data->procodigo) AND ($data->procodigo)) {
            $filter = new TFilter('procodigo', 'like', "%{$data->procodigo}%"); // create the filter
            TSession::setValue('ProjetoList_filter_procodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->pronome) AND ($data->pronome)) {
            $filter = new TFilter('pronome', 'like', "%{$data->pronome}%"); // create the filter
            TSession::setValue('ProjetoList_filter_pronome',   $filter); // stores the filter in the session
        }
        
        if (isset($data->procidade) AND ($data->procidade)) {
            $filter = new TFilter('procidade', 'like', "%{$data->procidade}%"); // create the filter
            TSession::setValue('ProjetoList_filter_procidade',   $filter); // stores the filter in the session
        }
        
        if (isset($data->proesfera) AND ($data->proesfera)) {
            $filter = new TFilter('proesfera', 'like', "%{$data->proesfera}%"); // create the filter
            TSession::setValue('ProjetoList_filter_proesfera',   $filter); // stores the filter in the session
        }
        
        if (isset($data->proorgao) AND ($data->proorgao)) {
            $filter = new TFilter('proorgao', 'like', "%{$data->proorgao}%"); // create the filter
            TSession::setValue('ProjetoList_filter_proorgao',   $filter); // stores the filter in the session
        }


        if (isset($data->proendereco) AND ($data->proendereco)) {
            $filter = new TFilter('proendereco', 'like', "%{$data->proendereco}%"); // create the filter
            TSession::setValue('ProjetoList_filter_proendereco',   $filter); // stores the filter in the session
        }


        if (isset($data->probairro) AND ($data->probairro)) {
            $filter = new TFilter('probairro', 'like', "%{$data->probairro}%"); // create the filter
            TSession::setValue('ProjetoList_filter_probairro',   $filter); // stores the filter in the session
        }


        if (isset($data->procep) AND ($data->procep)) {
            $filter = new TFilter('procep', 'like', "%{$data->procep}%"); // create the filter
            TSession::setValue('ProjetoList_filter_procep',   $filter); // stores the filter in the session
        }


        if (isset($data->procomplemento) AND ($data->procomplemento)) {
            $filter = new TFilter('procomplemento', 'like', "%{$data->procomplemento}%"); // create the filter
            TSession::setValue('ProjetoList_filter_procomplemento',   $filter); // stores the filter in the session
        }


        if (isset($data->proimagem) AND ($data->proimagem)) {
            $filter = new TFilter('proimagem', 'like', "%{$data->proimagem}%"); // create the filter
            TSession::setValue('ProjetoList_filter_proimagem',   $filter); // stores the filter in the session
        }


        if (isset($data->prologo) AND ($data->prologo)) {
            $filter = new TFilter('prologo', 'like', "%{$data->prologo}%"); // create the filter
            TSession::setValue('ProjetoList_filter_prologo',   $filter); // stores the filter in the session
        }


        if (isset($data->profone) AND ($data->profone)) {
            $filter = new TFilter('profone', 'like', "%{$data->profone}%"); // create the filter
            TSession::setValue('ProjetoList_filter_profone',   $filter); // stores the filter in the session
        }


        if (isset($data->procelular) AND ($data->procelular)) {
            $filter = new TFilter('procelular', 'like', "%{$data->procelular}%"); // create the filter
            TSession::setValue('ProjetoList_filter_procelular',   $filter); // stores the filter in the session
        }


        if (isset($data->proresponsavel) AND ($data->proresponsavel)) {
            $filter = new TFilter('proresponsavel', 'like', "%{$data->proresponsavel}%"); // create the filter
            TSession::setValue('ProjetoList_filter_proresponsavel',   $filter); // stores the filter in the session
        }


        if (isset($data->profoto) AND ($data->profoto)) {
            $filter = new TFilter('profoto', 'like', "%{$data->profoto}%"); // create the filter
            TSession::setValue('ProjetoList_filter_profoto',   $filter); // stores the filter in the session
        }


        if (isset($data->procordenadas) AND ($data->procordenadas)) {
            $filter = new TFilter('procordenadas', 'like', "%{$data->procordenadas}%"); // create the filter
            TSession::setValue('ProjetoList_filter_procordenadas',   $filter); // stores the filter in the session
        }


        if (isset($data->prosobre) AND ($data->prosobre)) {
            $filter = new TFilter('prosobre', 'like', "%{$data->prosobre}%"); // create the filter
            TSession::setValue('ProjetoList_filter_prosobre',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Projeto_filter_data', $data);
        
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
            
            // creates a repository for Projeto
            $repository = new TRepository('Projeto');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'procodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('ProjetoList_filter_procodigo')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_procodigo')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_pronome')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_pronome')); // add the session filter
            }
            
            if (TSession::getValue('ProjetoList_filter_procidade')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_procidade')); // add the session filter
            }
            if (TSession::getValue('ProjetoList_filter_proesfera')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_proesfera')); // add the session filter
            }
            if (TSession::getValue('ProjetoList_filter_proorgao')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_proorgao')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_proendereco')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_proendereco')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_probairro')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_probairro')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_procep')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_procep')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_procomplemento')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_procomplemento')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_proimagem')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_proimagem')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_prologo')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_prologo')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_profone')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_profone')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_procelular')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_procelular')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_proresponsavel')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_proresponsavel')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_profoto')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_profoto')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_procordenadas')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_procordenadas')); // add the session filter
            }


            if (TSession::getValue('ProjetoList_filter_prosobre')) {
                $criteria->add(TSession::getValue('ProjetoList_filter_prosobre')); // add the session filter
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
            $object = new Projeto($key, FALSE); // instantiates the Active Record
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
