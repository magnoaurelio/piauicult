<?php
/**
 * PrefeitoList Listing
 * @author  <your name here>
 */
class PrefeitoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $formgrid;
    private $loaded;
    private $deleteButton;
    private $ativo = null;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TQuickForm('form_search_Prefeito');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('Prefeito - Vice');
        

        // create the form fields
       
        $criteria =  new TCriteria;
        $criteria->add(new \Adianti\Database\TFilter("codigoUnidGestora","<", 101999 ));
        $camara = new TDBCombo('camara','conexao','Prefeitura','precodigo','{precodigo}-{prenome}','prenome',$criteria);

        $criteria =  new TCriteria;
        $criteria->add(new \Adianti\Database\TFilter("codigoUnidGestora",">", 200000 ));
        $precodigo = new TDBCombo('precodigo','conexao','Prefeitura','precodigo','{precodigo}-{prenome}','prenome',$criteria);
        $codigoUnidGestora = new TDBCombo('precodigo','conexao','Prefeitura','precodigo','precodigo','precodigo',$criteria);
        

        $pretipo = new TCombo('pretipo');
        $prenumero = new TEntry('prenumero');
        $prefotop = new TEntry('prefotop');
        $etiop = new TCombo("preampar");
        $etiop->addItems(["ampar"=>"AMPAR","appm"=>"APPM","ampicos"=>"AMPICOS","piaui"=>"PIAUI"]);
       
       
        
        $pretipo->addItems(['Prefeito','Vice']);
       
       
        // add the fields
        $this->form->addQuickField('Código', $prenumero,  100 );
        $this->form->addQuickField('Câmara', $camara,  200 );
        $this->form->addQuickField('Cidade', $precodigo,  200 );
        $this->form->addQuickField('Tipo', $pretipo,  200 );
        $this->form->addQuickField('Associação', $etiop,  200 );
        

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Prefeito_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onNovo')), 'bs:plus-sign green');
        $this->form->addQuickAction('Limpar Filtros',  new TAction(array($this, 'onLimparFiltros')), 'bs:filter red');
        
        $save = new TButton('save');
        $save->setImage('fa:circle blue fa-lg');
               
        $gridpack = new TVBox;
        $table = new TTable;
        $table->addRowSet("<b>Legenda:</b>",$save," <b>-</b> Ativa e Inativa (Prefeito-Vice)");
        $gridpack->style = "width:100%; background:whiteSmoke;border:1px solid #cccccc; padding: 3px;padding: 5px;";
        $gridpack->add($table);
        $this->form->add(TElement::tag('br',''));
        $this->form->add($gridpack);
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
       
        

        // creates the datagrid columns
        $column_prenumero = new TDataGridColumn('prenumero', 'COD', 'right');
        $column_precodigo = new TDataGridColumn('Cidade', 'CIDADE', 'left');
        $column_pretipo = new TDataGridColumn('Tipo', 'TIPO', 'right');
        $column_preescola = new TDataGridColumn('Escolaridade', 'ESCOLARIDADE', 'right');
        $column_preendereco = new TDataGridColumn('preendereco', 'ENDEREÇO', 'left');
        $column_precep = new TDataGridColumn('precep', 'CEP', 'left');
        $column_prebairro = new TDataGridColumn('prebairro', 'BAIRRO', 'left');
        $column_preemail = new TDataGridColumn('preemail', 'EMAIL', 'left');
        $column_preapep = new TDataGridColumn('preapep', 'USUAL', 'left');
        $column_prenomep = new TDataGridColumn('prenomep', 'NOME', 'left');
        $column_prefotop = new TDataGridColumn('prefotop', 'FOTO', 'left');
        $column_prepartidop = new TDataGridColumn('prepartidop', 'PARTIDO', 'left');
        $column_pretitulo = new TDataGridColumn('pretitulo', 'TITULO ELEITOR', 'left');
        $column_precpf = new TDataGridColumn('precpf', 'CPF', 'left');
        $column_preddd = new TDataGridColumn('preddd', 'DDD', 'left');
        $column_prefone = new TDataGridColumn('prefone', 'FONE', 'left');
        $column_precelular = new TDataGridColumn('precelular', 'CELULAR', 'left');
        $column_precivil = new TDataGridColumn('EstadoCivil', 'ESTADO CIVIL', 'right');
        $column_historico = new TDataGridColumn('historico', 'HISTÓRICO', 'left');
        $column_preniverp = new TDataGridColumn('preniverp', 'DATA ANIVERSÁRIO', 'left');
        $column_presexop = new TDataGridColumn('presexop', 'GÊNERO', 'left');
        $column_preconjuge = new TDataGridColumn('preconjuge', 'CÔNJUGE', 'left');
        $column_preconusual = new TDataGridColumn('preconusual', 'CÔNJUGE USUAL', 'left');
        $column_preniverc = new TDataGridColumn('preniverc', 'DATA NASCIMENTO  CONJUGE', 'left');
        $column_presexoc = new TDataGridColumn('presexoc', 'GÊNERO CÔNJUGE', 'left');
        $column_precelulac = new TDataGridColumn('precelulac', 'CELULAR CÔNJUGE', 'left');
        $column_prefotoc = new TDataGridColumn('prefotoc', 'FOTO CONJUGE', 'left');
        $column_preperiodo = new TDataGridColumn('preperiodo', 'Período', 'left');
        
      //  $num = str_pad($codigoUnidGestora, 3, '0', STR_PAD_LEFT);  
     //   var_dump($num);
      //  $codigoUnidGestora = Prefeitura->codigoUndiadeGestora;
        $column_prefotop->setTransformer( function($value, $object, $row) {
        $img = "files/prefeituras/201001/".$value;
       //  var_dump($img);
            if (file_exists($img)) {
                $foto  = new TElement('img');
                $foto->style= "width:90px; height:80px;";
                $foto->src  = $img;
                return $foto;
            }else{
                return $value;
            }
        });
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_prenumero);
        $this->datagrid->addColumn($column_precodigo); // NOME DA CIDADE
        $this->datagrid->addColumn($column_prenomep); // NOME DO PREFEITO
        $this->datagrid->addColumn($column_pretipo);  // TIPO  0 - PREFEITO 1- VICE
        $this->datagrid->addColumn($column_prefotop); // foto do prefeito
        $this->datagrid->addColumn($column_preescola); //  ESCOLARIDADE
        $this->datagrid->addColumn($column_preendereco);
        $this->datagrid->addColumn($column_precep);
        $this->datagrid->addColumn($column_prebairro);
        $this->datagrid->addColumn($column_preemail);
        $this->datagrid->addColumn($column_preapep);
        $this->datagrid->addColumn($column_prepartidop);
        $this->datagrid->addColumn($column_pretitulo);
        $this->datagrid->addColumn($column_precpf);
        $this->datagrid->addColumn($column_preddd);
        $this->datagrid->addColumn($column_prefone);
        $this->datagrid->addColumn($column_precelular);
        $this->datagrid->addColumn($column_precivil);
        $this->datagrid->addColumn($column_historico);
        $this->datagrid->addColumn($column_preniverp);
        $this->datagrid->addColumn($column_presexop);
        $this->datagrid->addColumn($column_preconjuge);
        $this->datagrid->addColumn($column_preconusual);
        $this->datagrid->addColumn($column_preniverc);
        $this->datagrid->addColumn($column_presexoc);
        $this->datagrid->addColumn($column_precelulac);
        $this->datagrid->addColumn($column_prefotoc);
        $this->datagrid->addColumn($column_preperiodo);
        
      
         $column_prenumero->setTransformer( function($value, $object, $row) {
           $icon = new \Adianti\Widget\Base\TElement('span');
           $icon->class = "fa fa-circle";
           $icon->add("&nbsp;");
           $icon->add($value);
           if($object->preativo):
               $this->ativo = "green";
               $icon->style = "color:green";
           else:
               $this->ativo = "red";
               $icon->style = "color:red";
           endif;
           return $icon;
        });

        
        // create EDIT action
        $action_edit = new TDataGridAction(array($this, 'onEdit'));
        $action_edit->setUseButton(TRUE);
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(_t('Edit'));
        $action_edit->setImage('fa:pencil-square-o blue fa-lg');
        $action_edit->setField('prenumero');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onAtivar'));
        $action_del->setUseButton(TRUE);
        $action_del->setButtonClass('btn btn-default');
        $action_del->setImage('fa:circle  fa-lg blue');
        $action_del->setField('prenumero');
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
        $container->add(TPanelGroup::pack('Listagem de Prefeitos', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    
    public function onNovo( $param )
    {
        $form = new TQuickForm('input_form');
        $form->style = 'padding:20px';

        $criteria =  new TCriteria;
         if(!strripos(TSession::getValue('usergroupids'),'1') && !empty(TSession::getValue('setcidade')))
        $criteria->add(new TFilter('precodigo','=',TSession::getValue('setcidade')));


        $precodigo = new TDBCombo('precodigo','conexao','Prefeitura','precodigo','{codigoUnidGestora} - {prenome}','prenome',$criteria);
        
        $form->addQuickField('Cidade', $precodigo);        

        $form->addQuickAction('Adicionar', new TAction(array($this, 'onNew')), 'fa:accept  fa-lg green');
        
        // show the input dialog
        new TInputDialog('Novo-Cidade', $form);
    }
    
    public function onNew( $param )
    {
      if(!empty($param['precodigo'])){
       TSession::setValue('setPrefeitura',$param['precodigo']);
        TApplication::LoadPage('PrefeitoForm','onEdit');
      }else{
        new TMessage('warning','Escolha a cidade!');
      }
    }
    
     public function onEdit( $param )
    {
      
      try{
       TTransaction::open('conexao');
       $pref  = new Prefeito($param['prenumero']);
        TSession::setValue('setPrefeitura',$pref->precodigo);
        TApplication::LoadPage('PrefeitoForm','onEdit',$param);
       TTransaction::close();     
      }catch(Exception $e){
       new TMessage('warning',$e->getMessage());
      }
      
      

      
    }
    
    
    
    
    
     function onAtivar($param)
    {
        $action = new TAction(array($this, 'okAtivar'));
        $action2 = new TAction(array($this, 'okBloquear'));
        $action->setParameters($param); // pass the key parameter ahead
        $action2->setParameters($param); // pass the key parameter ahead
        TTransaction::open('conexao');
        $object = new Prefeito($param['key']);
        TTransaction::close();

        // shows a dialog to the user
        new TQuestion('Deseja Ativar este '.DadosFixos::Pretipo($object->pretipo).'? <h4>Sim: Ativo Não: Inativo</h4>',$action, $action2);
    }
    
    function okAtivar($param){
      try
        {
            if (isset($param['key']))
            {
                // get the parameter $key
                $key=$param['key'];

                TTransaction::open('conexao');
                $object = new Prefeito($key);

                $repo = new TRepository('Prefeito');
                $criteria = new TCriteria;
                $criteria->add(new TFilter("precodigo","=",$object->precodigo));
                $criteria->add(new TFilter("pretipo","=",$object->pretipo));
                $prefs = $repo->load($criteria);
                if($prefs):
                  foreach($prefs as $value):
                     $prefeito = new Prefeito($value->prenumero);
                     $prefeito->preativo = 0;
                     $prefeito->store();
                  endforeach;
                endif;
                TTransaction::close();
                TTransaction::open('conexao');
                $object->preativo = 1;
                $object->store();
                TTransaction::close();
                 $this->onReload();
                    new TMessage('info', DadosFixos::Pretipo($object->pretipo).' Ativado!');

            }
           
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('warning',$e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
      
   }
   
   function okBloquear($param){
      try
        {
            if (isset($param['key']))
            {
                // get the parameter $key
                $key=$param['key'];
                
                // open a transaction with database 'conexao'
                TTransaction::open('conexao');
                
                $object = new Prefeito($key);
                $repo = new TRepository('Prefeito');
                $criteria = new TCriteria;
                $criteria->add(new TFilter("precodigo","=",$object->precodigo));
                $criteria->add(new TFilter("pretipo","=",$object->pretipo));
                $prefs = $repo->count($criteria);
                if($prefs==1):
                   throw new Exception('Não foi possível inativar: Apenas um '.DadosFixos::Pretipo($object->pretipo).' ativo!');
                endif;           
                $object->preativo = 0;
                $object->store();
                TTransaction::close();
                 $this->onReload();
                    new TMessage('success','Prefeito Inativado!');

            }
           
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('warning',$e->getMessage());
            
            // undo all pending operations
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
            $object = new Prefeito($key); // instantiates the Active Record
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
    
    function onLimparFiltros(){
        TSession::setValue('PrefeitoList_filter_precodigo',   NULL);
        TSession::setValue('PrefeitoList_filter_pretipo',   NULL);
        $this->onReload();
    }
    
    
    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue('PrefeitoList_filter_precodigo',   NULL);
        TSession::setValue('PrefeitoList_filter_pretipo',   NULL);
        TSession::setValue('PrefeitoList_filter_preampar',   NULL);
        TSession::setValue('PrefeitoList_filter_prenumero',   NULL);

        if (isset($data->precodigo) AND ($data->precodigo) OR (isset($data->camara) AND ($data->camara))) {
            $codigo =  $data->precodigo ? $data->precodigo : $data->camara;
            $filter = new TFilter('precodigo', 'like', "%{$codigo}%"); // create the filter
            TSession::setValue('PrefeitoList_filter_precodigo',   $filter); // stores the filter in the session
        }

        
         if (isset($data->preampar) AND ($data->preampar)) {
            $filter = new TFilter('(SELECT preampar FROM prefeitura WHERE prefeitura.precodigo = prefeito.precodigo)', '=', $data->preampar); // create the filter
            TSession::setValue('PrefeitoList_filter_preampar',   $filter); // stores the filter in the session
        }
        
         if (isset($data->prenumero) AND ($data->prenumero)) {
            $filter = new TFilter('prenumero', '=', $data->prenumero); // create the filter
            TSession::setValue('PrefeitoList_filter_prenumero',   $filter); // stores the filter in the session
        }


        if (isset($data->pretipo)) {
            
            if($data->pretipo == 0){
               $filter = new TFilter('pretipo', '<', 1); // create the filter 
            }else{
              $filter = new TFilter('pretipo', '=', 1); // create the filter
            }
          
            TSession::setValue('PrefeitoList_filter_pretipo',   $filter); // stores the filter in the session
        }

        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue('Prefeito_filter_data', $data);
        
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
            
            // creates a repository for Prefeito
            $repository = new TRepository('Prefeito');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;

            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'prenumero';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue('PrefeitoList_filter_precodigo')) {
                $criteria->add(TSession::getValue('PrefeitoList_filter_precodigo')); // add the session filter
            }


            if (TSession::getValue('PrefeitoList_filter_pretipo')) {
                $criteria->add(TSession::getValue('PrefeitoList_filter_pretipo')); // add the session filter
            }
           
           
            if (TSession::getValue('PrefeitoList_filter_prenumero')) {
                $criteria->add(TSession::getValue('PrefeitoList_filter_prenumero')); // add the session filter
            }


            if (TSession::getValue('PrefeitoList_filter_preampar')) {
                $criteria->add(TSession::getValue('PrefeitoList_filter_preampar')); // add the session filter
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
            $object = new Prefeito($key, FALSE); // instantiates the Active Record
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
