<?php
/**
 * DiscoArtistaList Listing
 * @author  <your name here>
 */
class ApresentadorEmissora extends TPage
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
        $this->form = new TQuickForm('form_search_Emissora');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Emissora (Apresentador): <b><span id="artnome"><span></b>');
        
        $inscodigo = new TDBCombo('aprcodigo','conexao','Apresentador','aprcodigo','aprnome','aprnome');
        $this->form->addQuickField('Apresentador', $inscodigo,  300 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Instrumento_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction('Adicionar Apresentador', new TAction(array($this, 'onSearch')), 'fa:save green');
        $this->form->addQuickAction('Voltar', new TAction(array('EmissoraList', 'onReload')), 'fa:reply green');

        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_artcodigo = new TDataGridColumn('aprcodigo', 'Código', 'right', 60);
        $column_artnome = new TDataGridColumn('aprnome', 'Nome', 'left');


 // criar na grade um ordenação nome
        $order_artnome = new TAction(array($this, 'onReload'));
        $order_artnome->setParameter('order', 'aprnome');
        $column_artnome->setAction($order_artnome);

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artnome);

      
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('aprcodigo');
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
        $container->add(TPanelGroup::pack('Artista (Instrumento) -  Artista: <b><span id="artnome"><span></b>', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
     function onLoad($param){
        TSession::setValue('emicodigo',$param['emicodigo']);
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
            $object = new Artista($key); // instantiates the Active Record
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
        $emissora =  new Emissora(TSession::getValue('emicodigo'));
        if(!empty($emissora->apresentador)){
            $ids = explode(';',$emissora->apresentador);
        }else{
            $ids = [];        
        }
        if(!in_array($param['aprcodigo'],$ids) and !empty($param['aprcodigo'])){
         $ids[] = $param['aprcodigo'];
        }
       $emissora->apresentador  = implode(';',$ids);
       $emissora->store();
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
            $repository = new TRepository('Apresentador');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
           $emissora =  new Emissora(TSession::getValue('emicodigo'));
             TScript::create('
              $("#artnome").html("'.$emissora->eminome.'")    
            ');
            $this->datagrid->clear();
            if(!empty($emissora->apresentador)){
                $ids = explode(';',$emissora->apresentador);
                // iterate the collection of active records
                foreach ($ids as $id)
                {
                    $object = new Apresentador($id);
                    $this->datagrid->addItem($object);
                }
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
        $emissora =  new Emissora(TSession::getValue('emicodigo'));
        $ids = explode(';',$emissora->apresentador);
        if($ids){
            foreach ($ids as $key=>$id)
              {
                  if($id == $param['aprcodigo']){
                     unset($ids[$key]);
                  }
               }
         }
        $emissora->apresentador  = implode(';',$ids);
        $emissora->store();
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
