<?php
/**
 * DiscoArtistaList Listing
 * @author  <your name here>
 */
class FestivalMusicaList extends TPage
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
        $this->form->setFormTitle('Festival (Participante) -  Festival: <b><span id="artnome"><span></b>');
        
        $inscodigo = new \Adianti\Widget\Wrapper\TDBCombo('muscodigo','conexao','Musica','muscodigo','{muscodigo} - {musnome} - {Compositor->artusual}');
        $this->form->addQuickField('Músicas', $inscodigo,  '100%' );
        $inscodigo->enableSearch();


        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Instrumento_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction('Adicionar musica', new TAction(array($this, 'onSearch')), 'fa:save green');
        $this->form->addQuickAction('Voltar', new TAction(array('FestivalList', 'onReload')), 'fa:reply green');

        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_muscodigo = new TDataGridColumn('muscodigo', 'Código', 'right', 60);
        $column_artnome = new TDataGridColumn('musnome', 'Nome', 'left');


        // criar na grade um ordenação nome
        $order_artnome = new TAction(array($this, 'onReload'));
        $order_artnome->setParameter('order', 'muscodigo');
        $column_artnome->setAction($order_artnome);

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_muscodigo);
        $this->datagrid->addColumn($column_artnome);

      
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('muscodigo');
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
        $container->add(TPanelGroup::pack('Disco (Produtor) -  Disco: <b><span id="artnome"><span></b>', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
     function onLoad($param){
        TSession::setValue('fescodigo',$param['fescodigo']);
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
        $festival =  new Festival(TSession::getValue('fescodigo'));
        $festival->addMusicaSave($param['muscodigo']);
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
            $repository = new TRepository('Musica');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $festival =  new Festival(TSession::getValue('fescodigo'));
             TScript::create('
              $("#artnome").html("'.$festival->fesnome.'")    
            ');
            $this->datagrid->clear();
          
            if( $festival->getMusicas() ) {
                // iterate the collection of active records
                foreach ($festival->getMusicas() as $object)
                {
                    $this->datagrid->addItem($object);
                }
            }
            
            // reset the criteria for record count
            $criteria->resetProperties();
            $count= sizeof($festival->getMusicas());
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
        $festival =  new Festival(TSession::getValue('fescodigo'));
        $festival->removeMusicaSave($param['muscodigo']);
       TTransaction::close();
       $this->onReload();
    }
    
    /**
     * Delete a record
     */
    public function Delete($param)
    {
        try
        {
            $key=$param['key']; // get the parameter $key
            TTransaction::open('conexao'); // open a transaction with database
            $object = new Artista($key, FALSE); // instantiates the Active Record
            $object->delete(); // deletes the object from the database
            TTransaction::close(); // close the transaction
            $this->onReload( $param ); // reload the listing
            new TMessage('info', AdiantiCoreTranslator::translate('Record deleted')); // success message
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    



    
   
}
