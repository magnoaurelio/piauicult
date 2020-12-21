<?php
/**
 * InstrumentoList Listing
 * @author  <your name here>
 */
class InstrumentoList extends TStandardList
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
        parent::setActiveRecord('Instrumento');   // defines the active record
        parent::setDefaultOrder('inscodigo', 'asc');         // defines the default order
        // parent::setCriteria($criteria) // define a standard filter

        parent::addFilterField('inscodigo', 'like', 'inscodigo'); // filterField, operator, formField
        parent::addFilterField('insnome', 'like', 'insnome'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_Instrumento');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Listagem de Instrumento');
        

        // create the form fields
        $inscodigo = new TEntry('inscodigo');
        $insnome = new TEntry('insnome');


        // add the fields
        $this->form->addQuickField('Código', $inscodigo,  50 );
        $this->form->addQuickField('Instrumento', $insnome,  200 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Instrumento_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('InstrumentoForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_inscodigo = new TDataGridColumn('inscodigo', 'Código', 'right');
        $column_insnome = new TDataGridColumn('insnome', 'Instrumento', 'left');
        $column_insassessorio1 = new TDataGridColumn('insassessorio1', 'Assessorio1', 'left');
        $column_insassessorio2 = new TDataGridColumn('insassessorio2', 'Assessorio2', 'left');
        $column_insassessorio3 = new TDataGridColumn('insassessorio3', 'Assessorio3', 'left');
        $column_insquant = new TDataGridColumn('insquant', 'Qte', 'right');
        $column_insfoto = new TDataGridColumn('insfoto', 'Imagem', 'left');

         $column_insfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/instrumento/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_inscodigo);
        $this->datagrid->addColumn($column_insnome);
        $this->datagrid->addColumn($column_insassessorio1);
        $this->datagrid->addColumn($column_insassessorio2);
        $this->datagrid->addColumn($column_insassessorio3);
        $this->datagrid->addColumn($column_insquant);
        $this->datagrid->addColumn($column_insfoto);


        // creates the datagrid column actions
        $order_inscodigo = new TAction(array($this, 'onReload'));
        $order_inscodigo->setParameter('order', 'inscodigo');
        $column_inscodigo->setAction($order_inscodigo);
        
        $order_insnome = new TAction(array($this, 'onReload'));
        $order_insnome->setParameter('order', 'insnome');
        $column_insnome->setAction($order_insnome);
        
 
        
        // create EDIT action
        $action_edit = new TDataGridAction(array('InstrumentoForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('inscodigo');
        $this->datagrid->addAction($action_edit);
        

        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('inscodigo');
        $this->datagrid->addAction($action_del);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload'))); //reorganize
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Instrumento Listagem', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    

}
