<?php
/**
 * TopoList Listing
 * @author  <your name here>
 */
class TopoList extends TStandardList
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
        parent::setActiveRecord('Topo');   // defines the active record
        parent::setDefaultOrder('topcodigo', 'asc');         // defines the default order
        // parent::setCriteria($criteria) // define a standard filter

        parent::addFilterField('topcodigo', 'like', 'topcodigo'); // filterField, operator, formField
        parent::addFilterField('toptitulo', 'like', 'toptitulo'); // filterField, operator, formField
        parent::addFilterField('toptexto', 'like', 'toptexto'); // filterField, operator, formField
        parent::addFilterField('topimagem', 'like', 'topimagem'); // filterField, operator, formField*/
        
        // creates the form
        $this->form = new TQuickForm('form_search_Topo');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Notícias do TOPO - Listagem');
        

        // create the form fields
        $topcodigo = new TEntry('topcodigo');
      //  $toptitulo = new TEntry('toptitulo');
        $toptitulo = new TDBCombo('toptitulo','conexao','Topo','toptitulo','toptitulo','toptitulo');
        $toptexto = new TEntry('toptexto');
        $topimagem = new TEntry('topimagem');

         $toptitulo->enableSearch();
        
        // add the fields
        $this->form->addQuickField('Código', $topcodigo,  50 );
        $this->form->addQuickField('Título', $toptitulo,  300 );
     /*   $this->form->addQuickField('Texto', $toptexto,  200 );
        $this->form->addQuickField('Imagem', $topimagem,  100 );*/

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Topo_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('TopoForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_topcodigo = new TDataGridColumn('topcodigo', 'Código', 'center');
        $column_toptitulo = new TDataGridColumn('toptitulo', 'Título', 'left');
        $column_toptexto = new TDataGridColumn('toptexto', 'Texto', 'left');
        $column_topimagem = new TDataGridColumn('topimagem', 'Imagem', 'left');

        
          $column_topimagem->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/topo/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_topcodigo);
        $this->datagrid->addColumn($column_toptitulo);
        $this->datagrid->addColumn($column_toptexto);
        $this->datagrid->addColumn($column_topimagem);


        // criar na grade um ordenação
        $order_toptitulo = new TAction(array($this, 'onReload'));
        $order_toptitulo->setParameter('order', 'toptitulo');
        $column_toptitulo->setAction($order_toptitulo);
        

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('TopoForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('topcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('topcodigo');
        $this->datagrid->addAction($action_del);
        
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
        $container->add(TPanelGroup::pack('Topo Listagem', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    

}
