<?php
/**
 * DiscoList Listing
 * @author  <your name here>
 */
class DiscoList extends TPage
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
        $this->form = new TQuickForm('form_search_Disco');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Discos / Show(Apresentação)');
        

        // create the form fields
       // $discodigo = new TEntry('discodigo');
       // $disnome = new TEntry('disnome');
        $disnome = new TDBCombo('discodigo','conexao','Disco','discodigo','disnome','disnome');
       // $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','artusual','artusual');
        $artnome = new TDBCombo('artnome','conexao','Artista','artcodigo','artusual','artusual');

        $artnome->enableSearch();
        $disnome->enableSearch();

        // add the fields
     //   $this->form->addQuickField('Código', $discodigo,  200 );
        $this->form->addQuickField('Nome do Disco', $disnome,  300 );
        $this->form->addQuickField('Nome do Artista', $artnome,  300 );


        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Disco_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('DiscoForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        $column_artcodigo->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->title = $object->get_Interprete()->artusual;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        // creates the datagrid columns
        $column_discodigo = new TDataGridColumn('discodigo', 'Código', 'right');
        $column_disnome = new TDataGridColumn('disnome', 'Nome', 'left');
        $column_artcodigo = new TDataGridColumn('artcodigo', 'Artista', 'right');
        $column_disimagem = new TDataGridColumn('disimagem', 'Disco', 'right');
        $column_dismostra = new TDataGridColumn('dismostra', 'CD/SHOW', 'center');
        $column_disbolacha = new TDataGridColumn('disbolacha', 'Bolacha', 'left');
        $column_disfrente = new TDataGridColumn('disfrente', 'Frente', 'left');
        $column_disfundo = new TDataGridColumn('disfundo', 'Fundo', 'left');
        $column_disdata = new TDataGridColumn('disdata', 'Data', 'left');
        $column_disgravadora = new TDataGridColumn('disgravadora', 'Gravadora', 'left');
        $column_diseditoracao = new TDataGridColumn('diseditoracao', 'Editora', 'left');
        $column_dismix = new TDataGridColumn('dismix', 'Mixagem', 'left');
        $column_dismasterizacao = new TDataGridColumn('dismasterizacao', 'Masterização', 'left');
        

  // criar na grade um ordenação
        $order_disnome = new TAction(array($this, 'onReload'));
        $order_disnome->setParameter('order', 'disnome');
        $column_disnome->setAction($order_disnome);

        $order_discodigo = new TAction(array($this, 'onReload'));
        $order_discodigo->setParameter('order', 'discodigo');
        $column_discodigo->setAction($order_discodigo);

         // criar na grade um ordenação
        $order_dismostra = new TAction(array($this, 'onReload'));
        $order_dismostra->setParameter('order', 'dismostra');
        $column_dismostra->setAction($order_dismostra);
        
         $column_disdata->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });
        
         $column_disimagem->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/discos/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });
        
         $column_artcodigo->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->title = $object->get_Interprete()->artusual;
          $img->style = "width:60px; height:60px;";
            return $img;
        });

        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_discodigo);
        $this->datagrid->addColumn($column_disnome);
        $this->datagrid->addColumn($column_disimagem);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_dismostra);
       // $this->datagrid->addColumn($column_disbolacha);
       // $this->datagrid->addColumn($column_disfrente);
       // $this->datagrid->addColumn($column_disfundo);
        $this->datagrid->addColumn($column_disdata);
        $this->datagrid->addColumn($column_disgravadora);
        $this->datagrid->addColumn($column_diseditoracao);
        $this->datagrid->addColumn($column_dismix);
        $this->datagrid->addColumn($column_dismasterizacao);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('DiscoForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('discodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('discodigo');
        $this->datagrid->addAction($action_del);
        
        // create EDIT action
        $action_edit = new TDataGridAction(array('DiscoArtistaList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Artistas');
        $action_edit->setImage('fa:star blue fa-lg');
        $action_edit->setField('discodigo');
        $this->datagrid->addAction($action_edit);
        
          //$action_group->addSeparator();
        $action_group = new TDataGridActionGroup('Ações', 'bs:th');
        $action_group->addHeader('Complementares');
       
       // PRODUTORES
        $action_edit = new TDataGridAction(array('DiscoProdutor', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Produtor');
        $action_edit->setImage('fa:registered green fa-lg');
        $action_edit->setField('discodigo');
        $action_group->addAction($action_edit);     
        
         // ARTE
        $action_edit = new TDataGridAction(array('DiscoArte', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Arte');
        $action_edit->setImage('fa:pencil cyan fa-lg');
        $action_edit->setField('discodigo');
        $action_group->addAction($action_edit);    
        
             // instrumentos
        $action_edit = new TDataGridAction(array('DiscoVideo', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Vídeos');
        $action_edit->setImage('fa:music blue fa-lg');
        $action_edit->setField('discodigo');
        $action_group->addAction($action_edit);    
        
        $this->datagrid->addActionGroup($action_group);
        
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
        $container->add(TPanelGroup::pack('Disco Listagem', $this->form));
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
            $object = new Disco($key); // instantiates the Active Record
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
        TSession::setValue('DiscoList_filter_discodigo',   NULL);
        TSession::setValue('DiscoList_filter_disnome',   NULL);
        TSession::setValue('DiscoList_filter_artcodigo',   NULL);
        TSession::setValue('DiscoList_filter_disimagem',   NULL);
        TSession::setValue('DiscoList_filter_disbolacha',   NULL);
        TSession::setValue('DiscoList_filter_disfrente',   NULL);
        TSession::setValue('DiscoList_filter_disfundo',   NULL);
        TSession::setValue('DiscoList_filter_disdata',   NULL);
        TSession::setValue('DiscoList_filter_disgravadora',   NULL);
        TSession::setValue('DiscoList_filter_diseditoracao',   NULL);
        TSession::setValue('DiscoList_filter_dismix',   NULL);
        TSession::setValue('DiscoList_filter_dismasterizacao',   NULL);

        if (isset($data->discodigo) AND ($data->discodigo)) {
            $filter = new TFilter('discodigo', 'like', "%{$data->discodigo}%"); // create the filter
            TSession::setValue('DiscoList_filter_discodigo',   $filter); // stores the filter in the session
        }

        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', 'like', "%{$data->artcodigo}%"); // create the filter
            TSession::setValue('DiscoList_filter_artcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->disimagem) AND ($data->disimagem)) {
            $filter = new TFilter('disimagem', 'like', "%{$data->disimagem}%"); // create the filter
            TSession::setValue('DiscoList_filter_disimagem',   $filter); // stores the filter in the session
        }


        if (isset($data->disbolacha) AND ($data->disbolacha)) {
            $filter = new TFilter('disbolacha', 'like', "%{$data->disbolacha}%"); // create the filter
            TSession::setValue('DiscoList_filter_disbolacha',   $filter); // stores the filter in the session
        }


        if (isset($data->disfrente) AND ($data->disfrente)) {
            $filter = new TFilter('disfrente', 'like', "%{$data->disfrente}%"); // create the filter
            TSession::setValue('DiscoList_filter_disfrente',   $filter); // stores the filter in the session
        }


        if (isset($data->disfundo) AND ($data->disfundo)) {
            $filter = new TFilter('disfundo', 'like', "%{$data->disfundo}%"); // create the filter
            TSession::setValue('DiscoList_filter_disfundo',   $filter); // stores the filter in the session
        }


        if (isset($data->disdata) AND ($data->disdata)) {
            $filter = new TFilter('disdata', 'like', "%{$data->disdata}%"); // create the filter
            TSession::setValue('DiscoList_filter_disdata',   $filter); // stores the filter in the session
        }


        if (isset($data->disgravadora) AND ($data->disgravadora)) {
            $filter = new TFilter('disgravadora', 'like', "%{$data->disgravadora}%"); // create the filter
            TSession::setValue('DiscoList_filter_disgravadora',   $filter); // stores the filter in the session
        }


        if (isset($data->diseditoracao) AND ($data->diseditoracao)) {
            $filter = new TFilter('diseditoracao', 'like', "%{$data->diseditoracao}%"); // create the filter
            TSession::setValue('DiscoList_filter_diseditoracao',   $filter); // stores the filter in the session
        }


        if (isset($data->dismix) AND ($data->dismix)) {
            $filter = new TFilter('dismix', 'like', "%{$data->dismix}%"); // create the filter
            TSession::setValue('DiscoList_filter_dismix',   $filter); // stores the filter in the session
        }


        if (isset($data->dismasterizacao) AND ($data->dismasterizacao)) {
            $filter = new TFilter('dismasterizacao', 'like', "%{$data->dismasterizacao}%"); // create the filter
            TSession::setValue('DiscoList_filter_dismasterizacao',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Disco_filter_data', $data);
        
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
            
            // creates a repository for Disco
            $repository = new TRepository('Disco');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $artuser = (int)TSession::getValue('artuser');
            $tm = strlen($artuser)+1;
            if ($artuser > 0){
                $artuser.=';';
                $criteria->add(new TFilter("SUBSTRING(artcodigo,1,$tm)",'=',$artuser));
             }
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'discodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('DiscoList_filter_discodigo')) {
                $criteria->add(TSession::getValue('DiscoList_filter_discodigo')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_disnome')) {
                $criteria->add(TSession::getValue('DiscoList_filter_disnome')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_artcodigo')) {
                $criteria->add(TSession::getValue('DiscoList_filter_artcodigo')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_disimagem')) {
                $criteria->add(TSession::getValue('DiscoList_filter_disimagem')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_disbolacha')) {
                $criteria->add(TSession::getValue('DiscoList_filter_disbolacha')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_disfrente')) {
                $criteria->add(TSession::getValue('DiscoList_filter_disfrente')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_disfundo')) {
                $criteria->add(TSession::getValue('DiscoList_filter_disfundo')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_disdata')) {
                $criteria->add(TSession::getValue('DiscoList_filter_disdata')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_disgravadora')) {
                $criteria->add(TSession::getValue('DiscoList_filter_disgravadora')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_diseditoracao')) {
                $criteria->add(TSession::getValue('DiscoList_filter_diseditoracao')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_dismix')) {
                $criteria->add(TSession::getValue('DiscoList_filter_dismix')); // add the session filter
            }


            if (TSession::getValue('DiscoList_filter_dismasterizacao')) {
                $criteria->add(TSession::getValue('DiscoList_filter_dismasterizacao')); // add the session filter
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
            $object = new Disco($key, FALSE); // instantiates the Active Record
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
