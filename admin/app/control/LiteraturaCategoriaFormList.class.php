<?php
/**
 * LiteraturaCategoriaFormList Registration
 * @author  <your name here>
 */
class LiteraturaCategoriaFormList extends TPage
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
        
        error_reporting(E_ERROR | E_PARSE);
        
        $this->setDatabase('conexao');            // defines the database
        $this->setActiveRecord('LiteraturaCategoria');   // defines the active record
        $this->setDefaultOrder('litcatcodigo', 'asc');         // defines the default order
        // $this->setCriteria($criteria) // define a standard filter
        
        // creates the form
        $this->form = new Adianti\Widget\Wrapper\TQuickForm('form_ArtistaTipo');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormBuilder('form_LiteraturaCategoria');
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Literatura Categoria Publicar');
        

        // create the form fields
        $litcatcodigo = new TEntry('litcatcodigo');
        $litcatnome = new TEntry('litcatnome');
        $litcatfoto = new TFile('litcatfoto');
        
        $this->form->setData( TSession::getValue('TipoList_filter_tipo') );
        
         // incluir foto do ARTISTA
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'LIT'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $litcatfoto->setParametros('files/literatura/',$nome_arquivo,$permite);


        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $litcatcodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $litcatnome ] );
        $this->form->addFields( [ new TLabel('Foto') ], [ $litcatfoto ] );



        // set sizes
        $litcatcodigo->setSize('100%');
        $litcatnome->setSize('100%');
        $litcatfoto->setSize('100%');


        
        if (!empty($litcatcodigo))
        {
            $litcatcodigo->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_litcatcodigo = new TDataGridColumn('litcatcodigo', 'Código', 'left');
        $column_litcatnome = new TDataGridColumn('litcatnome', 'Nome', 'left');
        $column_litcatfoto = new TDataGridColumn('litcatfoto', 'Foto', 'left');
        
        $column_litcatfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/literatura/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_litcatcodigo);
        $this->datagrid->addColumn($column_litcatnome);
        $this->datagrid->addColumn($column_litcatfoto);

        
        // creates two datagrid actions
        $action1 = new TDataGridAction([$this, 'onEdit']);
        $action1->setUseButton(TRUE);
        $action1->setButtonClass('btn btn-default');
        $action1->setLabel(_t('Edit'));
        $action1->setImage('fa:pencil-square-o blue fa-lg');
        $action1->setField('litcatcodigo');
        
        $action2 = new TDataGridAction([$this, 'onDelete']);
        $action2->setUseButton(TRUE);
        $action2->setButtonClass('btn btn-default');
        $action2->setLabel(_t('Delete'));
        $action2->setImage('fa:trash-o red fa-lg');
        $action2->setField('litcatcodigo');
        
        // add the actions to the datagrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid));
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
