<?php
/**
 * DiscoForm Form
 * @author  <your name here>
 */
class DiscoForm extends TPage
{
    protected $form; // form
    protected $music_list;
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TQuickForm('form_Disco');
        $this->form->class = ''; // change CSS class
        $this->form->style = 'display: table;width:100%'; // change style
       // $this->form = new BootstrapFormWrapper($this->form);
        // define the form title
        $this->form->setFormTitle('Discos / Show(Apresentação)');


        // create the form fields
        $discodigo = new TEntry('discodigo');
        $disnome = new TEntry('disnome');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual}-{artcodigo}','artnome');
        $arttipocodigo = new TDBCombo('arttipocodigo','conexao','ArtistaTipo','arttipocodigo','arttiponome','arttiponome');
        $bancodigo = new \Adianti\Widget\Wrapper\TDBCombo('bancodigo','conexao','Banda','bancodigo','{bannome}-{bancodigo}','bannome');
        $disimagem = new TFile('disimagem');
        $disbolacha = new TFile('disbolacha');
        $disfrente = new TFile('disfrente');
        $disfundo = new TFile('disfundo');
        $disdata = new TDate('disdata');
        $disgravadora = new TEntry('disgravadora');
        $diseditoracao = new TEntry('diseditoracao');
        $dismix = new TEntry('dismix');
        $dismasterizacao = new TEntry('dismasterizacao');
        $dispreco = new TEntry('dispreco');
        $disquantidade = new TEntry('disquantidade');
        $dissobre = new THtmlEditor('dissobre');
        $dismostra  = new TRadioGroup('dismostra');
       
        $dismostra->setLayout('horizontal');
        $dismostra->setUseButton();
        $ops =  array(0=>"CD",1=>"SHOW");
        $dismostra->addItems($ops);
        
        $dissobre->setSize('100%', 110);
        $bancodigo->enableSearch();
        
         // create the form fields do FRAME;
        $muscodigo = new TDBSeekButton('muscodigo', 'conexao', 'form_Disco', 'Musica', 'musnome', 'muscodigo', 'musnome');
        $musnome = new TEntry('musnome');
        $muscodigo->setSize('50');
        $musnome->setSize('calc(100% - 200px)');
        $musnome->setEditable(FALSE);
        
        
        //PROJETO DADOS
        $procodigo = new TDBSeekButton('procodigo', 'conexao', 'form_Disco', 'Projeto', 'pronome', 'procodigo', 'pronome');
        $pronome = new TEntry('pronome');
        $procodigo->setSize('50');
        $pronome->setSize('300');
        $pronome->setEditable(FALSE);

        $disdata->setMask('dd/mm/yyyy');
        $button1 = new TButton('addartista');
        $button1->setAction(new TAction(array($this, 'onAddArtista')), 'Add Artista');
        $button1->setTip("Salve o disco antes de adicionar os artistas");
        $button1->setImage('fa:plus green fa-lg');
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'IMG_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $disimagem->setParametros('files/discos/',$nome_arquivo,$permite); 
        
        // add the fields
        $this->form->addQuickField('Código', $discodigo,  100 );
        $this->form->addQuickField('Nome', $disnome,  400 );
