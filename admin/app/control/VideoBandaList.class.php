<?php
/**
 * DiscoArtistaList Listing
 * @author  <your name here>
 */
class VideoBandaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $formgrid;
    private $loaded;
    private $deleteButton;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TQuickForm('form_search_Produtor');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Video (Banda) -  Video: <b><span id="artnome"><span></b>');

        $bancodigo = new \Adianti\Widget\Wrapper\TDBCombo('bancodigo','conexao','Banda','bancodigo','{bannome}','bannome');
        $this->form->addQuickField('Grupo', $bancodigo,  300 );
       
        $bancodigo->enableSearch();

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Instrumento_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction('Adicionar Grupo', new TAction(array($this, 'onSearch')), 'fa:save green');
        $this->form->addQuickAction('Voltar', new TAction(array('VideosList', 'onReload')), 'fa:reply green');


        // creates a Datagrid
        $this->datagrid = new \Adianti\Widget\Datagrid\TDataGrid();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->disableDefaultClick();
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');


        // creates the datagrid columns
        $column_artcodigo = new TDataGridColumn('bancodigo', 'Código', 'right', 60);
        $column_artnome = new TDataGridColumn('bannome', 'Nome', 'left');
        $column_bantipo = new TDataGridColumn('tipo->bantiponome', 'Tipo', 'left');
        $column_artfoto = new TDataGridColumn('banfoto1', 'Foto', 'left');

        // criar na grade um ordenação nome
        $order_artnome = new TAction(array($this, 'onReload'));
        $order_artnome->setParameter('order', 'bannome');
        $column_artnome->setAction($order_artnome);

        $column_artfoto->setTransformer( function($value, $object, $row) {
            $img  = new TElement('img');
            $img->src = "files/bandas/".$value;
            $img->style = "width:80px; height:80px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artnome);
        $this->datagrid->addColumn($column_bantipo);
        $this->datagrid->addColumn($column_artfoto);


        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('bancodigo');
        $this->datagrid->addAction($action_del);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Vídeo (Produtor) -  Vídeo: <b><span id="artnome"><span></b>', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
     function onLoad($param){
        TSession::setValue('vidcodigo',$param['vidcodigo']);
        $this->onReload();
    }
        
    
    /**
     * Inline record editing
     * @param $param Array containing:
     *              key: object ID value
     *              field name: object attribute to be updated
     *              value: new attribute content 
     */
    public function onInlineEdit($param)
    {
        try
        {
            // get the parameter $key
            $field = $param['field'];
            $key   = $param['key'];
            $value = $param['value'];
            
            TTransaction::open('conexao'); // open a transaction with database
            $object = new Disco($key); // instantiates the Active Record
            $object->{$field} = $value;
            $object->store(); // update the object in the database
            TTransaction::close(); // close the transaction
            
            $this->onReload($param); // reload the listing
            new TMessage('info', "Record Updated");
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Register the filter in the session
     */
    public function onSearch($param)
    {
        TTransaction::open('conexao');
        $collections = VideoBanda::where("id_video", "=", TSession::getValue('vidcodigo'))
            ->where("id_banda","=", $param["bancodigo"])->load();
        if (!$collections){
            $bd = new VideoBanda();
            $bd->id_video = TSession::getValue('vidcodigo');
            $bd->id_banda = $param["bancodigo"];
            $bd->store();
        }else{
            new \Adianti\Widget\Dialog\TMessage("info", "Grupo já adicionado");
        }
        TTransaction::close();
        $this->onReload();
    }
    
    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'conexao'
            TTransaction::open('conexao');
            
            // creates a repository for Artista
            $repository = new TRepository('VideoBanda');
            $limit = 10;
            // creates a criteria
            $criteria = new \Adianti\Database\TCriteria;
            $criteria->add(new \Adianti\Database\TFilter("id_video","=",TSession::getValue('vidcodigo')));
            $video =  new Videos(TSession::getValue('vidcodigo'));
             TScript::create('
              $("#artnome").html("'.$video->viddescricao.'")    
            ');
            $this->datagrid->clear();

            foreach ($repository->load($criteria) as $bandaVideo)
            {
                $object = new Banda($bandaVideo->id_banda);
                $this->datagrid->addItem($object);
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
    
    /**
     * Ask before deletion
     */
    public function onDelete($param)
    {
        TTransaction::open('conexao');
        VideoBanda::where("id_video", "=", TSession::getValue('vidcodigo'))
            ->where("id_banda","=", $param["bancodigo"])
            ->delete();
        TTransaction::close();
        $this->onReload();
    }


}
