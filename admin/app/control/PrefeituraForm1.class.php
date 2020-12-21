<?php
/**
 * PrefeituraForm Form
 * @author  <your name here>
 */
class PrefeituraForm extends TPage
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
        $this->form = new TQuickForm('form_Prefeitura');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        
        $this->form->style = 'margin:0px; width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Prefeitura');
        echo "<style>";
        echo " label{text-align:right; width:100px; font-weight: normal; font-size: 12px;}";
        echo "</style>";


        // create the form fields
        $precodigo = new TEntry('precodigo');
        $preorgao = new TEntry('preorgao');
        $preslogan = new TEntry('preslogan');
        $prehorario = new TEntry('prehorario');
        $prepopulacao = new TEntry('prepopulacao');
        $preeleitor = new TEntry('preeleitor');
        $precidade = new TEntry('precidade');
        $preibge = new TEntry('preibge');
        $unidadeGestora    = new \Adianti\Widget\Wrapper\TDBCombo('codigoUnidGestora','conexao','UnidadeGestora','codigoUnidGestora','descricao');
        $premapa = new TFile('premapa');
        $preclima = new TEntry('preclima');
        $preendereco = new TEntry('preendereco');
        $precep = new TEntry('precep');
        $prebairro = new TEntry('prebairro');
        $preemail = new TEntry('preemail');
        $presite = new TEntry('presite');
        $preapep = new TEntry('preapep');
        $preapev = new TEntry('preapev');
      //  $prepartidov = new TDBCombo('prepartidov','conexao','Partido','parcodigo','parnome');
        $prenomep = new TEntry('prenomep');
        $prefotop = new TFile('prefotop');
        $prenomev = new TEntry('prenomev');
        $prefotov = new TFile('prefotov');
     //   $prepartidop =  new TDBCombo('prepartidop','conexao','Partido','parcodigo','parnome');
        //$padcodigo =  new TDBCombo('padcodigo','conexao','Padroeiro','padcodigo','padnome');
        $prenome = new TEntry('prenome');
        $precnpj = new TEntry('precnpj');
        $preimagem = new \Adianti\Widget\Form\TFile('preimagem');
        $prelogo = new \Adianti\Widget\Form\TFile('prelogo');
        $prebrasao = new \Adianti\Widget\Form\TFile('prebrasao');
        $prebandeira = new \Adianti\Widget\Form\TFile('prebandeira');
        $preniverp = new TDate('preniverp');
        $preniverv = new TDate('preniverv');
        $predata = new TDate('predata');
        $preddd = new TEntry('preddd');
        $prefone = new TEntry('prefone');
        $prefax = new TEntry('prefax');
        $prefoto = new TFile('prefoto');
        $pretema = new \Adianti\Widget\Form\TCombo('pretema');
        $preampar = new TEntry('preampar');
        $criteria = new TCriteria;
        $criteria->add(new TFilter('preativo','=',1));
        $criteria->add(new TFilter('pretipo','=',0));
    //    $pretesouro = new TDBSeekButton('pretesouro','conexao','form_Prefeitura','Prefeito','prenomep','pretesouro','pretesouronome',$criteria);
        $pretesouronome = new TEntry('pretesouronome');
        $preamparlogo = new TFile('preamparlogo');
        $prech = new TCombo('prech');
        $concheque = new TCombo('concheque');
        $preiptu = new TCombo('preiptu');
        $prelicenca = new TCombo('prelicenca');
        $historico  = new THtmlEditor('historico');
        $prehino  = new THtmlEditor('prehino');
        

        $historico->setSize('100%');
        $prehino->setSize('100%');
        $pretesouro->setSize(50);
        $preniverp->setSize(170);
        $preniverv->setSize(170);
        $predata->setSize(170);
        $prefotov->setSize('100%');
        $prefotop->setSize('100%');
        $predata->setMask('dd/mm/yyyy');

        $pretema->addItems(DadosFixos::getColor());

        $unidadeGestora->addValidation('Unidade Gestora', new \Adianti\Validator\TRequiredValidator());


        
        $prech->addItems(['NÃO','SIM']);
        $concheque->addItems(['NÃO','SIM']);
        $preiptu->addItems(['NÃO','SIM']);
        $prelicenca->addItems(['NÃO','SIM']);

        $unidadeGestora->addValidation('Unidade Gestora', new \Adianti\Validator\TRequiredValidator);


        $prelogo->setAllowedExtensions(DadosFixos::extensaoImagem());
        $preimagem->setAllowedExtensions(DadosFixos::extensaoImagem());
        $prebrasao->setAllowedExtensions(DadosFixos::extensaoImagem());
        $prebandeira->setAllowedExtensions(DadosFixos::extensaoImagem());


        // add the fields
        $this->form->addQuickFields('',[new TLabel('<em style="color:#34568e; font-weight: bold ">MUNICÍPIO_______________________________________________________________________________________________</em>')]);
        $this->form->addQuickFields('Código:',
               [
                new TLabel('Código: ')     ,$precodigo,
                new TLabel('Município ')   ,$prenome  ,
                new TLabel('(pre)Cidade: '),$precidade 
               ]);
        $this->form->addQuickFields('',[new TLabel('CNPJ: ')         ,$precnpj  ,new TLabel('Cor: '), $pretema,new TLabel('Fundação: ')    ,$predata]);
        $this->form->addQuickFields('',[new TLabel('Logo Adminis.: '),$prelogo  ,new TLabel('Brasão: ')         ,$prebrasao   ,new TLabel('Bandeira: ') ,$prebandeira]);
        $this->form->addQuickFields('',[new TLabel('Cd. Clima: ')    ,$preclima,new TLabel('E-mail: ')         ,$preemail    ,new TLabel('Site: ')     ,$presite]);
        $this->form->addQuickFields('',[new TLabel('Banner Pref: ')  ,$prefoto ,new TLabel('Imagem: ')         ,$preimagem   ,new TLabel('Mapa: '),$premapa]);
        $this->form->addQuickFields('',[new TLabel('Cd. IBGE: ')     ,$preibge  ,new TLabel('Unid Gestora: ')   ,$unidadeGestora]);
        $this->form->addQuickFields('',[new TLabel('Bairro: ')       ,$prebairro ,new TLabel('Endereço: ')     ,$preendereco ,new TLabel('Cep: ')      ,$precep]);
        $this->form->addQuickFields('',[new TLabel('DDD: ')          ,$preddd   ,new TLabel('Fone: ')         ,$prefone     ,new TLabel('Fax: ')        ,$prefax   ,]);
        $this->form->addQuickFields('',[new TLabel('<em style="color:#34568e; font-weight: bold ">OUTROS_________________________________________________________________________________________________</em>')]);
        $this->form->addQuickFields('',[new TLabel('Associação: ')   ,$preampar ,new TLabel('Ampar Logo: ')   ,$preamparlogo]);
        $this->form->addQuickFields('',[new TLabel('CC Sagres: ')    ,$concheque,new TLabel('IPTU: ')         ,$preiptu     ,new TLabel('Licenciado: '), $prelicenca]);
        $this->form->addQuickFields('',[new TLabel('Horario: ')    ,$prehorario,new TLabel('Slogan: ')         ,$preslogan]);
        $this->form->addQuickFields('',[new TLabel('População: ')    ,$prepopulacao,new TLabel('Nº Eleitor: ')         ,$preeleitor]);





        if (!empty($precodigo))
        {
            $precodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('PrefeituraList', 'onReload')), 'fa:replay red');
        // create the form actions
        /**
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fa:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fa:eraser #dd5a43');

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['PrefeituraList', 'onShow']), 'fa:reply #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 
         * 
         */
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Cadastro de Prefeitura', $this->form));
        
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
            
            $object = new Prefeitura;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->predata = TDate::date2us($object->predata);

            $prefeitura = new Prefeitura($object->precodigo);
            $destino  = $prefeitura->getDiretorio();
            $path  = "tmp/";
          //  $destino = Prefeitura::getPrefeitura($object->unidadeGestora)->getDiretorio()."prefeitura/";
            if(!file_exists($destino)) mkdir($destino,0755,true);
            if(is_file($path.$object->prebrasao))
                $object->prebrasao =  File::moveRenomeando($path.$object->prebrasao,$destino,true);
            if(is_file($path.$object->prebandeira))
                $object->prebandeira =  File::moveRenomeando($path.$object->prebandeira,$destino,true);
            if(is_file($path.$object->prelogo))
                $object->prelogo =  File::moveRenomeando($path.$object->prelogo,$destino,true);
            if(is_file($path.$object->preimagem))
                    $object->preimagem =  File::moveRenomeando($path.$object->preimagem,$destino,true);
            if(is_file($path.$object->premapa))
                $object->premapa =  File::moveRenomeando($path.$object->premapa,$destino,true);

            $object->store(); // save the object


            // get the generated precodigo
            $data->precodigo = $object->precodigo;
            
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
                $object = new Prefeitura($key); // instantiates the Active Record
                $object->predata = TDate::date2br($object->predata);
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
