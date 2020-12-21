<?php

//<fileHeader>

//</fileHeader>

class PrefeituraForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conexao';
    private static $activeRecord = 'Prefeitura';
    private static $primaryKey = 'precodigo';
    private static $formName = 'form_Prefeitura';

    //<classProperties>

    //</classProperties>

    use Adianti\Base\AdiantiFileSaveTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("PREFEITURA Cadastro ");

        //<onBeginPageCreation>
        /** @veja 
       
        $fotos = [];
        for($i = 1; $i <= 224; $i++){
            $fotos[] = str_pad($i, 3, '0', STR_PAD_LEFT);
        }
       // print_r($fotos);
        var_dump($fotos);
        //</onBeginPageCreation>
         * 
         */

        $precodigo = new TEntry('precodigo');
        $prenome = new TEntry('prenome');
        $prenomep = new TEntry('prenomep');
        $prenomeu = new TEntry('prenomeu');
        $precidade = new TEntry('precidade');
        $predata = new TDate('predata');
        $prehorario = new TEntry('prehorario');
        $preslogan = new TEntry('preslogan');
        $preendereco = new TEntry('preendereco');
        $precep = new TEntry('precep');
        $prebairro = new TEntry('prebairro');
        $preemail = new TEntry('preemail');
        $presite = new TEntry('presite');
        $precnpj = new TEntry('precnpj');
        $prelogo = new TFile('prelogo');
        $prefoto = new TFile('prefoto');
        $prebrasao = new TFile('prebrasao');
        $prebandeira = new TFile('prebandeira');
        $preimagem = new TFile('preimagem');
        $prefone = new TEntry('prefone');
        $preddd = new TEntry('preddd');
        $presobre = new THtmlEditor('presobre');
        
        $precodigo->setEditable(false);
        $predata->setDatabaseMask('yyyy-mm-dd');

        $prenome->forceUpperCase();
        $prenomep->forceUpperCase();

        $preddd->setMask('999');
        $precep->setMask('99999-999');
        $predata->setMask('dd/mm/yyyy');
        $precnpj->setMask('99.999.999/9999-99');
         /** @aguarde
        $prefoto->setAllowedExtensions(["jpg","png","bmp","gif","jpeg"]);
        $prebrasao->setAllowedExtensions(["jpg","jpeg","gif","bmp","png"]);
        $preimagem->setAllowedExtensions(["jpg","png","bmp","gif","jpeg"]);
        $prebandeira->setAllowedExtensions(["jpg","jpeg","png","bmp","gif"]);
       
        $prelogo->enableFileHandling();
        $prefoto->enableFileHandling();
        $prebrasao->enableFileHandling();
        $preimagem->enableFileHandling();
        $prebandeira->enableFileHandling();
          * 
          *  $prefoto->setAllowedExtensions(DadosFixos::extensaoImagem());
        $prelogo->setAllowedExtensions(DadosFixos::extensaoImagem());
        $preimagem->setAllowedExtensions(DadosFixos::extensaoImagem());
        $prebrasao->setAllowedExtensions(DadosFixos::extensaoImagem());
        $prebandeira->setAllowedExtensions(DadosFixos::extensaoImagem());
          *
          */
       
       

       
       
        

        $preddd->setMaxLength(3);
        $precep->setMaxLength(9);
        $precnpj->setMaxLength(18);
        $precodigo->setMaxLength(3);
        $prenome->setMaxLength(200);
        $presite->setMaxLength(100);
        $prefone->setMaxLength(200);
        $prenomep->setMaxLength(200);
        $prenomeu->setMaxLength(100);
        $preemail->setMaxLength(100);
        $precidade->setMaxLength(100);
        $prebairro->setMaxLength(100);
        $prehorario->setMaxLength(100);
        $preendereco->setMaxLength(120);

        $predata->setSize(260);
        $precodigo->setSize(100);
        $preddd->setSize('100%');
        $precep->setSize('100%');
        $prenome->setSize('100%');
        $prefone->setSize('100%');
        $prefoto->setSize('100%');
        $prelogo->setSize('100%');
        $precnpj->setSize('100%');
        $presite->setSize('100%');
        $preemail->setSize('100%');
        $prenomeu->setSize('100%');
        $prenomep->setSize('100%');
        $prebairro->setSize('100%');
        $preslogan->setSize('100%');
        $precidade->setSize('100%');
        $prebrasao->setSize('100%');
        $preimagem->setSize('100%');
        $prehorario->setSize('100%');
        $preendereco->setSize('100%');
        $prebandeira->setSize('100%');
        $presobre->setSize('100%', 110);
        
        $cidade = @$_GET['precodigo'];
     //   $cidade = str_pad($cidade,3,'0', STR_PAD_LEFT);
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = $cidade.'_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $path = 'files/prefeituras/'.$cidade.'/';
        
         if(!file_exists($path))
            mkdir($path);
       
        $preimagem->setParametros($path,'IMA_'.$nome_arquivo,$permite); 
        $prefoto->setParametros($path,'PRE_'.$nome_arquivo,$permite);  
        $prelogo->setParametros($path,'LOG_'.$nome_arquivo,$permite); 
        $prebrasao->setParametros($path,'BRA_'.$nome_arquivo,$permite); 
        $prebandeira->setParametros($path,'BAN_'.$nome_arquivo,$permite); 
      
        /** @aguarde
        $prelogo->enableImageGallery('50', 50);
        $prefoto->enableImageGallery('50', 50);
        $prebrasao->enableImageGallery('30', 30);
        $preimagem->enableImageGallery('50', 50);
        $prebandeira->enableImageGallery('50', 50);
         * 
         */
       
        
        
            
        

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$precodigo],[new TLabel("Nome:", null, '14px', null)],[$prenome]);
        $row2 = $this->form->addFields([new TLabel("Gestor:", null, '14px', null)],[$prenomep],[new TLabel("Nome usual:", null, '14px', null)],[$prenomeu]);
        $row3 = $this->form->addFields([new TLabel("Cidade:", null, '14px', null)],[$precidade],[new TLabel("Data:", null, '14px', null)],[$predata]);
        $row4 = $this->form->addFields([new TLabel("Horário:", null, '14px', null)],[$prehorario],[new TLabel("Horário:", null, '14px', null)],[]);
        $row5 = $this->form->addFields([new TLabel("Slonga:", null, '14px', null)],[$preslogan],[new TLabel("Endereço:", null, '14px', null)],[$preendereco]);
        $row6 = $this->form->addFields([new TLabel("CEP:", null, '14px', null)],[$precep],[new TLabel("Bairro:", null, '14px', null)],[$prebairro]);
        $row7 = $this->form->addFields([new TLabel("E-mail:", null, '14px', null)],[$preemail],[new TLabel("Site:", null, '14px', null)],[$presite]);
        $row8 = $this->form->addFields([new TLabel("CNPJ:", null, '14px', null)],[$precnpj],[new TLabel("Logomarca:", null, '14px', null)],[$prelogo]);
        $row9 = $this->form->addFields([new TLabel("Foto Gestor:", null, '14px', null)],[$prefoto],[new TLabel("Brasão:", null, '14px', null)],[$prebrasao]);
        $row10 = $this->form->addFields([new TLabel("Bandeira:", null, '14px', null)],[$prebandeira],[new TLabel("Imagem:", null, '14px', null)],[$preimagem]);
        $row11 = $this->form->addFields([new TLabel("Fone / Celular:", null, '14px', null)],[$prefone],[new TLabel("DDD:", null, '14px', null)],[$preddd]);
        $row12 = $this->form->addFields([new TLabel("Sobre:", null, '14px', null)],[$presobre]);

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:plus #ffffff');
        $btn_onclear->addStyleClass('btn-success'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['PrefeituraList', 'onShow']), 'fas:reply #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["Básico","PREFEITURA Cadastro "]));
        $container->add($this->form);

        //<onAfterPageCreation>

        //</onAfterPageCreation>

        parent::add($container);

    }

