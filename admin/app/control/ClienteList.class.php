<?php
/**
 * ClienteList Listing
 * @author  <your name here>
 */
class ClienteList extends Adianti\Base\TStandardList
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
        parent::setActiveRecord('Cliente');   // defines the active record
        parent::setDefaultOrder('clicodigo', 'asc');
        parent::setLimit(30);// defines the default order
        // parent::setCriteria($criteria) // define a standard filter

        parent::addFilterField('clicodigo', 'like', 'clicodigo'); // filterField, operator, formField
        parent::addFilterField('clinome', 'like', 'clinome'); // filterField, operator, formField
        parent::addFilterField('cliusual', 'like', 'cliusual'); // filterField, operator, formField
        parent::addFilterField('cliprocodigo', '=', 'cliprocodigo'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_Cliente');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Cliente');
        

        // create the form fields
        
        $clicodigo = new TEntry('clicodigo');
        $clinome = new TEntry('clinome');
        $cliusual = new TEntry('cliusual');
        $clilote = new TEntry('clilote');
        $clicor = new TEntry('clicor');
        $clitamanho = new TEntry('clitamanho');
      //  $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','artusual','artusual');
        $cliprocodigo = new TDBCombo('cliprocodigo','conexao','ClienteProduto','cliprocodigo','{clipronome}-{cliprocodigo}','clipronome');
        
        // add the fields
        $this->form->addQuickField('Cd_Cliente', $clicodigo,  200 );
        $this->form->addQuickField('Nome', $clinome,  300 );
        $this->form->addQuickField('Nome Usual', $cliusual,  200 );
        $this->form->addQuickField('Tipo Produto', $cliprocodigo,  300 );
        $this->form->addQuickField('Nº Lote de Venda', $clilote,  300 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Cliente_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('ClienteForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_clicodigo = new TDataGridColumn('clicodigo', 'Nº', 'right');
        $column_clilote = new TDataGridColumn('clilote', 'Lote', 'left');
        $column_discodigo = new TDataGridColumn('discodigo', 'CD', 'right');
        $column_produto = new TDataGridColumn('tipoProduto->clipronome', 'Produto', 'left');
        $column_artusual = new TDataGridColumn('Responsavel->artusual','Responsavel', 'left');
     //   $column_clinome = new TDataGridColumn('clinome', 'Nome Responsavel', 'left');
        $column_cliusual = new TDataGridColumn('cliusual', 'Nome Impresso', 'left');
        $column_clicep = new TDataGridColumn('clicep', 'CEP', 'left');
        $column_clidatacompra = new TDataGridColumn('clidatacompra', 'Dt_Compra', 'center');
        $column_clifone = new TDataGridColumn('clifone', 'Fone', 'left');
        $column_clicelular = new TDataGridColumn('clicelular', 'Celular', 'left');
        $column_cliemail = new TDataGridColumn('cliemail', 'E-mail', 'left');
        $column_cliquantidade = new TDataGridColumn('cliquantidade', 'Qte', 'right');
        $column_clicor = new TDataGridColumn('clicor', 'Cor', 'left');
        $column_clitamanho = new TDataGridColumn('clitamanho', 'Tamanho', 'left');
        $column_clivalor = new TDataGridColumn('clivalor', 'Valor R$', 'left');
        
       // var_dump($column_artusual);
        //$clidatacompra->setMask("dd/mm/yyyy");
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_clicodigo);
        $this->datagrid->addColumn($column_clilote);
        $this->datagrid->addColumn($column_discodigo);
        $this->datagrid->addColumn($column_produto);
        $this->datagrid->addColumn($column_artusual);
        $this->datagrid->addColumn($column_cliusual);
       // $this->datagrid->addColumn($column_clicep);
   //     $this->datagrid->addColumn($column_clifone);
      
     //   $this->datagrid->addColumn($column_clidatacompra);
        $this->datagrid->addColumn($column_cliquantidade);
        $this->datagrid->addColumn($column_clicor);
        $this->datagrid->addColumn($column_clitamanho);
        $this->datagrid->addColumn($column_clivalor);
        
         // define the transformer method over image
        $column_clidatacompra->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });
        
        

        
        // create EDIT action
        $action_edit = new TDataGridAction(array('ClienteForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('clicodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('clicodigo');
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
        $container->add(TPanelGroup::pack('Clientes', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    

}
