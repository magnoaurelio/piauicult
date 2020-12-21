<?php
/**
 * EventosForm Form
 * @author  <your name here>
 */
class EventosForm extends TPage
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
        $this->form = new TQuickForm('form_Eventos');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Eventos Diversos');
        


        // create the form fields
        $evecodigo = new TEntry('evecodigo');
        $evetipo = new TDBCombo('evetipo','conexao','EventosTipo','evetipocodigo',['evetiponome']);
        $evenome = new TEntry('evenome');
        $evedata = new TDate('evedata');
        $evehorario = new TEntry('evehorario');
        $evedetalhe = new THtmlEditor('evedetalhe');
        $artistas = new \Adianti\Widget\Wrapper\TDBMultiSearch('artistas','conexao','Artista','artcodigo','artusual','artusual');
        $discodigo = new TDBCombo('discodigo','conexao','Disco','discodigo','disnome','disnome');
        $eveimagem1 = new TFile('eveimagem1');
        $eveimagem2 = new TFile('eveimagem2');
        $eveimagem3 = new TFile('eveimagem3');
        $eveimagem4 = new TFile('eveimagem4');
        $eveimagem5 = new TFile('eveimagem5');
        $eveimagem6 = new TFile('eveimagem6');
        $evelocal = new TDBCombo('evelocal','conexao','EventosLocal','loccodigo',['locnome']);
        $evehome  = new TRadioGroup('evehome');
       
        $evehome->setLayout('horizontal');
        $evehome->setUseButton();
        $ops =  array(0=>"SIM",1=>"NÃO");
        $evehome->addItems($ops);


        $artistas->setMinLength(1);
        $artistas->setMask("{artusual}");
        

        $evedata->setMask('dd/mm/yyyy');
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        // incluir foto do ARTISTA
        $nome_arquivo = $data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $eveimagem1->setParametros('files/eventos/',"IMG_01_".$nome_arquivo,$permite);
        $eveimagem2->setParametros('files/eventos/',"IMG_02_".$nome_arquivo,$permite);
        $eveimagem3->setParametros('files/eventos/',"IMG_03_".$nome_arquivo,$permite);
        $eveimagem4->setParametros('files/eventos/',"IMG_04_".$nome_arquivo,$permite);
        $eveimagem5->setParametros('files/eventos/',"IMG_05_".$nome_arquivo,$permite);
        $eveimagem6->setParametros('files/eventos/',"IMG_06_".$nome_arquivo,$permite);
        
         //PROJETO DADOS
        $procodigo = new TDBSeekButton('procodigo', 'conexao', 'form_Eventos', 'Projeto', 'pronome', 'procodigo', 'pronome');
        $pronome = new TEntry('pronome');
        $procodigo->setSize('50');
        $pronome->setSize('300');
        $pronome->setEditable(FALSE);
        
        $discodigo->enableSearch();

        // add the fields
        $this->form->addQuickField('Evecodigo', $evecodigo,  100 );
        $this->form->addQuickFields('Projeto',[$procodigo,$pronome]);
        $this->form->addQuickField('Tipo', $evetipo,  200 );
        $this->form->addQuickField('Nome', $evenome,  400 );
        $this->form->addQuickField('Data', $evedata,  100 );
        $this->form->addQuickField('Horário', $evehorario,  200 );
        $this->form->addQuickField('Local', $evelocal,  250 );
        $this->form->addQuickField('Artistas', $artistas,  '100%' );
        $this->form->addQuickField('Disco', $discodigo,  300 );
        $this->form->addQuickField('Home', $evehome,  250 );
        $this->form->addQuickField('Imagem 1', $eveimagem1,  300 );
        $this->form->addQuickField('Imagem 2', $eveimagem2,  300 );
        $this->form->addQuickField('Imagem 3', $eveimagem3,  300 );
        $this->form->addQuickField('Imagem 4', $eveimagem4,  300 );
        $this->form->addQuickField('Imagem 5', $eveimagem5,  300 );
        $this->form->addQuickField('Imagem 6', $eveimagem6,  300 );
        $this->form->addQuickField('Detalhes', $evedetalhe,  '100%' );
      




        if (!empty($evecodigo))
        {
            $evecodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('EventosList', 'onReload')), 'fa:reply green');
       // $this->form->addQuickAction("Voltar",  new TAction(array('EventosList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Evento Form', $this->form));
        
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
            $object = new Eventos;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->evedata =  TDate::date2us($object->evedata);
            //var_dump($object);
            $object->store(); // save the object
            $object->setArtistas(Artista::parseIds($param["artistas"]));
            
            // get the generated evecodigo
            $data->evecodigo = $object->evecodigo;
            
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
                $object = new Eventos($key); // instantiates the Active Record
                $object->evedata  = TDate::date2br($object->evedata);
                $object->pronome  = Projeto::find($object->procodigo)->pronome;
                $object->artistas = Artista::parseIds($object->getArtistas(), true);
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
