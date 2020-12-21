<?php
/**
 * Festival_tipoFormList Registration
 * @author  <your name here>
 */
class Festival_tipoFormList extends TPage
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
        $this->setActiveRecord('Festival_tipo');   // defines the active record
        $this->setDefaultOrder('festipocodigo', 'asc');         // defines the default order
        // $this->setCriteria($criteria) // define a standard filter
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Festival_tipo');
        $this->form->setFormTitle('Festival tipo');
        

        // create the form fields
        $festipocodigo = new TEntry('festipocodigo');
        $festiponome = new TEntry('festiponome');
        $festipofoto = new \Adianti\Widget\Form\TFile('festipofoto');



        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $festipocodigo ] );
        $this->form->addFields( [ new TLabel('Descrição') ], [ $festiponome ] );
        $this->form->addFields( [ new TLabel('Imagem') ], [ $festipofoto ] );



        // set sizes
        $festipocodigo->setSize('100%');
        $festiponome->setSize('100%');
        $festipofoto->setSize('50%');
        $data_now = date('dmYHis');
           // incluir foto do TIPO FESTIVAL
        $nome_arquivo = 'FES_'.$data_now;//.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $festipofoto->setParametros('files/festivais/',$nome_arquivo,$permite); 
       
        
        if (!empty($festipocodigo))
        {
            $festipocodigo->setEditable(FALSE);
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
        $column_festipocodigo = new TDataGridColumn('festipocodigo', 'Código', 'left');
        $column_festiponome = new TDataGridColumn('festiponome', 'Descrição', 'left');
        $column_festipofoto = new TDataGridColumn('festipofoto', 'Imagem', 'left');
        
        $column_festipofoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/festivais/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_festipocodigo);
        $this->datagrid->addColumn($column_festiponome);
        $this->datagrid->addColumn($column_festipofoto);

        
        // creates two datagrid actions
        $action1 = new TDataGridAction([$this, 'onEdit']);
        //$action1->setUseButton(TRUE);
        //$action1->setButtonClass('btn btn-default');
        $action1->setLabel(_t('Edit'));
        $action1->setImage('fa:pencil-square-o blue fa-lg');
        $action1->setField('festipocodigo');
        
        $action2 = new TDataGridAction([$this, 'onDelete']);
        //$action2->setUseButton(TRUE);
        //$action2->setButtonClass('btn btn-default');
        $action2->setLabel(_t('Delete'));
        $action2->setImage('fa:trash-o red fa-lg');
        $action2->setField('festipocodigo');
        
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
