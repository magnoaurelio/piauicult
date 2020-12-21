<?php
/**
 * Festival_tipoFormList Registration
 * @author  <your name here>
 */
class Festival_premioFormList extends TPage
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
        $this->setActiveRecord('Festival_Premio');   // defines the active record
        $this->setDefaultOrder('fesprecodigo', 'asc');         // defines the default order
        // $this->setCriteria($criteria) // define a standard filter
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Festival_premio');
        $this->form->setFormTitle('Festival Premio');
        

        // create the form fields
        $fesprecodigo = new TEntry('fesprecodigo');
        $fesprenome = new TEntry('fesprenome');
        $fesprefoto = new \Adianti\Widget\Form\TFile('fesprefoto');



        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [  $fesprecodigo ] );
        $this->form->addFields( [ new TLabel('Descrição') ], [ $fesprenome ] );
        $this->form->addFields( [ new TLabel('Imagem') ], [ $fesprefoto ] );



        // set sizes
        $fesprecodigo->setSize('100%');
        $fesprenome->setSize('100%');
        $fesprefoto->setSize('50%');
        $data_now = date('dmYHis');
           // incluir foto do TIPO FESTIVAL
        $nome_arquivo = 'FES_'.$data_now;//.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $fesprefoto->setParametros('files/festivais/',$nome_arquivo,$permite); 
       
        
        if (!empty($fesprecodigo))
        {
            $fesprecodigo->setEditable(FALSE);
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
        // 
       

        // creates the datagrid columns
        $column_fesprecodigo = new TDataGridColumn('fesprecodigo', 'Código', 'left');
        $column_fespreonome = new TDataGridColumn('fesprenome', 'Descrição', 'left');
        $column_fesprefoto = new TDataGridColumn('fesprefoto', 'Imagem', 'left');
        
        $column_fesprefoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/festivais/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_fesprecodigo);
        $this->datagrid->addColumn($column_fespreonome);
        $this->datagrid->addColumn($column_fesprefoto);

        
        // creates two datagrid actions
        $action1 = new TDataGridAction([$this, 'onEdit']);
        //$action1->setUseButton(TRUE);
        //$action1->setButtonClass('btn btn-default');
        $action1->setLabel(_t('Edit'));
        $action1->setImage('fa:pencil-square-o blue fa-lg');
        $action1->setField('fesprecodigo');
        
        $action2 = new TDataGridAction([$this, 'onDelete']);
        //$action2->setUseButton(TRUE);
        //$action2->setButtonClass('btn btn-default');
        $action2->setLabel(_t('Delete'));
        $action2->setImage('fa:trash-o red fa-lg');
        $action2->setField('fesprecodigo');
        
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
