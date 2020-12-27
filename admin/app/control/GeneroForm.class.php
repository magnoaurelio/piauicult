<?php

//<fileHeader>

//</fileHeader>

class GeneroForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conexao';
    private static $activeRecord = 'Genero';
    private static $primaryKey = 'gencodigo';
    private static $formName = 'form_Genero';

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
        $this->form->setFormTitle("GÊNERO Cadastro");

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $gencodigo = new TEntry('gencodigo');
        $gennome = new TEntry('gennome');
        $genano = new TEntry('genano');
        $genimagem = new TFile('genimagem');
        $genorigem = new THtmlEditor('genorigem');

        $gencodigo->setMaxLength(5);
        $gencodigo->setEditable(false);
        
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'GEN_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $genimagem->setParametros('files/instrumento/',$nome_arquivo,$permite);


        $genano->setMaxLength(50);
       

        $gencodigo->setSize(100);
        $genano->setSize('100%');
        $gennome->setSize('100%');
        $genimagem->setSize('100%');
        $genorigem->setSize('100%', 110);

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
       // add the fields
        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null)],[$gencodigo],[new TLabel("Nome:", 'green', '14px', null)],[$gennome]);
        $row1 = $this->form->addFields([new TLabel("Período:", null, '14px', null)],[$genano],[new TLabel("Imagem:", 'green', '14px', null)],[$genimagem]);
        $row1 = $this->form->addFields([new TLabel("Origem:", null, '14px', null)],[$genorigem]);
       
       
        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fa:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fa:eraser #fff');
        $btn_onclear->addStyleClass('btn-success'); 
        $btn_onshow = $this->form->addAction("Voltar", new TAction(['GeneroList', 'onShow']), 'fa:reply #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["PIAUICULT","GÊNERO Cadastro"]));
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

            $object = new Genero(); // create an empty object //</blockLine>

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object //</blockLine>

            // get the generated {PRIMARY_KEY}
            $data->gencodigo = $object->gencodigo; //</blockLine>

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

                $object = new Genero($key); // instantiates the Active Record //</blockLine>

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