//        $this->form->addQuickField('Grupo', $bancodigo,  '100%' );
        $this->form->addQuickField('Mostragem', $dismostra,  250 );
        $this->form->addQuickField('Imagem', $disimagem,  400 );
        $this->form->addQuickField('Bolacha', $disbolacha,  400 );
        $this->form->addQuickField('Frente', $disfrente,  400 );
        $this->form->addQuickField('Fundo', $disfundo,  400 );
        $this->form->addQuickField('Data', $disdata,  200 );
        $this->form->addQuickField('Gravadora', $disgravadora,  400 );
        $this->form->addQuickField('Editoração', $diseditoracao,  400 );
        $this->form->addQuickField('Mixagem', $dismix,  400 );
        $this->form->addQuickField('Masterização', $dismasterizacao,  400 );
        $this->form->addQuickField('Preço', $dispreco,  400 );
        $this->form->addQuickField('Qte Disponível(Venda)', $disquantidade,  400 );
        $this->form->addQuickField('Sobre o Disco', $dissobre,  '100%' );
        $this->form->addQuickFields('Projeto',[$procodigo,$pronome]);
        

        $table = $this->form->getTable();
        $frame  = new TFrame;
        $frame->setLegend('Músicas');
        
        $this->music_list = new TQuickGrid();
        $this->music_list = new BootstrapDatagridWrapper($this->music_list);
        $this->music_list->setHeight(200);
        $this->music_list->makeScrollable();
        $this->music_list->style='width: 100%';
        $this->music_list->id = 'music_list';
        $this->music_list->disableDefaultClick();
        $this->music_list->addQuickColumn('', 'delete', 'center', '5%');
        $this->music_list->addQuickColumn('Código', 'muscodigo', 'left', '10%');
        $this->music_list->addQuickColumn('Nome', 'musnome', 'left', '85%');
        $this->music_list->createModel();
        
        $add_button  = TButton::create('add',  array($this,'onAddProgram'), _t('Add'), 'fa:plus green');
        
        $this->form->addField($muscodigo);
        $this->form->addField($musnome);
        $this->form->addField($add_button);
        
        $hbox = new THBox;
        $hbox->add($muscodigo);
        $hbox->add($musnome, 'display:initial');
        $hbox->add($add_button);
        $hbox->style = 'margin: 4px';

        $vbox = new TVBox;
        $vbox->style='width:100%';
        $vbox->add( $hbox );
        $vbox->add($this->music_list);
        $frame->add($vbox);
        

        
        $row=$table->addRow();
        $cell = $row->addCell( $frame);
        $cell->colspan= 2;

        if (!empty($discodigo))
        {
            $discodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('DiscoList', 'onReload')), 'fa:reply green');
        $this->form->addQuickAction('Limpar Musicas',  new TAction(array($this, 'onReset')), 'fa:trash red');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        $container->add(TPanelGroup::pack('Disco Cadastro', $this->form));
        parent::add($container);
    }
    
    
    
    function onAddArtista($param){
       
        if($param['discodigo'] == ""){
                new TMessage('warning','Salve o disco primeiramente');
           return;           
        }
        
         AdiantiCoreApplication::loadPage('DiscoArtistaList', 'onLoad', $param);
    
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
        try
        {
            TTransaction::open('conexao'); // open a transaction
            
            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/
            
            $this->form->validate(); // validate form data
            
            $object = new Disco;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->disdata  =  TDate::date2us($object->disdata);
            $object->clearParts();
            $musicas = TSession::getValue('music_list');
            if (!empty($musicas))
            {
                foreach ($musicas as $musica)
                {
                     $music = new Musica($musica['muscodigo']);
                     $object->addMusica($music);
                }
            }
             $object->store(); // save the object
            
            // get the generated discodigo
            $param['key'] = $object->discodigo;
            TTransaction::close(); // close the transaction
            $this->onEdit($param);
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(TRUE);
        TSession::setValue('music_list', null);
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('conexao'); // open a transaction
                $object = new Disco($key); // instantiates the Active Record
                $object->disdata  =  TDate::date2br($object->disdata);
                 $data = array();
                foreach ($object->getMusicas() as $musica)
                {
                    $data[$musica->muscodigo] = $musica->toArray();
                    $item = new stdClass;
                    $item->muscodigo = $musica->muscodigo;
                    $item->musnome = $musica->musnome;
                    
                    $i = new TElement('i');
                    $i->{'class'} = 'fa fa-trash red';
                    $btn = new TElement('a');
                    $btn->{'onclick'} = "__adianti_ajax_exec('class=DiscoForm&method=deleteMusic&id={$musica->muscodigo}');$(this).closest('tr').remove();";
                    $btn->{'class'} = 'btn btn-default btn-sm';
                    $btn->add( $i );
                    
                    $item->delete = $btn;
                    $tr = $this->music_list->addItem($item);
                    $tr->{'style'} = 'width: 100%;display: inline-table;';
                }               
                
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
                TSession::setValue('music_list', $data);
            }
            else
            {
                $this->form->clear(TRUE);
                 TSession::setValue('music_list', null);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
     public static function deleteMusic($param)
    {
        $musicas = TSession::getValue('music_list');
        unset($musicas[ $param['id'] ]);
        TSession::setValue('music_list', $musicas);
    }
    public static function onReset($param){
         TSession::delValue('music_list'); 
    }
    
    
    
     public static function onAddProgram($param)
    {
        try
        {
            $id = $param['muscodigo'];
            $music_list = TSession::getValue('music_list');
            
            if (!empty($id) AND empty($music_list[$id]))
            {
                TTransaction::open('conexao');
                $musica = Musica::find($id);
                $music_list[$id] = $musica->toArray();
                TSession::setValue('music_list', $music_list);
                TTransaction::close();
                
                $i = new TElement('i');
                $i->{'class'} = 'fa fa-trash red';
                $btn = new TElement('a');
                $btn->{'onclick'} = "__adianti_ajax_exec(\'class=DiscoForm&method=deleteMusic&id=$id\');$(this).closest(\'tr\').remove();";
                $btn->{'class'} = 'btn btn-default btn-sm';
                $btn->add($i);
                
                $tr = new TTableRow;
                $tr->{'class'} = 'tdatagrid_row_odd';
                $tr->{'style'} = 'width: 100%;display: inline-table;';
                $cell = $tr->addCell( $btn );
                $cell->{'style'}='text-align:center';
                $cell->{'class'}='tdatagrid_cell';
                $cell->{'width'} = '5%';
                $cell = $tr->addCell( $musica->muscodigo );
                $cell->{'class'}='tdatagrid_cell';
                $cell->{'width'} = '10%';
                $cell = $tr->addCell( $musica->musnome );
                $cell->{'class'}='tdatagrid_cell';
                $cell->{'width'} = '85%';
                
                TScript::create("tdatagrid_add_serialized_row('music_list', '$tr');");
                
                $data = new stdClass;
                $data->muscodigo = '';
                $data->musnome = '';
                TForm::sendData('form_Disco', $data);
            }
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
}
