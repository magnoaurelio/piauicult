<?php

//<fileHeader>

//</fileHeader>

class PublicidadeForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conexao';
    private static $activeRecord = 'Publicidade';
    private static $primaryKey = 'pubcodigo';
    private static $formName = 'form_Publicidade';

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
        $this->form->setFormTitle("PUBLICIDADE Cadastro ");

        //<onBeginPageCreation>

        //</onBeginPageCreation>

        $pubcodigo = new TEntry('pubcodigo');
        $pubtipocodigo = new TDBCombo('pubtipocodigo', 'conexao', 'Publicidadetipo', 'pubtipocodigo', '{pubtipocodigo} -{pubtiponome} ','pubtiponome asc'  );
        $unidadeGestora = new TDBCombo('unidadeGestora', 'conexao', 'Prefeitura', 'codigoUnidGestora', '{codigoUnidGestora} - {prenome}','codigoUnidGestora asc'  );
        $pubgeral = new TCombo('pubgeral');
        $pubativa = new TCombo('pubativa');
        $pubdata = new TDate('pubdata');
        $pubimagem = new TFile('pubimagem');
        $pubsobre = new THtmlEditor('pubsobre');
        
        $unidadeGestora->enableSearch();
        $pubtipocodigo->enableSearch();

        $pubgeral->addValidation("Geral", new TRequiredValidator()); 
        $pubativa->addValidation("Ativa", new TRequiredValidator()); 
        $unidadeGestora->addValidation("Unidade Gestora", new TRequiredValidator()); 

        $pubcodigo->setEditable(false);
        $pubcodigo->setMaxLength(5);
        $pubdata->setMask('dd/mm/yyyy');
        $pubdata->setDatabaseMask('yyyy-mm-dd');
     
       // $pubimagem->enableFileHandling();
          $pubimagem->setAllowedExtensions(["jpg","jpeg","png","bmp","gif"]);
     //   $pubimagem->enableImageGallery('60', 40);

        $pubgeral->addItems(['0'=>'NÃO','1'=>'SIM']);
        $pubativa->addItems(['0'=>'NÃO','1'=>'SIM']);

        $pubdata->setSize(270);
        $pubcodigo->setSize(100);
        $pubgeral->setSize('100%');
        $pubativa->setSize('100%');
        $pubimagem->setSize('100%');
        $pubsobre->setSize('100%', 110);
        $unidadeGestora->setSize('100%');
        $pubtipocodigo->setSize('100%');

        //<onBeforeAddFieldsToForm>

        //</onBeforeAddFieldsToForm>
        $row1 = $this->form->addFields([new TLabel("ID:", null, '14px', null)],[$pubcodigo],[],[]);
        $row2 = $this->form->addFields([new TLabel("Tipo Publicidade:", null, '14px', null)],[$pubtipocodigo],[new TLabel("Un Gestora:", '#ff0000', '14px', null)],[$unidadeGestora]); // 
        $row3 = $this->form->addFields([new TLabel("Visão Geral:", '#ff0000', '14px', null)],[$pubgeral],[new TLabel("Estado Ativa:", '#ff0000', '14px', null)],[$pubativa]);
        $row4 = $this->form->addFields([new TLabel("Data Publicação:", null, '14px', null)],[$pubdata],[new TLabel("Imagem:", null, '14px', null)],[$pubimagem]);
        $row5 = $this->form->addFields([new TLabel("Sobre:", null, '14px', null)],[$pubsobre]);

        //<onAfterFieldsCreation>

        //</onAfterFieldsCreation>

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fa:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fa:eraser #ffffff');
        $btn_onclear->addStyleClass('btn-success'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['PublicidadeList', 'onShow']), 'fa:reply #ffffff');
        $btn_onshow->addStyleClass('btn-danger'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(["AUXILIAR","PUBLICIDADE Cadastro "]));
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

            $object = new Publicidade(); // create an empty object //</blockLine>

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->unidadeGestora = \Adianti\Registry\TSession::getValue('unidadeGestora');
            var_dump( $object->unidadeGestora);
            //</beforeStoreAutoCode> //</blockLine> 
//<generatedAutoCode>

            $path  = "tmp/";
            $destino = 'files/prefeituras/'.($object->unidadeGestora)."/publicidade/";
            if (!file_exists($destino)) {
                mkdir($destino, 755, true);
            }
            if (is_file($path . $object->pubimagem)) {
                $object->pubimagem = File::moveRenomeando($path . $object->pubimagem, $destino, true);
            }
//</generatedAutoCode>

            $object->store(); // save the object //</blockLine>

            //</afterStoreAutoCode> //</blockLine>
 //<generatedAutoCode>

        //    $this->saveFile($object, $data, 'pubimagem', $pubimagem_dir);
//</generatedAutoCode>

            // get the generated {PRIMARY_KEY}
            $data->pubcodigo = $object->pubcodigo; //</blockLine>

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

                $object = new Publicidade($key); // instantiates the Active Record //</blockLine>

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