<?php
/**
 * MusicaList Listing
 * @author  <your name here>
 */
class MusicaList extends TPage
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
        $this->form = new TQuickForm('form_search_Musica');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Musicas Diversas');
        

        // create the form fields
        $muscodigo = new TEntry('muscodigo');
        $musnome = new TEntry('musnome');
        $musregistro = new TEntry('musregistro');
        $musduracao = new TEntry('musduracao');
        $musdata = new TEntry('musdata');
        $musautor = new TDBCombo('musautor','conexao','Artista','artcodigo','{artusual} - {artcodigo}','artusual');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual} - {artcodigo}','artusual');
        $gencodigo = new TEntry('gencodigo');
        $musfaixa = new TEntry('musfaixa');
        $muslanca = new TEntry('muslanca');
        $discodigo = new TDBCombo('discodigo','conexao','Disco','discodigo','{disnome} - {discodigo}','disnome');
        
        $musautor->enableSearch();
        $artcodigo->enableSearch();
        $discodigo->enableSearch();
        

        // add the fields
        $this->form->addQuickField('Código', $muscodigo,  100 );
        $this->form->addQuickField('Registro', $musregistro,  200 );
        $this->form->addQuickField('Nome Música', $musnome,  400 );
        $this->form->addQuickField('Disco', $discodigo,  400 );
        $this->form->addQuickField('Autor', $musautor,  400 );
        $this->form->addQuickField('Interprete', $artcodigo,  400 );
      // $this->form->addQuickField('Musdata', $musdata,  200 );
//      $this->form->addQuickField('Gencodigo', $gencodigo,  200 );
//      $this->form->addQuickField('Musfaixa', $musfaixa,  200 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Musica_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array('MusicaForm', 'onEdit')), 'bs:plus-sign green');
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_muscodigo = new TDataGridColumn('muscodigo', 'Código', 'right');
        $column_musnome = new TDataGridColumn('musnome', 'Nome Música', 'left');
        $column_musdisco = new TDataGridColumn('Disco->disimagem', 'Disco', 'left');
        $column_musduracao = new TDataGridColumn('musduracao', 'Duração', 'left');
        $column_musdata = new TDataGridColumn('musdata', 'Data', 'left');
        $column_musautor = new TDataGridColumn('Compositor->artusual', 'Autor', 'left');
        $column_autorfoto = new TDataGridColumn('Compositor->artfoto', 'Foto', 'center');
        $column_artcodigo = new TDataGridColumn('Interprete->artfoto', 'Artista', 'right');
        $column_gencodigo = new TDataGridColumn('gencodigo', 'Gênero', 'right');
        $column_musfaixa = new TDataGridColumn('musfaixa', 'Faixa', 'right');
        $column_mustocada = new TDataGridColumn('mustocada', 'Qt Play', 'left');
        $column_mussobre = new TDataGridColumn('mussobre', 'Descrição', 'left');
        $column_musativo = new TDataGridColumn('musativo', 'Ativo', 'left');
        $column_livativo = new TDataGridColumn('livativo', 'Livro', 'left');
        $column_letativo = new TDataGridColumn('letativo', 'Letra', 'left');
        $column_muslanca = new TDataGridColumn('muslanca', 'Lançamento', 'left');
        


        $order_muscodigo = new TAction(array($this, 'onReload'));
        $order_muscodigo->setParameter('order', 'muscodigo');
        $column_muscodigo->setAction($order_muscodigo);
        
        $column_autorfoto->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
         $column_artcodigo->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/artistas/".$value;
          $img->title = $object->get_Interprete()->artusual;
          $img->style = "width:60px; height:60px;";
            return $img;
        });
        
        $column_musdisco->setTransformer( function($value, $object, $row) {
          $img  = new TElement('img');
          $img->src = "files/discos/".$value;
          $img->title = $object->get_Disco()->disnome;
          $img->style = "width:60px; height:60px;";
            return $img;
        });


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_muscodigo);
        $this->datagrid->addColumn($column_musnome);
        $this->datagrid->addColumn($column_musautor);
        $this->datagrid->addColumn($column_autorfoto);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_musdisco);
        $this->datagrid->addColumn($column_musduracao);
        $this->datagrid->addColumn($column_musdata);
        $this->datagrid->addColumn($column_gencodigo);
        $this->datagrid->addColumn($column_mustocada);
        $this->datagrid->addColumn($column_mussobre);
        $this->datagrid->addColumn($column_musativo);
        $this->datagrid->addColumn($column_livativo);
        $this->datagrid->addColumn($column_letativo);
        $this->datagrid->addColumn($column_vidativo);

