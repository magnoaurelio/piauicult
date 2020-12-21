<?php
/**
 * EventosList Listing
 * @author  <your name here>
 */
class EventosList extends TPage
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
        $this->form = new TQuickForm('form_search_Eventos');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Eventos Diversos');
        

        // create the form fields
        $evecodigo = new TEntry('evecodigo');
        $evenome = new TEntry('evenome');
        $evetipo = new TDBCombo('evetipo','conexao','EventosTipo','evetipocodigo',['evetiponome']);
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','artusual','artusual');
        $procodigo = new TDBCombo('procodigo','conexao','Projeto','procodigo','pronome','pronome');

         $artcodigo->enableSearch();
         $procodigo->enableSearch();
         
        // add the fields
        $this->form->addQuickField('Código', $evecodigo,  200 );
        $this->form->addQuickField('Descrição', $evenome,  400 );
        $this->form->addQuickField('Tipo', $evetipo,  300 );
        $this->form->addQuickField('Artista', $artcodigo,  300 );
        $this->form->addQuickField('Projeto', $procodigo,  400 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Eventos_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('EventosForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
        

        // creates the datagrid columns
        $column_evecodigo = new TDataGridColumn('evecodigo', 'Código', 'right');
        $column_evetipo = new TDataGridColumn('evetipo', 'Tipo', 'right');
        $column_procodigo = new TDataGridColumn('procodigo', 'Projeto', 'right');
        $column_prologo = new TDataGridColumn('Projeto->prologo', 'Projeto', 'center');
        $column_evenome = new TDataGridColumn('evenome', 'Nome do Evento', 'left');
        $column_evedata = new TDataGridColumn('evedata', 'Data', 'left');
        $column_evehorario = new TDataGridColumn('evehorario', 'Horário', 'left');
        $column_evedetalhe = new TDataGridColumn('evedetalhe', 'Detalhes', 'left');
        $column_artcodigo = new TDataGridColumn('Artista->artusual', 'Artista', 'left');
        $column_artfoto = new TDataGridColumn('Artista->artfoto', 'Artista', 'left');
        $column_discodigo = new TDataGridColumn('discodigo', 'Disco', 'right');
        $column_disimagem = new TDataGridColumn('Disco->disimagem', 'Disco', 'left');
        $column_eveimagem1 = new TDataGridColumn('eveimagem1', 'Imagem 1', 'left');
        $column_eveimagem2 = new TDataGridColumn('eveimagem2', 'Imagem 2', 'left');
        $column_eveimagem3 = new TDataGridColumn('eveimagem3', 'Imagem 3', 'left');
        $column_eveimagem4 = new TDataGridColumn('eveimagem4', 'Imagem 4', 'left');
        $column_eveimagem5 = new TDataGridColumn('eveimagem5', 'Imagem 5', 'left');
        $column_eveimagem6 = new TDataGridColumn('eveimagem6', 'Imagem 6', 'left');
        $column_evelocal = new TDataGridColumn('evelocal', 'Local', 'right');
        $column_evehome = new TDataGridColumn('evehome', 'Home', 'right');
       
       // var_dump(artfoto);
        
        $column_prologo->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/projetos/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
         $column_artfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
         $column_disimagem->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/discos/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        $column_eveimagem1->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/eventos/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
         $column_eveimagem2->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/eventos/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
         $column_eveimagem3->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/eventos/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
          $column_eveimagem4->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/eventos/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
         $column_eveimagem5->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/eventos/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
         $column_eveimagem6->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/eventos/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
       
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_evecodigo);
        $this->datagrid->addColumn($column_evetipo);
        $this->datagrid->addColumn($column_prologo);
        $this->datagrid->addColumn($column_evenome); 
        $this->datagrid->addColumn($column_eveimagem1);
        $this->datagrid->addColumn($column_artfoto);
        $this->datagrid->addColumn($column_disimagem);
      //  $this->datagrid->addColumn($column_discodigo);
      //  $this->datagrid->addColumn($column_procodigo);
        $this->datagrid->addColumn($column_evedata);
        $this->datagrid->addColumn($column_evelocal);
        $this->datagrid->addColumn($column_evehome);
        $this->datagrid->addColumn($column_evedetalhe);
        $this->datagrid->addColumn($column_evehorario);
        $this->datagrid->addColumn($column_eveimagem2);
        $this->datagrid->addColumn($column_eveimagem3);
        $this->datagrid->addColumn($column_eveimagem4);
        $this->datagrid->addColumn($column_eveimagem5);
        $this->datagrid->addColumn($column_eveimagem6);
        
        
        // creates the datagrid column actions
        $order_evenome = new TAction(array($this, 'onReload'));
        $order_evenome->setParameter('order', 'evenome');
        $column_evenome->setAction($order_evenome);
        
        $order_evedata = new TAction(array($this, 'onReload'));
        $order_evedata->setParameter('order', 'evedata');
        $column_evedata->setAction($order_evedata);
        

        // define the transformer method over image
        $column_evedata->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });

        // create EDIT action
        $action_edit = new TDataGridAction(array('EventosForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('evecodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('evecodigo');
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
        $container->add(TPanelGroup::pack('Evento Listagem', $this->form));
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
            $object = new Eventos($key); // instantiates the Active Record
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
        TSession::setValue('EventosList_filter_evecodigo',   NULL);
        TSession::setValue('EventosList_filter_evetipo',   NULL);
        TSession::setValue('EventosList_filter_evenome',   NULL);
        TSession::setValue('EventosList_filter_artcodigo',   NULL);
        TSession::setValue('EventosList_filter_procodigo',   NULL);

        if (isset($data->evecodigo) AND ($data->evecodigo)) {
            $filter = new TFilter('evecodigo', 'like', "%{$data->evecodigo}%"); // create the filter
            TSession::setValue('EventosList_filter_evecodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->evetipo) AND ($data->evetipo)) {
            $filter = new TFilter('evetipo', 'like', "%{$data->evetipo}%"); // create the filter
            TSession::setValue('EventosList_filter_evetipo',   $filter); // stores the filter in the session
        }


        if (isset($data->evenome) AND ($data->evenome)) {
            $filter = new TFilter('evenome', 'like', "%{$data->evenome}%"); // create the filter
            TSession::setValue('EventosList_filter_evenome',   $filter); // stores the filter in the session
        }


        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', '=', "{$data->artcodigo}"); // create the filter
            TSession::setValue('EventosList_filter_artcodigo',   $filter); // stores the filter in the session
        }
        
         if (isset($data->procodigo) AND ($data->procodigo)) {
            $filter = new TFilter('procodigo', 'like', "%{$data->procodigo}%"); // create the filter
            TSession::setValue('EventosList_filter_procodigo',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Eventos_filter_data', $data);
        
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
            
            // creates a repository for Eventos
            $repository = new TRepository('Eventos');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'evecodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('EventosList_filter_evecodigo')) {
                $criteria->add(TSession::getValue('EventosList_filter_evecodigo')); // add the session filter
            }


            if (TSession::getValue('EventosList_filter_evetipo')) {
                $criteria->add(TSession::getValue('EventosList_filter_evetipo')); // add the session filter
            }


            if (TSession::getValue('EventosList_filter_evenome')) {
                $criteria->add(TSession::getValue('EventosList_filter_evenome')); // add the session filter
            }


            if (TSession::getValue('EventosList_filter_artcodigo')) {
                $criteria->add(TSession::getValue('EventosList_filter_artcodigo')); // add the session filter
            }
            
              if (TSession::getValue('EventosList_filter_procodigo')) {
                $criteria->add(TSession::getValue('EventosList_filter_procodigo')); // add the session filter
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
            $object = new Eventos($key, FALSE); // instantiates the Active Record
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
