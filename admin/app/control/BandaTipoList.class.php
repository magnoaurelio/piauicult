<?php
/**
 * BandaTipoList Listing
 * @author  <your name here>
 */
class BandaTipoList extends TStandardList
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
        parent::setActiveRecord('BandaTipo');   // defines the active record
        parent::setDefaultOrder('bantipocodigo', 'asc');         // defines the default order
        // parent::setCriteria($criteria) // define a standard filter

        parent::addFilterField('bantipocodigo', 'like', 'bantipocodigo'); // filterField, operator, formField
        parent::addFilterField('bantiponome', 'like', 'bantiponome'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_BandaTipo');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);

        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('BandaTipo');
        

        // create the form fields
        $bantipocodigo = new TEntry('bantipocodigo');
        $bantiponome = new TEntry('bantiponome');
        $bantipofoto = new TEntry('bantipofoto');
     

        // add the fields
        $this->form->addQuickField('Código', $bantipocodigo,  200 );
        $this->form->addQuickField('Tipo de Grupo Musical', $bantiponome,  200 );
        $this->form->addQuickField('Tipo de Grupo Musical', $bantipofoto,  200 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('BandaTipo_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('BandaTipoForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_bantipocodigo = new TDataGridColumn('bantipocodigo', 'Código', 'right');
        $column_bantiponome = new TDataGridColumn('bantiponome', 'Tipo de Grupo Musical', 'left');
        $column_bantipofoto = new TDataGridColumn('bantipofoto', 'Foto de Grupo Musical', 'left');
        
        $column_bantipofoto->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/banda_tipo/".$value;
           // $img->title = $object->artusual;
            $img->style = "width:90px; height:60px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_bantipocodigo);
        $this->datagrid->addColumn($column_bantiponome);
        $this->datagrid->addColumn($column_bantipofoto);

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('BandaTipoForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('bantipocodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('bantipocodigo');
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
        $container->add(TPanelGroup::pack('Artista Instrumento', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    

}
