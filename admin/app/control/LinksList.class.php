<?php
/**
 * LinksList Listing
 * @author  <your name here>
 */
class LinksList extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    protected $transformCallback;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('conexao');            // defines the database
        parent::setActiveRecord('Links');   // defines the active record
        parent::setDefaultOrder('lincodigo', 'asc');         // defines the default order
        // parent::setCriteria($criteria) // define a standard filter

        parent::addFilterField('lincodigo', 'like', 'lincodigo'); // filterField, operator, formField
        parent::addFilterField('artcodigo', 'like', 'artcodigo'); // filterField, operator, formField
        parent::addFilterField('linnome', 'like', 'linnome'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_Links');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);

        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Links');
        

        // create the form fields
        $lincodigo = new TDBCombo('lincodigo','conexao','Links','lincodigo','linnome','linnome');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','artusual','artusual');
        $limits = new Adianti\Widget\Form\TCombo("limit");
        $limits->addItems(DadosFixos::getLimits(5,10));
     //   $linnome = new TEntry('linnome');
      //  $linnome = new TDBCombo('linnome','conexao','Links','lincodigo','linnome','linnome');

        $lincodigo->enableSearch();
        $artcodigo->enableSearch();
        $param = array();
        $limits->setChangeAction( new Adianti\Control\TAction(array($this, 'setLimite')));

        // add the fields
        $this->form->addQuickField('Link', $lincodigo,  400 );
        $this->form->addQuickField('Artista', $artcodigo,  400 );
        $this->form->addQuickField('Limite', $limits,  200 );
    //    $this->form->addQuickField('Linnome', $linnome,  200 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Links_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('LinksForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_linimagem = new TDataGridColumn('linimagem', 'Logo', 'center');
        $column_lincodigo = new TDataGridColumn('lincodigo', 'Cd_Lin', 'right');
        $column_artcodigo = new TDataGridColumn('artcodigo', 'Cd_Art', 'right');
        $column_linnome = new TDataGridColumn('linnome', 'Nome do Site', 'left');
        $column_linusual = new TDataGridColumn('linusual', 'Nome_Responsável', 'left');
        $column_linurl = new TDataGridColumn('linurl', 'URL', 'left');
        $column_lincontato = new TDataGridColumn('lincontato', 'Fone-Celular', 'left');
        $column_linemail = new TDataGridColumn('linemail', 'E-mail', 'left');
        $column_linativo = new TDataGridColumn('linativo', 'Ativo', 'left');


        $column_linimagem->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/links/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
        
        $column_linativo->setTransformer( function($value, $object, $row) {
            return Layout::getAtivo($value);
        });
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_lincodigo);
        $this->datagrid->addColumn($column_linativo);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_linnome);
        $this->datagrid->addColumn($column_linusual);
        $this->datagrid->addColumn($column_linimagem);
       // $this->datagrid->addColumn($column_linurl);
       // $this->datagrid->addColumn($column_lincontato);
       // $this->datagrid->addColumn($column_linemail);


        // creates the datagrid column actions
        $order_lincodigo = new TAction(array($this, 'onReload'));
        $order_lincodigo->setParameter('order', 'lincodigo');
        $column_lincodigo->setAction($order_lincodigo);
        
        $order_artcodigo = new TAction(array($this, 'onReload'));
        $order_artcodigo->setParameter('order', 'artcodigo');
        $column_artcodigo->setAction($order_artcodigo);
        
        $order_linnome = new TAction(array($this, 'onReload'));
        $order_linnome->setParameter('order', 'linnome');
        $column_linnome->setAction($order_linnome);
        

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('LinksForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('lincodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('lincodigo');
        $this->datagrid->addAction($action_del);
        
        $action_onoff = new TDataGridAction(array($this, 'setAtivo'));
        $action_onoff->setButtonClass('btn btn-default');
        $action_onoff->setLabel(_t('Activate/Deactivate'));
        $action_onoff->setImage('fa:power-off fa-lg orange');
        $action_onoff->setField('lincodigo');
        $this->datagrid->addAction($action_onoff);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Links Listagem', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    
    static function setLimite($param){
        Adianti\Registry\TSession::setValue("limit", $param["limit"]);
    }




    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue('LinksList_filter_lincodigo',   NULL);
        TSession::setValue('LinksList_filter_artcodigo',   NULL);

        if (isset($data->lincodigo) AND ($data->lincodigo)) {
            $filter = new TFilter('lincodigo', '=', $data->lincodigo); // create the filter
            TSession::setValue('LinksList_filter_lincodigo',   $filter); // stores the filter in the session
        }
        
        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', '=', $data->artcodigo); // create the filter
            TSession::setValue('LinksList_filter_artcodigo',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Musica_filter_data', $data);
        
        $param=array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
    }
    
    
      public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'conexao'
            TTransaction::open('conexao');
            
            // creates a repository for Musica
            $repository = new TRepository('Links');
            $limit = Adianti\Registry\TSession::getValue("limit") ?  Adianti\Registry\TSession::getValue("limit") :  15;
            // creates a criteria
            $criteria = new TCriteria;
       
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'lincodigo';
                $param['direction'] = 'desc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('LinksList_filter_lincodigo')) {
                $criteria->add(TSession::getValue('LinksList_filter_lincodigo')); // add the session filter
            }
            if (TSession::getValue('LinksList_filter_artcodigo')) {
                $criteria->add(TSession::getValue('LinksList_filter_artcodigo')); // add the session filter
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
    
    function setAtivo($param){
        
        Adianti\Database\TTransaction::open("conexao");
        $link = new Links($param["lincodigo"]);
        $link->setAtivo();
        Adianti\Database\TTransaction::close();
        $this->onReload();

    }
    

}
