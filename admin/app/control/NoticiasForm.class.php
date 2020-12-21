<?php
/**
 * NoticiasForm Form
 * @author  <your name here>
 */
class NoticiasForm extends TPage
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
        $this->form = new TQuickForm('form_Noticias');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Noticias');
        


        // create the form fields
        $notid = new TEntry('notid');
        $nottitulo = new TEntry('nottitulo');
        $notfoto = new TFile('notfoto');
        $notfoto1 = new TFile('notfoto1');
        $notfoto2 = new TFile('notfoto2');
        $notfoto3 = new TFile('notfoto3');
        $notfoto4 = new TFile('notfoto4');
        $notfoto5 = new TFile('notfoto5');
        $notfoto6 = new TFile('notfoto6');
        $notnoticia = new THtmlEditor('notnoticia');
        $notdata = new TDate('notdata');
        $artistas = new \Adianti\Widget\Wrapper\TDBMultiSearch('artistas','conexao','Artista','artcodigo','artusual','artusual');
        $notvisita = new TEntry('notvisita');
        $nottipo = new TEntry('nottipo');
        $notestado = new TEntry('notestado');
        $notinclui = new TEntry('notinclui');
        $notaltera = new TEntry('notaltera');
        $notexclui = new TEntry('notexclui');
        $notmesano = new TEntry('notmesano');
        $usuid = new TEntry('usuid');
        $home = new TCombo('home');
        $home->addItems([1=>"Sim",0=>"Não"]);
        $usuid->setEditable(false);
        $usuid->setValue(TSession::getValue('userid'));
        
        $data_now = date('dmYHis');
        $notdata->setMask("dd/mm/yyyy");
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'FOTO_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $notfoto->setParametros('files/noticias/','0'.$nome_arquivo,$permite); 
        $notfoto1->setParametros('files/noticias/','1'.$nome_arquivo,$permite); 
        $notfoto2->setParametros('files/noticias/','2'.$nome_arquivo,$permite); 
        $notfoto3->setParametros('files/noticias/','3'.$nome_arquivo,$permite); 
        $notfoto4->setParametros('files/noticias/','4'.$nome_arquivo,$permite); 
        $notfoto5->setParametros('files/noticias/','5'.$nome_arquivo,$permite); 
        $notfoto6->setParametros('files/noticias/','6'.$nome_arquivo,$permite); 


        $artistas->setMinLength(1);
        $artistas->setMask("{artusual}");

        // add the fields
        $this->form->addQuickField('Código', $notid,  100 );
        $this->form->addQuickField('Título', $nottitulo,  '100%' );
        $this->form->addQuickField('Foto Principal', $notfoto,  300 );
        $this->form->addQuickField('1ª Foto', $notfoto1,  300 );
        $this->form->addQuickField('2ª Foto', $notfoto2,  300 );
        $this->form->addQuickField('3ª Foto', $notfoto3,  300 );
        $this->form->addQuickField('4ª Foto', $notfoto4,  300 );
        $this->form->addQuickField('5ª Foto', $notfoto5,  300 );
        $this->form->addQuickField('6ª Foto', $notfoto6,  300 );
        $this->form->addQuickField('Texto', $notnoticia,  '100%' );
        $this->form->addQuickField('Data', $notdata,  200 );
        $this->form->addQuickField('Artistas', $artistas,  '100%' );
        // $this->form->addQuickField('Notvisita', $notvisita,  100 );
        // $this->form->addQuickField('Nottipo', $nottipo,  200 );
        // $this->form->addQuickField('Notestado', $notestado,  200 );
        // $this->form->addQuickField('Notinclui', $notinclui,  200 );
        // $this->form->addQuickField('Notaltera', $notaltera,  200 );
        // $this->form->addQuickField('Notexclui', $notexclui,  200 );
        // $this->form->addQuickField('Notmesano', $notmesano,  200 );
        $this->form->addQuickField('Usuário', $usuid,  100 );
        $this->form->addQuickField('Home', $home,  100 );




        if (!empty($notid))
        {
            $notid->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('NoticiasList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Notícia Form', $this->form));
        
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
            
            $object = new Noticias;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->store();
            $object->setArtistas(Artista::parseIds($param["artistas"]));
            
            // get the generated notid
            $data->notid = $object->notid;
            
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
                $object = new Noticias($key); // instantiates the Active Record
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
