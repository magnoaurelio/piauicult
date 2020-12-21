<?php
/**
 * DiscoForm Form
 * @author  <your name here>
 */
class ProgramacaoForm extends TPage
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
        $this->form = new TQuickForm('form_Programacao');
        $this->form->class = ''; // change CSS class
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title



        // create the form fields
        $procodigo = new TEntry('procodigo');
        $emicodigo = new TDBCombo('emicodigo','conexao','Emissora','emicodigo','eminome','eminome');
        $dataplay = new TDate('dataplay');
        $apresentador = new TDBCombo('aprcodigo','conexao','Apresentador','aprcodigo','aprnome','aprnome');
        $detalhe = new THtmlEditor('detalhe');
        
        $apresentador->enableSearch();
        $emicodigo->enableSearch();
        
        $dataplay->setMask('dd/mm/yyyy');
        
         // create the form fields do FRAME;
        $muscodigo = new TDBSeekButton('muscodigo', 'conexao', 'form_Programacao', 'Musica', 'musnome', 'muscodigo', 'musnome');
        $musnome = new TEntry('musnome');
        $muscodigo->setSize('50');
        $musnome->setSize('calc(100% - 200px)');
        $musnome->setEditable(FALSE);
        
        
        // add the fields
        $this->form->addQuickField('Código', $procodigo,  100 );
        $this->form->addQuickField('Emissora', $emicodigo,  400 );
        $this->form->addQuickField('Data', $dataplay,  200 );
        $this->form->addQuickField('Apresentador', $apresentador,  300 );
        $this->form->addQuickField('Detalhe', $detalhe,  '100%' );
        
        
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
        $this->form->addQuickAction('Voltar',  new TAction(array('ProgramacaoList', 'onReload')), 'fa:reply green');
        $this->form->addQuickAction('Limpar Musicas',  new TAction(array($this, 'onReset')), 'fa:trash red');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Programação', $this->form));
        parent::add($container);
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
            
            $object = new Programacao;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->dataplay  =  TDate::date2us($object->dataplay);
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
                $object = new Programacao($key); // instantiates the Active Record
                $object->dataplay  =  TDate::date2br($object->dataplay);
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
                    $btn->{'onclick'} = "__adianti_ajax_exec('class=ProgramacaoForm&method=deleteMusic&id={$musica->muscodigo}');$(this).closest('tr').remove();";
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
                $btn->{'onclick'} = "__adianti_ajax_exec(\'class=ProgramacaoForm&method=deleteMusic&id=$id\');$(this).closest(\'tr\').remove();";
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
