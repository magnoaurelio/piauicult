<?php
/**
 * MusicaForm Form
 * @author  <your name here>
 */
class MusicaForm extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TQuickForm('form_Musica');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Musica');
        
        
        
        // create the form fields
        $muscodigo = new TEntry('muscodigo');
        $musnome = new TEntry('musnome');
        $musregistro = new TEntry('musregistro');
        $musaudio = new TFile('musaudio');
        $musletra = new TFile('musletra');
        $musvideo = new TEntry('musvideo');
        $musduracao = new TEntry('musduracao');
        $musdata = new TDate('musdata');
        $musautor =  new TDBCombo('musautor','conexao','Artista','artcodigo','{artusual}-{artcodigo}','artnome');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','{artusual}-{artcodigo}','artnome');
        $arttipocodigo = new TDBCombo('arttipocodigo','conexao','ArtistaTipo','arttipocodigo','{arttiponome}-{arttipocodigo}','arttiponome');
        $bancodigo = new \Adianti\Widget\Wrapper\TDBCombo('bancodigo','conexao','Banda','bancodigo','{bannome}','bannome');
        $gencodigo = new TDBCombo('gencodigo','conexao','Genero','gencodigo','{gennome}-{gencodigo}','gennome');
        $musfaixa = new TEntry('musfaixa');
        $musbanda = new TDBCombo('musbanda','conexao','Disco','discodigo','{disnome}-{discodigo}','disnome');
        $musativo = new TCombo('musativo');
        $livativo = new TCombo('livativo');
        $letativo = new TCombo('letativo');
        $vidativo = new TCombo('vidativo');
        $muslanca = new TCombo('muslanca');
        $mussobre = new THtmlEditor('mussobre');
        $musduracao->setProperty('type','time');
        
        $musbanda->enableSearch();
        $gencodigo->enableSearch();
        
        $musdata->setMask('dd/mm/yyyy');
        $mussobre->setSize('100%', 110);
        
        $data_now = date('dmYHis');
        $musativo->addItems(["S"=>"Sim", "N"=>"Não"]);
        $livativo->addItems(["S"=>"Sim", "N"=>"Não"]);
        $letativo->addItems(["S"=>"Sim", "N"=>"Não"]);
        $vidativo->addItems(["S"=>"Sim", "N"=>"Não"]);
        $muslanca->addItems(["S"=>"Sim", "N"=>"Não"]);
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'LETRA_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $musletra->setParametros('files/musicas/letra/',$nome_arquivo,$permite); 
        $nome_arquivo = 'AUDIO_'.$data_now.'_'.$getid;
        $permite = array('mp4','mp3','ogg','wav','wma');
        $musaudio->setParametros('files/musicas/audio/',$nome_arquivo,$permite, 32); 

        $bancodigo->enableSearch();
        
        // add the fields
        $this->form->addQuickField('Código', $muscodigo,  100 );
        $this->form->addQuickField('Nome', $musnome,  200 );
        $this->form->addQuickField('Registro', $musregistro,  200 );
        $this->form->addQuickField('Áudio', $musaudio,  300 );
        $this->form->addQuickField('Letra', $musletra,  300 );
        $this->form->addQuickField('Vídeo', $musvideo,  300 );
        $this->form->addQuickField('Duração', $musduracao,  200 );
        $this->form->addQuickField('Data', $musdata,  200 );
        //$this->form->addQuickField('Autor', $musautor,  300 );
        //$this->form->addQuickField('Artista', $artcodigo,  300 );
        $this->form->addQuickField('Gênero', $gencodigo,  300 );
        $this->form->addQuickField('Faixa', $musfaixa,  100 );
        $this->form->addQuickField('Disco', $musbanda,  400 );
       // $this->form->addQuickField('Tipo de Artista', $arttipocodigo,  400 );
        $this->form->addQuickField('Banda', $bancodigo,  400 );
        $this->form->addQuickField('Música(Ativo)', $musativo,  100 );
        $this->form->addQuickField('Livro(Ativo)', $livativo,  100 );
        $this->form->addQuickField('Letra(Ativo)', $letativo,  100 );
        $this->form->addQuickField('Vídeo(Ativo)', $vidativo,  100 );
        $this->form->addQuickField('Lançamento(Ativo)', $muslanca,  100 );
        $this->form->addQuickField('Sobre a Música', $mussobre,  '100%');
        
        
        
        
        if (!empty($muscodigo))
        {
            $muscodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
        
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
         $this->form->addQuickAction('Voltar',  new TAction(array('MusicaList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Música Form', $this->form));
        
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
            
            $object = new Musica;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data/carregue o objeto com dados
            $object->musdata  =  TDate::date2us($object->musdata);
            $object->store(); // save the object
            
            // get the generated muscodigo
            $data->muscodigo = $object->muscodigo;
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
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
                $object = new Musica($key); // instantiates the Active Record
                $object->musdata  =  TDate::date2br($object->musdata);
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}