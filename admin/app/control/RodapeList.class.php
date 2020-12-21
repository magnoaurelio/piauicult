<?php
/**
 * RodapeList Listing
 * @author  <your name here>
 */
class RodapeList extends TStandardList
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
        parent::setActiveRecord('Rodape');   // defines the active record
        parent::setDefaultOrder('rodcodigo', 'asc');         // defines the default order
        // parent::setCriteria($criteria) // define a standard filter

        parent::addFilterField('rodcodigo', 'like', 'rodcodigo'); // filterField, operator, formField
        parent::addFilterField('rodtitulo', 'like', 'rodtitulo'); // filterField, operator, formField
      /*  parent::addFilterField('rodtexto', 'like', 'rodtexto'); // filterField, operator, formField
        parent::addFilterField('rodimagem', 'like', 'rodimagem'); // filterField, operator, formField*/
        
        // creates the form
        $this->form = new TQuickForm('form_search_Rodape');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Notícias do RODAPÉ - Listagem');
        

        // create the form fields
        $rodcodigo = new TEntry('rodcodigo');
       // $rodtitulo = new TEntry('rodtitulo');
        $rodtitulo = new TDBCombo('rodtitulo','conexao','Rodape','rodtitulo','rodtitulo','rodtitulo');
        $rodtexto = new TEntry('rodtexto');
        $rodimagem = new TEntry('rodimagem');

        $rodtitulo->enableSearch();
        
        // add the fields
        $this->form->addQuickField('Código', $rodcodigo,  50 );
        $this->form->addQuickField('Título', $rodtitulo,  300 );
      /*  $this->form->addQuickField('Texto', $rodtexto,  200 );
        $this->form->addQuickField('Imagem', $rodimagem,  200 );*/

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Rodape_filter_data') );
        
        // adicona ação de uma buscano formulario
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('RodapeForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_rodcodigo = new TDataGridColumn('rodcodigo', 'Código', 'center');
        $column_rodtitulo = new TDataGridColumn('rodtitulo', 'Título', 'left');
        $column_rodtexto = new TDataGridColumn('rodtexto', 'Texto', 'left');
        $column_rodimagem = new TDataGridColumn('rodimagem', 'Imagem', 'left');
        
        $column_rodimagem->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/rodape/".$value;
          $img->style = "width:90px; height:60px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_rodcodigo);
        $this->datagrid->addColumn($column_rodtitulo);
        $this->datagrid->addColumn($column_rodtexto);
        $this->datagrid->addColumn($column_rodimagem);


        // cria uma de dordenação no formulario
        $order_rodcodigo = new TAction(array($this, 'onReload'));
        $order_rodcodigo->setParameter('order', 'rodcodigo');
        $column_rodcodigo->setAction($order_rodcodigo);
        
        $order_rodtitulo = new TAction(array($this, 'onReload'));
        $order_rodtitulo->setParameter('order', 'rodtitulo');
        $column_rodtitulo->setAction($order_rodtitulo);
        

        
        // create EDIT action / cria uma açao de edição
        $action_edit = new TDataGridAction(array('RodapeForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('rodcodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action - cria uma açao de deleção
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('rodcodigo');
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
        $container->add(TPanelGroup::pack('Rodapé Listagem', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    

}
