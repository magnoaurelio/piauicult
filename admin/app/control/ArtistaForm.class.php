<?php
/**
 * ArtistaForm Form
 * @author  <your name here>
 */
class ArtistaForm extends TPage
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
        $this->form = new TQuickForm('form_Artista');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Artista');
        TScript::create(' 
             function BuscaID(str,id) {
              var pos1 = str.search("users/");
              var pos2 = str.search("&amp;");
              if(pos1 == -1){
               return;
              }
              var codigo = str.substring(pos1+6,pos2)
              $("#"+id).val(codigo);
            }
        ');


        // create the form fields
        $artcodigo = new TEntry('artcodigo');
        $artnome = new TEntry('artnome');
        $artusual = new TEntry('artusual');
        $artdatanasc = new TDate('artdatanasc');
        $artendereco = new TEntry('artendereco');
        $artbairro = new TEntry('artbairro');
        $artcep = new TEntry('artcep');
        $artuf = new TEntry('artuf');
        $artcidade = new TEntry('artcidade');
      //  $artvinculo = new \Adianti\Widget\Form\TCombo('artvinculo');
        $artvinculo = new TDBCombo('artvinculo','conexao','Prefeitura','precodigo','{prenome} - {precodigo}','prenome');
        $artcomplemento = new TEntry('artcomplemento');
        $artsexo = new TCombo('artsexo');
        $artfone = new TEntry('artfone');
        $artcelular = new TEntry('artcelular');
        $artemail = new TEntry('artemail');
        $artsite = new TEntry('artsite');
        $artfoto = new TFile('artfoto');
        $artbiografia = new THtmlEditor('artbiografia');
        $arttipocodigo = new TDBCombo('arttipocodigo','conexao','ArtistaTipo','arttipocodigo','arttiponome','arttiponome');
        $artcpf = new TEntry('artcpf');
        $artfacebook = new TEntry('artfacebook');
        $arttwitter = new TEntry('arttwitter');
        $artyuotube = new TEntry('artyuotube ');
        $artinstagram = new TEntry('artinstagram');
        $artgoogle = new TEntry('artgoogle');
        $artsound = new TEntry('artsound');
        $artsoundcloud = new TEntry('artsoundcloud');
        $artwhatsapp = new TEntry('artwhatsapp');
        
        $artsound->onblur = "BuscaID(this.value,this.id)";
    //    $artvinculo->addItems(DadosFixos::getPrefeituras());
        $artvinculo->enableSearch();
        
        $arttipocodigo->enableSearch();
      
        
        // mascara de acesso
        $artdatanasc->setMask("dd/mm/yyyy");
        $artcep->setMask('99999-999');
        $artcpf->setMask('999.999.999-99');
        $artuf->setMask("SS");  
        $artuf->setTip("Sigla do Estado (XX)");    
        $artsexo->addItems(["M"=>"Masculino", "F"=>"Feminino"]);
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        // incluir foto do ARTISTA
        $nome_arquivo = 'ART_'.$data_now;//.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $artfoto->setParametros('files/artistas/',$nome_arquivo,$permite); 
        $artbiografia->setSize('100%', 110);

        // add the fields
        $this->form->addQuickField('Código', $artcodigo,  100 );
        $this->form->addQuickField('Nome', $artnome,  400 );
        $this->form->addQuickField('Usual', $artusual,  200 );
        $this->form->addQuickField('Tipo de Artista', $arttipocodigo,  300 );
        $this->form->addQuickField('Dt.Nasc', $artdatanasc,  200 );
        $this->form->addQuickField('Endereço', $artendereco,  300 );
        $this->form->addQuickField('Bairro', $artbairro,  200 );
        $this->form->addQuickField('CEP', $artcep,  100 );
        $this->form->addQuickField('CPF', $artcpf,  100 );
        $this->form->addQuickField('UF', $artuf,  50 );
        $this->form->addQuickField('Cidade', $artcidade,  200 );
        $this->form->addQuickField('Cidade Vinculo', $artvinculo,  400 );
        $this->form->addQuickField('Complemento', $artcomplemento,  300 );
        $this->form->addQuickField('Sexo', $artsexo,  200 );
        $this->form->addQuickField('Fone', $artfone,  200 );
        $this->form->addQuickField('Celular', $artcelular,  200 );
        $this->form->addQuickField('Email', $artemail,  300 );
        $this->form->addQuickField('Site', $artsite,  300 );
        $this->form->addQuickField('Foto', $artfoto,  400 );
        $this->form->addQuickField('Pag. Facebook', $artfacebook,  '100%' );
        $this->form->addQuickField('Pag. Twitter', $arttwitter,  '100%' );
        $this->form->addQuickField('Pag. YuoTube', $artyuotube,  '100%' );
        $this->form->addQuickField('Pag. Instagram', $artinstagram,  '100%' );
        $this->form->addQuickField('Pag. whatsApp', $artwhatsapp,  '100%' );
        $this->form->addQuickField('Pag. Google', $artgoogle,  '100%' );
        $this->form->addQuickField('Pag. SoundCloud', $artsoundcloud,  '100%' );
        $this->form->addQuickField('Nº. SoundCloud', $artsound,  '100%' );
        
        $this->form->addQuickField('Biografia', $artbiografia,  '100%' );
        if (!empty($artcodigo))
        {
            $artcodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('ArtistaList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width:100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Artista Form', $this->form));

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
            
            $object = new Artista;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->artdatanasc  =  TDate::date2us($object->artdatanasc);
            $object->store(); // save the object
            
            // get the generated artcodigo
            $data->artcodigo = $object->artcodigo;
            
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
                $object = new Artista($key); // instantiates the Active Record
                $object->artdatanasc  =  TDate::date2br($object->artdatanasc);
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
