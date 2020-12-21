<?php
/**
 * ArtistaTipoFormList Registration
 * @author  <your name here>
 */

class ArtistaTipoFormList extends TPage
{
    protected $form; // form
    protected $datagrid; // datagrid
    protected $pageNavigation;
    
    use Adianti\Base\AdiantiStandardFormListTrait; // standard form/list methods
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('conexao');            // defines the database
        $this->setActiveRecord('ArtistaTipo');   // defines the active record
        $this->setDefaultOrder('arttipocodigo', 'asc');         // defines the default order
        // $this->setCriteria($criteria) // define a standard filter
        
        // creates the form
        $this->form = new TQuickForm('form_ArtistaTipo');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Tipo de Artista');
        


        // create the form fields
        $arttipocodigo = new TEntry('arttipocodigo');
        $arttiponome = new TEntry('arttiponome');
        $arttipofoto = new TFile('arttipofoto');


        $this->form->setData( TSession::getValue('TipoList_filter_tipo') );
         
        
        // incluir foto do ARTISTA
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'TIP'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $arttipofoto->setParametros('files/artista_tipo/',$nome_arquivo,$permite); 

        // add the fields
        $this->form->addQuickField('Código', $arttipocodigo,  50 );
        $this->form->addQuickField('Tipo de Artista', $arttiponome,  200 );
        $this->form->addQuickField('Foto Tipo de Artista', $arttipofoto,  200 );



        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'bs: reply green');
       //  $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        ##LIST_DECORATOR##
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
       

        // creates the datagrid columns
        $column_arttipocodigo = new TDataGridColumn('arttipocodigo', 'Código', 'left');
        $column_arttiponome = new TDataGridColumn('arttiponome', 'Tipo de Artista', 'left');
        $column_arttipofoto = new TDataGridColumn('arttipofoto', 'Foto do Tipo de Artista', 'left');
        
        $column_arttipofoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artista_tipo/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });
        
// criar na grade um ordenação
        $order_arttiponome = new TAction(array($this, 'onReload'));
        $order_arttiponome->setParameter('order', 'arttiponome');
        $column_arttiponome->setAction($order_arttiponome);

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_arttipocodigo);
        $this->datagrid->addColumn($column_arttiponome);
        $this->datagrid->addColumn($column_arttipofoto);

        
        // creates two datagrid actions
        $action1 = new TDataGridAction(array($this, 'onEdit'));
        $action1->setUseButton(TRUE);
        $action1->setButtonClass('btn btn-default');
        $action1->setLabel(_t('Edit'));
        $action1->setImage('fa:pencil-square-o blue fa-lg');
        $action1->setField('arttipocodigo');
        
        $action2 = new TDataGridAction(array($this, 'onDelete'));
        $action2->setUseButton(TRUE);
        $action2->setButtonClass('btn btn-default');
        $action2->setLabel(_t('Delete'));
        $action2->setImage('fa:trash-o red fa-lg');
        $action2->setField('arttipocodigo');
        
        // add the actions to the datagrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);
        
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
        $container->add(TPanelGroup::pack('Artista Tipo', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }


    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();

        // clear session filters
        TSession::setValue('TipoList_filter_tipo',   NULL);

        if (isset($data->arttiponome) AND ($data->arttiponome)) {
            $filter = new TFilter('arttiponome', 'like', "%{$data->arttiponome}%"); // create the filter
            TSession::setValue('TipoList_filter_tipo',   $filter); // stores the filter in the session
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue('TipoList_filter_data', $data);

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

            // creates a repository for Noticias
            $repository = new TRepository('ArtistaTipo');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;

            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'arttipocodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);


            if (TSession::getValue('TipoList_filter_tipo')) {
                $criteria->add(TSession::getValue('TipoList_filter_tipo')); // add the session filter
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
}
