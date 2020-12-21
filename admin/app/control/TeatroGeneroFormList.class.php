<?php
/**
 * TeatroGeneroFormList Registration
 * @author  <Magno aurelio>
 */
class TeatroGeneroFormList extends TPage
{
    protected $form; // form
    protected $datagrid; // datagrid
    protected $pageNavigation;
    
    use Adianti\Base\AdiantiStandardFormListTrait; // standard form/list methods
    
    /**
     * Class constructor
     * Creates the page and the registration form
     * Construtor de classe
     * Cria a página e o formulário de inscrição
     */
    public function __construct()
    {
        parent::__construct();
        
        error_reporting(E_ERROR | E_PARSE);
        
        $this->setDatabase('conexao');            // defines the database - define o banco de dados
        $this->setActiveRecord('TeatroGenero');   // defines the active record - define o registro ativo
        $this->setDefaultOrder('teagencodigo', 'asc');// defines the default order - define a ordem padrão
        // $this->setCriteria($criteria) // define a standard filter - definir um filtro padrão
        
        // creates the form - cria o formulário
        $this->form = new Adianti\Widget\Wrapper\TQuickForm('form_ArtistaTipo');
        $this->form->class = 'tform'; // change CSS class
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form = new BootstrapFormBuilder('form_TeatroGenero');
        $this->form->setFormTitle('Teatro Gênero');
        

        // create the form fields - crie os campos do formulário
        $teagencodigo = new TEntry('teagencodigo');
        $teagennome = new TEntry('teagennome');
        $teagenfoto = new Adianti\Widget\Form\TFile('teagenfoto');
        
        $this->form->setData( TSession::getValue('TipoList_filter_tipo') );
        
         // incluir foto do ARTISTA
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'TEA'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $teagenfoto->setParametros('files/teatro/',$nome_arquivo,$permite);


        // add the fields - adicione os campos
        $this->form->addFields( [ new TLabel('Código') ], [ $teagencodigo ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $teagennome ] );
        $this->form->addFields( [ new TLabel('Foto') ], [ $teagenfoto ] );



        // set sizes - definir tamanhos
        $teagencodigo->setSize('100%');
        $teagennome->setSize('100%');
        $teagenfoto->setSize('100%');


        
        if (!empty($teagencodigo))
        {
            $teagencodigo->setEditable(FALSE);
        }
        
        /** samples - amostras
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation - adicionar validação
         $fieldX->setSize( '100%' ); // set size -  definir tamanho
        **/
         
        // create the form actions - crie as ações do formulário
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        
        // creates a DataGrid - cria um DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        // $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
        

        // creates the datagrid columns - cria as colunas da grade de dados
        $column_teagencodigo = new TDataGridColumn('teagencodigo', 'Código', 'left');
        $column_teagennome = new TDataGridColumn('teagennome', 'Nome', 'left');
        $column_teagenfoto = new TDataGridColumn('teagenfoto', 'Foto', 'left');
        
        $column_teagenfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/teatro/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid - adicione as colunas ao DataGrid
        $this->datagrid->addColumn($column_teagencodigo);
        $this->datagrid->addColumn($column_teagennome);
        $this->datagrid->addColumn($column_teagenfoto);

        
        // creates two datagrid actions - cria duas ações de datagrid (editar e deletar)
        $action1 = new TDataGridAction([$this, 'onEdit']);
        $action1->setUseButton(TRUE);
        $action1->setButtonClass('btn btn-default');
        $action1->setLabel(_t('Edit'));
        $action1->setImage('fa:pencil-square-o blue fa-lg');
        $action1->setField('teagencodigo');
        
        $action2 = new TDataGridAction([$this, 'onDelete']);
        $action2->setUseButton(TRUE);
        $action2->setButtonClass('btn btn-default');
        $action2->setLabel(_t('Delete'));
        $action2->setImage('fa:trash-o red fa-lg');
        $action2->setField('teagencodigo');
        
        // add the actions to the datagrid - adicione as ações ao datagrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);
        
        // create the datagrid model - crie o modelo da grade de dados
        $this->datagrid->createModel();
        
        // create the page navigation - crie a navegação da página
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // vertical box container - contêiner de caixa vertical
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid));
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
}
