<?php
/**
 * DiscoArtistaList Listing
 * @author  <your name here>
 */
class GeneroArtistaList extends TPage
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
        $this->form = new TQuickForm('form_search_Artista');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Artista  -  Genero: <b><span id="gennome"><span></b>');
        
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual} - {artcodigo}','artusual');
        $this->form->addQuickField('Artistas', $artcodigo,  300 );
        
        $artcodigo->enableSearch();

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Artista_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction('Adicionar ao Genero', new TAction(array($this, 'onSearch')), 'fa:save green');
        $this->form->addQuickAction('Voltar', new TAction(array('DiscoList', 'onReload')), 'fa:reply green');

        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
      
        // creates the datagrid columns
        $column_artcodigo = new TDataGridColumn('artcodigo', 'Código', 'right');
        $column_artfoto = new TDataGridColumn('artfoto', 'Foto', 'right');
        $column_artnome = new TDataGridColumn('artnome', 'Nome', 'left');
        $column_artusual = new TDataGridColumn('artusual', 'Usual', 'left');

         $column_artfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_artnome);
        $this->datagrid->addColumn($column_artusual);
        $this->datagrid->addColumn($column_artfoto);

      
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('artcodigo');
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
        $container->add(TPanelGroup::pack('Artista  -  Genero: <b><span id="gennome"><span></b>', $this->form));
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
        $genero =  new Genero(TSession::getValue('gencodigo'));
        if(!empty($genero->artcodigo)){
            $ids = explode(';',$genero->artcodigo);
        }else{
            $ids = [];        
        }
        if(!in_array($param['artcodigo'],$ids) and !empty($param['artcodigo'])){
         $ids[] = $param['artcodigo'];
        }
        $genero->artcodigo  = implode(';',$ids);
        $genero->store();
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
            $repository = new TRepository('Artista');
            $limit = 20;
            // creates a criteria
            $criteria = new TCriteria;
            $genero =  new Disco(TSession::getValue('gencodigo'));
             TScript::create('
              $("#gennome").html("'.$genero->gennome.'")    
            ');
            $this->datagrid->clear();
            if(!empty($genero->artcodigo)){
                $ids = explode(';',$genero->artcodigo);
                // iterate the collection of active records
                foreach ($ids as $id)
                {
                    $object = new Artista($id);
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
        $ids = explode(';',$genero->artcodigo);
        if($ids){
            foreach ($ids as $key=>$id)
              {
                  if($id == $param['artcodigo']){
                     unset($ids[$key]);
                  }
               }
         }
        $genero->artcodigo  = implode(';',$ids);
        $genero->store();
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