// criar na grade um ordenação
        $order_musnome = new TAction(array($this, 'onReload'));
        $order_musnome->setParameter('order', 'musnome');
        $column_musnome->setAction($order_musnome);
// criar na grade um ordenação
        $order_musautor = new TAction(array($this, 'onReload'));
        $order_musautor->setParameter('order', 'musautor');
        $column_musautor->setAction($order_musautor);
        
          $column_musdata->setTransformer( function($value, $object, $row) {
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_muscodigo);
        $this->datagrid->addColumn($column_musnome);
      //  $this->datagrid->addColumn($column_musregistro);
      //  $this->datagrid->addColumn($column_musduracao);
      //  $this->datagrid->addColumn($column_musdata);
        $this->datagrid->addColumn($column_musautor);
        $this->datagrid->addColumn($column_artcodigo);
        $this->datagrid->addColumn($column_gencodigo);
     //   $this->datagrid->addColumn($column_musfaixa);
     
      // define the transformer method over image
        
        $column_muscodigo->setTransformer( function($value, $object, $row) {

           if($object->musativo == "S"){
               $row->children[2]->children[0]->children[0]->style = "color:#31B131";
           }
           if($object->letativo == "S"){
               $row->children[3]->children[0]->children[0]->style = "color:#31B131";
           }
           if($object->livativo == "S"){
               $row->children[4]->children[0]->children[0]->style = "color:#31B131";
           }
           if($object->vidativo == "S"){
               $row->children[5]->children[0]->children[0]->style = "color:#31B131";
           }
            return $value;
        });
        
        
        

        // create EDIT action
        $action_edit = new TDataGridAction(array('MusicaForm', 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        //$action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('muscodigo');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        //$action_del->setLabel(_t('Delete'));
        $action_del->setImage('fa:trash-o red fa-lg');
        $action_del->setField('muscodigo');
        $this->datagrid->addAction($action_del);
        
        
        //$action_group->addSeparator();
        $action_group = new TDataGridActionGroup('Ações', 'bs:th');
        $action_group->addHeader('Complementares');
        
        // autores
        $action_edit = new TDataGridAction(array('MusicaAutorList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Autor');
        $action_edit->setImage('fa:registered green fa-lg');
        $action_edit->setField('muscodigo');
        $action_group->addAction($action_edit);
        // interpretes
        $action_edit = new TDataGridAction(array('MusicaArtistaList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Interprete');
        $action_edit->setImage('fa:star blue fa-lg');
        $action_edit->setField('muscodigo');
        $action_group->addAction($action_edit);
         // interpretes
        $action_edit = new TDataGridAction(array('MusicaArranjoList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Arranjo');
        $action_edit->setImage('fa:music blue fa-lg');
        $action_edit->setField('muscodigo');
        $action_group->addAction($action_edit);
        
         // interpretes
        $action_edit = new TDataGridAction(array('MusicaMusicoList', 'onLoad'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel('Músicos');
        $action_edit->setImage('fa:music blue fa-lg');
        $action_edit->setField('muscodigo');
        $action_group->addAction($action_edit);
         
         
        $this->datagrid->addActionGroup($action_group);
        
          // create ONOFF action
        $action_onoff = new TDataGridAction(array($this, 'onTurnOnOff'),["tipo"=>"musica"]);
        $action_onoff->setButtonClass('btn btn-default');
        $action_onoff->setLabel("Música: "._t('Activate/Deactivate'));
        $action_onoff->setImage('fa:power-off fa-lg orange');
        $action_onoff->setField('muscodigo');
        $this->datagrid->addAction($action_onoff);
        
          // create ONOFF action
        $action_onoff = new TDataGridAction(array($this, 'onTurnOnOff'),["tipo"=>"letra"]);
        $action_onoff->setButtonClass('btn btn-default');
        $action_onoff->setLabel("Letra: "._t('Activate/Deactivate'));
        $action_onoff->setImage('fa:file-word-o fa-lg orange');
        $action_onoff->setField('muscodigo');
        $this->datagrid->addAction($action_onoff);
        
            // create ONOFF action
        $action_onoff = new TDataGridAction(array($this, 'onTurnOnOff'),["tipo"=>"livro"]);
        $action_onoff->setButtonClass('btn btn-default');
        $action_onoff->setLabel("Livro: "._t('Activate/Deactivate'));
        $action_onoff->setImage('fa:book fa-lg orange');
        $action_onoff->setField('muscodigo');
        $this->datagrid->addAction($action_onoff);
        
            // create ONOFF action
        $action_onoff = new TDataGridAction(array($this, 'onTurnOnOff'),["tipo"=>"video"]);
        $action_onoff->setButtonClass('btn btn-default');
        $action_onoff->setLabel("Vídeo: "._t('Activate/Deactivate'));
        $action_onoff->setImage('fa:camera  fa-lg orange');
        $action_onoff->setField('muscodigo');
        $this->datagrid->addAction($action_onoff);
        
        
                
      
        
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
        $container->add(TPanelGroup::pack('Música Listagem', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    
    
    public function onTurnOnOff($param)
    {
        try
        {
            TTransaction::open('conexao');
            $musica = Musica::find($param['muscodigo']);
            if ($musica instanceof Musica)
            {

               switch($param['tipo']){
                   case "musica":
                     $musica->musativo = $musica->musativo == 'S' ? 'N' : 'S';
                     break;
                   case "letra":
                      $musica->letativo = $musica->letativo == 'S' ? 'N' : 'S';
                     break;
                   case "livro":
                     $musica->livativo = $musica->livativo == 'S' ? 'N' : 'S';
                     break;
                   case "video":
                      $musica->vidativo = $musica->vidativo == 'S' ? 'N' : 'S';
                     break;
                 
                }
                $musica->store();
            }
            
            TTransaction::close();
            
            $this->onReload($param);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
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
            $object = new Musica($key); // instantiates the Active Record
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
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue('MusicaList_filter_muscodigo',   NULL);
        TSession::setValue('MusicaList_filter_musnome',   NULL);
        TSession::setValue('MusicaList_filter_musregistro',   NULL);
        TSession::setValue('MusicaList_filter_musduracao',   NULL);
        TSession::setValue('MusicaList_filter_musdata',   NULL);
        TSession::setValue('MusicaList_filter_musautor',   NULL);
        TSession::setValue('MusicaList_filter_artcodigo',   NULL);
        TSession::setValue('MusicaList_filter_gencodigo',   NULL);
        TSession::setValue('MusicaList_filter_musfaixa',   NULL);
        TSession::setValue('MusicaList_filter_musdisco',   NULL);
        TSession::setValue('MusicaList_filter_disco',   NULL);

        if (isset($data->muscodigo) AND ($data->muscodigo)) {
            $filter = new TFilter('muscodigo', 'like', "%{$data->muscodigo}%"); // create the filter
            TSession::setValue('MusicaList_filter_muscodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->musnome) AND ($data->musnome)) {
            $filter = new TFilter('musnome', 'like', "%{$data->musnome}%"); // create the filter
            TSession::setValue('MusicaList_filter_musnome',   $filter); // stores the filter in the session
        }


        if (isset($data->musregistro) AND ($data->musregistro)) {
            $filter = new TFilter('musregistro', 'like', "%{$data->musregistro}%"); // create the filter
            TSession::setValue('MusicaList_filter_musregistro',   $filter); // stores the filter in the session
        }


        if (isset($data->musduracao) AND ($data->musduracao)) {
            $filter = new TFilter('musduracao', 'like', "%{$data->musduracao}%"); // create the filter
            TSession::setValue('MusicaList_filter_musduracao',   $filter); // stores the filter in the session
        }


        if (isset($data->musdata) AND ($data->musdata)) {
            $filter = new TFilter('musdata', 'like', "%{$data->musdata}%"); // create the filter
            TSession::setValue('MusicaList_filter_musdata',   $filter); // stores the filter in the session
        }


        if (isset($data->musautor) AND ($data->musautor)) {

            TSession::setValue('MusicaList_filter_musautor',  $data->musautor); // stores the filter in the session
        }


        if (isset($data->artcodigo) AND ($data->artcodigo)) {
            $filter = new TFilter('artcodigo', '=', $data->artcodigo); // create the filter
            TSession::setValue('MusicaList_filter_artcodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->gencodigo) AND ($data->gencodigo)) {
            $filter = new TFilter('gencodigo', 'like', "%{$data->gencodigo}%"); // create the filter
            TSession::setValue('MusicaList_filter_gencodigo',   $filter); // stores the filter in the session
        }


        if (isset($data->musfaixa) AND ($data->musfaixa)) {
            $filter = new TFilter('musfaixa', 'like', "%{$data->musfaixa}%"); // create the filter
            TSession::setValue('MusicaList_filter_musfaixa',   $filter); // stores the filter in the session
        }
        
        
      
         
         if (isset($data->discodigo) AND ($data->discodigo)) {
            $filter = new TFilter('(SELECT discodigo FROM musica_disco where musica.muscodigo = musica_disco.muscodigo)', '=', $data->discodigo); // create the filter
            TSession::setValue('MusicaList_filter_musdisco',   $filter); // stores the filter in the session
         }
         
         if (isset($data->discodigo) AND ($data->discodigo)) {
            $filter = new TFilter('musbanda', '=', $data->discodigo); // create the filter
            TSession::setValue('MusicaList_filter_disco',   $filter); // stores the filter in the session
         }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Musica_filter_data', $data);
        
        $param=array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
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
            
            // creates a repository for Musica
            $repository = new TRepository('Musica');
            $limit = 15;
            // creates a criteria
            $criteria = new TCriteria;
            $artuser = (int)TSession::getValue('artuser');
            $tm = strlen($artuser);
            if ($artuser > 0){
                $criteria->add(new TFilter("SUBSTRING(musautor,1,$tm)",'=',$artuser));
                $tm += 1;
                $criteria->add(new TFilter("SUBSTRING(musautor,1,$tm)",'<=',$artuser));
                }

            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'musica.muscodigo';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('MusicaList_filter_muscodigo')) {
                $criteria->add(TSession::getValue('MusicaList_filter_muscodigo')); // add the session filter
            }


            if (TSession::getValue('MusicaList_filter_musnome')) {
                $criteria->add(TSession::getValue('MusicaList_filter_musnome')); // add the session filter
            }


            if (TSession::getValue('MusicaList_filter_musregistro')) {
                $criteria->add(TSession::getValue('MusicaList_filter_musregistro')); // add the session filter
            }


            if (TSession::getValue('MusicaList_filter_musduracao')) {
                $criteria->add(TSession::getValue('MusicaList_filter_musduracao')); // add the session filter
            }


            if (TSession::getValue('MusicaList_filter_musdata')) {
                $criteria->add(TSession::getValue('MusicaList_filter_musdata')); // add the session filter
            }


            if (TSession::getValue('MusicaList_filter_musautor')) {
                $artcodigo =  TSession::getValue('MusicaList_filter_musautor');
                $filter = new TFilter('musautor', '=', "{$artcodigo}"); // create the filter
                $criteria->add($filter,TExpression::OR_OPERATOR);
                $filter = new TFilter('musautor', 'like', "%{$artcodigo};%"); // create the filter
                $criteria->add($filter,TExpression::OR_OPERATOR);
            }


            if (TSession::getValue('MusicaList_filter_artcodigo')) {
                $criteria->add(TSession::getValue('MusicaList_filter_artcodigo')); // add the session filter
            }


            if (TSession::getValue('MusicaList_filter_gencodigo')) {
                $criteria->add(TSession::getValue('MusicaList_filter_gencodigo')); // add the session filter
            }


            if (TSession::getValue('MusicaList_filter_musfaixa')) {
                $criteria->add(TSession::getValue('MusicaList_filter_musfaixa')); // add the session filter
            }
            
            if (TSession::getValue('MusicaList_filter_disco')) {
                $criteria->add(TSession::getValue('MusicaList_filter_disco')); // add the session filter
            }

            
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            if (is_callable($this->transformCallback))
            {
                call_user_func($this->transformCallback, $objects, $param);
            }
            
            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
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
        // define the delete action
        $action = new TAction(array($this, 'Delete'));
        $action->setParameters($param); // pass the key parameter ahead
        
        // shows a dialog to the user
        new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);
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
            $object = new Musica($key, FALSE); // instantiates the Active Record
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
    



    
    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }
}
