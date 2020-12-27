<?php
/**
 * DiscoArtistaList Listing
 * @author  <your name here>
 */
class GeneroInstrumentoList extends TPage
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
        $this->form = new TQuickForm('form_search_Genero');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Gênero (Instrumento) -  Genero: <b><span id="gennome"><span></b>');
        
    //    $insfoto = new Adianti\Widget\Form\TEntry('insfoto');
        $inscodigo = new TDBCombo('inscodigo','conexao','Instrumento','inscodigo','{insnome}-{inscodigo}','insnome');
        $this->form->addQuickField('Instrumento', $inscodigo,  300 );
      //  $this->form->addQuickField('Foto', $insfoto,  200 );
        
        $inscodigo->enableSearch();

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Instrumento_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction('Adicionar Instrumento', new TAction(array($this, 'onSearch')), 'fa:save green');
   //     $this->form->addQuickAction('Voltar', new TAction(array('GeneroList', 'onReload')), 'fa:reply green');
        $btn_onshow = $this->form->addAction("Voltar", new TAction(['GeneroList', 'onShow']), 'fa:reply #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_artcodigo = new TDataGridColumn('inscodigo', 'Código', 'right', 60);
        $column_artnome = new TDataGridColumn('insnome', 'Nome', 'left');
        $column_insfoto = new TDataGridColumn('insfoto', 'Imagem', 'left');
        
        $column_insfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/instrumento/".$value;
          $img->style = "width:80px; height:80px;";
            return $img;
        });
        // criar na grade um ordenação nome
        $order_artnome = new TAction(array($this, 'onReload'));
        $order_artnome->setParameter('order', 'insnome');
        $column_artnome->setAction($order_artnome);

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artnome);
        $this->datagrid->addColumn($column_insfoto);

      
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
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Genero (Instrumento) -  Genero: <b><span id="Gennome"><span></b>', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
     function onLoad($param){
        TSession::setValue('gencodigo',$param['gencodigo']);
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
            $object = new Genero($key); // instantiates the Active Record
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
        $artista =  new Genero(TSession::getValue('gencodigo'));
        if(!empty($genero->inscodigo)){
            $ids = explode(';',$artista->inscodigo);
        }else{
            $ids = [];        
        }
        if(!in_array($param['inscodigo'],$ids) and !empty($param['inscodigo'])){
         $ids[] = $param['inscodigo'];
        }
       $genero->inscodigo  = implode(';',$ids);
       $artista->store();
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
            $repository = new TRepository('Instrumento');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $genero =  new Genero(TSession::getValue('gencodigo'));
           TScript::create('
              $("#gennome").html("'.$genero->gennome.'")');
            $this->datagrid->clear();
            if(!empty($genero->inscodigo)){
                $ids = explode(';',$genero->inscodigo);
                // iterate the collection of active records
                foreach ($ids as $id)
                {
                    $object = new Instrumento($id);
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
        $genero =  new Genero(TSession::getValue('gencodigo'));
        $ids = explode(';',$genero->inscodigo);
        if($ids){
            foreach ($ids as $key=>$id)
              {
                  if($id == $param['inscodigo']){
                     unset($ids[$key]);
                  }
               }
         }
        $artista->inscodigo  = implode(';',$ids);
        $artista->store();
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
            $object = new Genero($key, FALSE); // instantiates the Active Record
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
