<?php

//<fileHeader>

//</fileHeader>

class SecretariaTipoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conexao';
    private static $activeRecord = 'SecretariaTipo';
    private static $primaryKey = 'sectipocodigo';
    private static $formName = 'form_SecretariaTipo';

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
        $this->form->setFormTitle("SECRETARIA TIPO Cadastro");

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $sectipocodigo = new TEntry('sectipocodigo');
        $sectiponome = new TEntry('sectiponome');
        $sectiposigla = new TEntry('sectiposigla');
        $sectipousual = new TEntry('sectipousual');
        $sectipofoto = new TFile('sectipofoto');
        $sectipodescricao = new THtmlEditor('sectipodescricao');

        $sectiponome->addValidation("nome1", new TRequiredValidator()); 

    //    $sectipocodigo->setEditable(false);
    //    $sectipofoto->enableFileHandling();
     //   $sectipofoto->setAllowedExtensions(["jpg","png","gif","bmp"]);
     //   $sectipofoto->enableImageGallery('50', 50);

        $sectiponome->setMaxLength(200);
        $sectiposigla->setMaxLength(50);
        $sectipousual->setMaxLength(200);

        $sectipocodigo->setSize(100);
        $sectiponome->setSize('100%');
        $sectipofoto->setSize('100%');
        $sectiposigla->setSize('100%');
        $sectipousual->setSize('100%');
        $sectipodescricao->setSize('100%', 110);

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$sectipocodigo]);
        $row2 = $this->form->addFields([new TLabel("Nome:", '#f03030', '14px', null)],[$sectiponome]);
        $row3 = $this->form->addFields([new TLabel("Sigla:", null, '14px', null)],[$sectiposigla]);
        $row4 = $this->form->addFields([new TLabel("Usual:", null, '14px', null)],[$sectipousual]);
        $row5 = $this->form->addFields([new TLabel("Foto:", null, '14px', null)],[$sectipofoto]);
        $row6 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null)],[$sectipodescricao]);

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fa:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fa:eraser #dd5a43');

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['SecretariaTipoList', 'onShow']), 'fa:replay #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["CORONA VÍRUS","SECRETARIA TIPO Cadastro"]));
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

            $object = new SecretariaTipo(); // create an empty object //</blockLine>

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            //</beforeStoreAutoCode> //</blockLine> 
//<generatedAutoCode>

            $path  = "tmp/";
            $destino = Prefeitura::getPrefeitura($object->unidadeGestora)->getDiretorio()."secretaria/";
            if(!file_exists($destino)) mkdir($destino,755,true);
            if(is_file($path.$object->$sectipofoto))
                $object->$sectipofoto =  File::moveRenomeando($path.$object->$sectipofoto,$destino,true);
//</generatedAutoCode>

            $object->store(); // save the object //</blockLine>

            //</afterStoreAutoCode> //</blockLine>
 //<generatedAutoCode>
       //      if(is_file($path.$object->sectipofoto))
       //         $object->sectipofoto =  File::moveRenomeando($path.$object->sectipofoto,$destino,true);

        //   $this->saveFile($object, $data, 'sectipofoto', $sectipofoto_dir);
//</generatedAutoCode>

            // get the generated {PRIMARY_KEY}
            $data->sectipocodigo = $object->sectipocodigo; //</blockLine>

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

                $object = new SecretariaTipo($key); // instantiates the Active Record //</blockLine>

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
