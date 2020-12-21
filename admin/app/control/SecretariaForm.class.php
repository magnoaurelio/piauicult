<?php

//<fileHeader>

//</fileHeader>

class SecretariaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conexao';
    private static $activeRecord = 'Secretaria';
    private static $primaryKey = 'seccodigo';
    private static $formName = 'form_Secretaria';

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
        $this->form->setFormTitle("SECRETARIA Cadastro ");

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $seccodigo = new TEntry('seccodigo');
      //  $prefeitura_id = new TCombo('prefeitura_id');
        $prefeitura_id = new TDBCombo('precodigo', 'conexao', 'Prefeitura', 'precodigo', '{precodigo}-{prenome}','prenome asc'  );
        $secnome = new TEntry('secnome');
        $secsecretario = new TEntry('secsecretario');
        $secusual = new TEntry('secusual');
        $secimagem = new TFile('secimagem');
        $secfoto = new TFile('secfoto');
        $secfotor = new TFile('secfotor');
        $sechorario = new TEntry('sechorario');
        $secsexo = new TEntry('secsexo');
        $secendereco = new TEntry('secendereco');
        $secbairro = new TEntry('secbairro');
        $secfone = new TEntry('secfone');
        $seccelular = new TEntry('seccelular');
        $secemail = new TEntry('secemail');
        $secsobre = new THtmlEditor('secsobre');

        $prefeitura_id->addValidation("Prefeitura id", new TRequiredValidator()); 
        $secnome->addValidation("nome1", new TRequiredValidator()); 
        $secsecretario->addValidation("secretario", new TRequiredValidator()); 

        $seccodigo->setEditable(false);
        $prefeitura_id->enableSearch();

        $secnome->forceUpperCase();
        $secsecretario->forceUpperCase();
        
        /** @LEVA_FOTO <PARA OS CAMPOS>**/
         $cidade = @$_GET['seccodigo'];
     //   $cidade = str_pad($cidade,3,'0', STR_PAD_LEFT);
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = $cidade.'_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $path = 'files/secretarias/'.$cidade.'/';
        
         if(!file_exists($path))
            mkdir($path);
       
         
        $secfoto->setParametros($path,'SEC_'.$nome_arquivo,$permite);  
        $secfotor->setParametros($path,'GES_'.$nome_arquivo,$permite); 
        $secimagem->setParametros($path,'IMA'.$nome_arquivo,$permite); 
        
      
       

        $secsexo->setMaxLength(1);
        $secfone->setMaxLength(35);
        $seccodigo->setMaxLength(3);
        $secnome->setMaxLength(200);
        $secusual->setMaxLength(100);
        $secemail->setMaxLength(200);
        $secbairro->setMaxLength(100);
        $sechorario->setMaxLength(100);
        $seccelular->setMaxLength(100);
        $secendereco->setMaxLength(200);
        $secsecretario->setMaxLength(100);

        $seccodigo->setSize(100);
        $secnome->setSize('100%');
        $secfoto->setSize('100%');
        $secsexo->setSize('100%');
        $secfone->setSize('100%');
        $secusual->setSize('100%');
        $secfotor->setSize('100%');
        $secemail->setSize('100%');
        $secimagem->setSize('100%');
        $secbairro->setSize('100%');
        $sechorario->setSize('100%');
        $seccelular->setSize('100%');
        $secendereco->setSize('100%');
        $prefeitura_id->setSize('100%');
        $secsecretario->setSize('100%');
        $secsobre->setSize('100%', 110);

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$seccodigo],[new TLabel("Prefeituras:", '#ff0000', '14px', null)],[$prefeitura_id]);
        $row2 = $this->form->addFields([new TLabel("Nome Sec.:", '#f21d1d', '14px', null)],[$secnome],[new TLabel("Secretario(a):", '#e82323', '14px', null)],[$secsecretario]);
        $row3 = $this->form->addFields([new TLabel("Usual:", null, '14px', null)],[$secusual],[new TLabel("Imagem:", null, '14px', null)],[$secimagem]);
        $row4 = $this->form->addFields([new TLabel("Foto Sec:", null, '14px', null)],[$secfoto],[new TLabel("Foto Gestor:", null, '14px', null)],[$secfotor]);
        $row5 = $this->form->addFields([new TLabel("Horário:", null, '14px', null)],[$sechorario],[new TLabel("Sexo:", null, '14px', null)],[$secsexo]);
        $row6 = $this->form->addFields([new TLabel("Endereco:", null, '14px', null)],[$secendereco],[new TLabel("Bairro:", null, '14px', null)],[$secbairro]);
        $row7 = $this->form->addFields([new TLabel("Fone:", null, '14px', null)],[$secfone],[new TLabel("Celular:", null, '14px', null)],[$seccelular]);
        $row8 = $this->form->addFields([new TLabel("E-mail:", null, '14px', null)],[$secemail],[],[]);
        $row9 = $this->form->addFields([new TLabel("Sobre:", null, '14px', null)],[$secsobre]);

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fa:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fa:plus #ffffff');
        $btn_onclear->addStyleClass('btn-success'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['SecretariaList', 'onShow']), 'fa:reply #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["PIAUICULT","SECRETARIA Cadastro "]));
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

            $object = new Secretaria(); // create an empty object //</blockLine>

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            //</beforeStoreAutoCode> //</blockLine> 
//<generatedAutoCode>

            $secimagem_dir = 'basico';
            $secfoto_dir = 'basico';
            $secfotor_dir = 'basico';
//</generatedAutoCode>

            $object->store(); // save the object //</blockLine>

            //</afterStoreAutoCode> //</blockLine>
 //<generatedAutoCode>

            $this->fireEvents($object);

            $this->saveFile($object, $data, 'secimagem', $secimagem_dir);
            $this->saveFile($object, $data, 'secfoto', $secfoto_dir);
            $this->saveFile($object, $data, 'secfotor', $secfotor_dir);
//</generatedAutoCode>

            // get the generated {PRIMARY_KEY}
            $data->seccodigo = $object->seccodigo; //</blockLine>

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
//<generatedAutoCode>

            $this->fireEvents($this->form->getData());
//</generatedAutoCode>

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

                $object = new Secretaria($key); // instantiates the Active Record //</blockLine>

                //</beforeSetDataAutoCode> //</blockLine>

                $this->form->setData($object); // fill the form //</blockLine>

                //</afterSetDataAutoCode> //</blockLine>
//<generatedAutoCode>

                $this->fireEvents($object);

//</generatedAutoCode>
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

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->prefeitura_id))
            {
                $value = $object->prefeitura_id;

                $obj->prefeitura_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->prefeitura_id))
            {
                $value = $object->prefeitura_id;

                $obj->prefeitura_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    //</hideLine> <addUserFunctionsCode/>

    //<userCustomFunctions>

    //</userCustomFunctions>

}