//<generated-FormAction-onSave>
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Prefeitura(); // create an empty object //</blockLine>

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            //</beforeStoreAutoCode> //</blockLine> 
//<generatedAutoCode>

            $prelogo_dir = '/tmp';
            $prefoto_dir = '/tmp';
            $prebrasao_dir = '/tmp';
            $prebandeira_dir = '/tmp';
            $preimagem_dir = '/tmp';
//</generatedAutoCode>

            $object->store(); // save the object //</blockLine>

            //</afterStoreAutoCode> //</blockLine>
 //<generatedAutoCode>

            $this->saveFile($object, $data, 'prelogo', $prelogo_dir);
            $this->saveFile($object, $data, 'prefoto', $prefoto_dir);
            $this->saveFile($object, $data, 'prebrasao', $prebrasao_dir);
            $this->saveFile($object, $data, 'prebandeira', $prebandeira_dir);
            $this->saveFile($object, $data, 'preimagem', $preimagem_dir);
//</generatedAutoCode>

            // get the generated {PRIMARY_KEY}
            $data->precodigo = $object->precodigo; //</blockLine>

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            //</messageAutoCode> //</blockLine>
//<generatedAutoCode>
            new TMessage('info', "Registro salvo", $messageAction);
//</generatedAutoCode>

            //</endTryAutoCode> //</blockLine>

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> //</blockLine>

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
//</generated-FormAction-onSave>

//<generated-onEdit>
    public function onEdit( $param )//</ini>
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Prefeitura($key); // instantiates the Active Record //</blockLine>

                //</beforeSetDataAutoCode> //</blockLine>

                $this->form->setData($object); // fill the form //</blockLine>

                //</afterSetDataAutoCode> //</blockLine>
                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }//</end>
//</generated-onEdit>

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

        //<onFormClear>

        //</onFormClear>

    }

    public function onShow($param = null)
    {

        //<onShow>

        //</onShow>
    } 

    //</hideLine> <addUserFunctionsCode/>

    //<userCustomFunctions>

    //</userCustomFunctions>

}