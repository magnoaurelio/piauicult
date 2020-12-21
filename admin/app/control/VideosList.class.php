<?php
/**
 * VideosList Listing
 * @author  <your name here>
 */
class VideosList extends TPage
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
        $this->form = new TQuickForm('form_search_Videos');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Videos Listagem');
        

        // create the form fields
        $vidcodigo = new TEntry('vidcodigo');
        $viddescricao = new TEntry('viddescricao');
        $viddata = new TDate('viddata');
        $vidpublica = new TDate('vidpublica');
        $vidfoto = new Adianti\Widget\Form\TFile('vidfoto');
        $vidtipo = new TCombo('vidtipo');
      //  $artnome = new TEntry('artnome');
     
        $artnome = new TDBCombo('artnome','conexao','Artista','artcodigo','{artusual} - {artcodigo}','artusual');
        $artnome->placeholder =  "Digite o nome do artista";
        
        $vidtipo->addItems(DadosFixos::TipoVideo());
        
        $artnome->enableSearch();


        // add the fields
        $this->form->addQuickField('Código', $vidcodigo,  200 );
        $this->form->addQuickField('Descrição', $viddescricao,  200 );
        $this->form->addQuickField('Data', $viddata,  200 );
        $this->form->addQuickField('Tipo', $vidtipo,  200 );
        $this->form->addQuickField('Artista', $artnome,  300 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Videos_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('VideosForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_vidcodigo = new TDataGridColumn('vidcodigo', 'Código', 'right');
        $column_viddescricao = new TDataGridColumn('viddescricao', 'Descrição', 'left');
        $column_artcodigo = new TDataGridColumn('artista->artusual', 'Artista', 'left');
        $column_artfoto = new TDataGridColumn('artista->artfoto', 'Artista', 'center');
        $column_vidfoto = new TDataGridColumn('vidfoto', 'Imagem', 'center');
        $column_vidurl = new TDataGridColumn('vidurl', 'URL', 'left');
        $column_vidliberado = new TDataGridColumn('vidliberado', 'Liberado', 'right');
        $column_viddata = new TDataGridColumn('viddata', 'Data', 'left');
        $column_vidtipo = new TDataGridColumn('vidtipo', 'Tipo', 'right');
        $column_vidpublica = new TDataGridColumn('vidpublica', 'Publicação', 'left');
       
        $column_artfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->title = $object->get_artista()->artusual;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        $column_vidfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/video/".$value;
         // $img->title = $object->get_artista()->artusual;
          $img->style = "width:90px; height:60px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_vidcodigo);
        $this->datagrid->addColumn($column_viddescricao);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artfoto);
        $this->datagrid->addColumn($column_vidfoto);
        $this->datagrid->addColumn($column_vidurl);
        $this->datagrid->addColumn($column_vidliberado);
        $this->datagrid->addColumn($column_viddata);
        $this->datagrid->addColumn($column_vidtipo);
        $this->datagrid->addColumn($column_vidpublica);

        // creates the datagrid column actions
        $order_viddata = new TAction(array($this, 'onReload'));
        $order_viddata->setParameter('order', 'viddata');
        $column_viddata->setAction($order_viddata);
        

        // define the transformer method over image
        $column_viddata->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });
        
         // define the transformer method over image
        $column_vidtipo->setTransformer( function($value, $object, $row) {
            $tipo = DadosFixos::TipoVideo($value);
            return $tipo;
        });
        
         // define the transformer method over image
        $column_vidliberado->setTransformer( function($value, $object, $row) {
           $liberado = $value == 1? "SIM":"NÃO";
            return $liberado;
        });

       
        
        // create EDIT action
        $action_edit = new TDataGridAction(array('VideosForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('vidcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('vidcodigo');
        $this->datagrid->addAction($action_del);
        
        $action_del = new TDataGridAction(array('VideoView','onLoad'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setImage('fa:cloud-download green fa-lg');
        $action_del->setField('vidcodigo');
        $this->datagrid->addAction($action_del);


         // instrumentos
         $action_edit = new TDataGridAction(array('VideoArtistaList', 'onLoad'));
         $action_edit->setUseButton(TRUE);
         $action_edit->setButtonClass('btn btn-default');
         $action_edit->setLabel('Artistas');
         $action_edit->setImage('fa:group blue fa-lg');
         $action_edit->setField('vidcodigo');
         $this->datagrid->addAction($action_edit);

        $action_edit = new TDataGridAction(array('VideoBandaList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Grupos');
        $action_edit->setImage('fa:group blue fa-lg');
        $action_edit->setField('vidcodigo');
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
        $container->add(TPanelGroup::pack('Vídeo Listagem', $this->form));
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
            $object = new Videos($key); // instantiates the Active Record
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
        TSession::setValue('VideosList_filter_vidcodigo',   NULL);
        TSession::setValue('VideosList_filter_viddescricao',   NULL);
        TSession::setValue('VideosList_filter_viddata',   NULL);
        TSession::setValue('VideosList_filter_vidtipo',   NULL);
        TSession::setValue('VideosList_filter_artnome',   NULL);

        if (isset($data->vidcodigo) AND ($data->vidcodigo)) {
            $filter = new TFilter('vidcodigo', 'like', "%{$data->vidcodigo}%"); // create the filter
            TSession::setValue('VideosList_filter_vidcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->viddescricao) AND ($data->viddescricao)) {
            $filter = new TFilter('viddescricao', 'like', "%{$data->viddescricao}%"); // create the filter
            TSession::setValue('VideosList_filter_viddescricao',   $filter); // stores the filter in the session
        }


        if (isset($data->viddata) AND ($data->viddata)) {
            $filter = new TFilter('viddata', 'like', "%{$data->viddata}%"); // create the filter
            TSession::setValue('VideosList_filter_viddata',   $filter); // stores the filter in the session
        }


        if (isset($data->vidtipo) AND ($data->vidtipo)) {
            $filter = new TFilter('vidtipo', 'like', "%{$data->vidtipo}%"); // create the filter
            TSession::setValue('VideosList_filter_vidtipo',   $filter); // stores the filter in the session
        }

        if (isset($data->artnome) AND ($data->artnome)) {
            $filter = new TFilter("artcodigo", "IN", "(SELECT videos.artcodigo from artista join videos on videos.artcodigo = artista.artcodigo where artnome like '%{$data->artnome}%')"); // create the filter
            TSession::setValue('VideosList_filter_artnome',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Videos_filter_data', $data);
        
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
            
            // creates a repository for Videos
            $repository = new TRepository('Videos');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'vidcodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('VideosList_filter_vidcodigo')) {
                $criteria->add(TSession::getValue('VideosList_filter_vidcodigo')); // add the session filter
            }


            if (TSession::getValue('VideosList_filter_viddescricao')) {
                $criteria->add(TSession::getValue('VideosList_filter_viddescricao')); // add the session filter
            }


            if (TSession::getValue('VideosList_filter_viddata')) {
                $criteria->add(TSession::getValue('VideosList_filter_viddata')); // add the session filter
            }


            if (TSession::getValue('VideosList_filter_vidtipo')) {
                $criteria->add(TSession::getValue('VideosList_filter_vidtipo')); // add the session filter
            }

            if (TSession::getValue('VideosList_filter_artnome')) {
                $criteria->add(TSession::getValue('VideosList_filter_artnome')); // add the session filter
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
            $object = new Videos($key, FALSE); // instantiates the Active Record
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
