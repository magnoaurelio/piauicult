<?php

/**
 * PrefeitoForm Form
 * @author  <your name here>
 */
class PrefeitoForm extends TPage {

    protected $form; // form
    
    protected $precodigo;

    /**
     * Form constructor
     * @param $param Request
     */

    public function __construct($param) {
        parent::__construct();

        // creates the form
        $this->form = new TQuickForm('form_Prefeito');
        $this->form->class = 'tform'; // change CSS class
        $this->form->style = 'display: table;width:100%; '; // change style
        // define the form title
        // create the form fields
        $prenumero = new TEntry('prenumero');
        $pretse = new TEntry('pretse');
        $criteria =  new TCriteria;
        //$criteria->add(new TFilter('preampar','=','ampar'));
        $precodigo = new TDBCombo('precodigo','conexao','Prefeitura','precodigo','prenome','prenome',$criteria);
        $pretipo = new TCombo('pretipo');
        $preescola = new TCombo('preescola');
        $preendereco = new TEntry('preendereco');
        $precep = new TEntry('precep');
        $prebairro = new TEntry('prebairro');
        $preemail = new TEntry('preemail');
        $preapep = new TEntry('preapep');
        $prenomep = new TEntry('prenomep');
        $prefotop = new \Adianti\Widget\Form\TFile('prefotop');
        $prepartidop =  new TDBCombo('prepartidop','conexao','Partido','parcodigo','parsigla','parsigla');
        $pretitulo = new TEntry('pretitulo');
        $precpf = new TEntry('precpf');
        $preddd = new TEntry('preddd');
        $prefone = new TEntry('prefone');
        $precelular = new TEntry('precelular');
        $precivil = new TCombo('precivil');
        $historico = new THtmlEditor('historico');
        $prehino = new THtmlEditor('prehino');
        $preniverp = new TDate('preniverp');        
        $presexop = new TCombo('presexop');
        
        $preconjuge = new TEntry('preconjuge');
        $preconusual = new TEntry('preconusual');
        $preniverc = new TDate('preniverc');
        $presexoc = new TCombo('presexoc');
        $precelulac = new TEntry('precelulac');
        $prefotoc = new TFile('prefotoc');
        
        
        $prerg = new TEntry('prerg');
        $prerguf = new TEntry('prerguf');
        $prergdata = new TDate('prergdata');
        $prergorgao = new TEntry('prergorgao');
        
        $precodigo->setValue(TSession::getValue('setPrefeitura'));
        $precodigo->setEditable(FALSE);
      
        $prenumero->setSize(80);
        $pretse->setSize(500);
        $prenomep->setSize(400);
        $prefotop->setSize(300);
        $precep->setSize(100);
        $preendereco->setSize(250);
        $preendereco->setSize(160);
        $precep->setMask('99999-999');
        $preddd->setSize(80);
        $prefone->setSize(100);
        $prefone->setMask('99999-9999');
        $precelular->setSize(100);
        $precelular->setMask('99999-9999');
        $preniverp->setMask('dd/mm/yyyy');
       
        $prergdata->setMask('dd/mm/yyyy');
        
        $historico->setSize("100%");
        $prehino->setSize("100%");
        $precpf->setSize(100);
        $pretipo->setSize(120);
        $pretitulo->setSize(120);
        $presexop->setSize(120);
        $preniverp->setSize(100);
        
        $pretipo->addItems(['Prefeito','Vice']);
        $presexop->addItems(DadosFixos::Genero());
        $preescola->addItems(DadosFixos::Escolaridade());
        $precivil->addItems(DadosFixos::EstadoCivil());
        
         $presexoc->setSize(120);
         $preniverc->setSize(100);
         $preniverc->setMask('dd/mm/yyyy');
         $precelulac->setSize(120);
         $presexoc->addItems(DadosFixos::Genero());
         $preconjuge->setSize(300);
      
        $frame1 = new TFrame('frame1');
        $frame1->style = "border:1px dotted #CCC";
        $frame1->setLegend('Prefeto(a) - Vice');
        
        $table = new TTable;
        $table->class = "table";
        $table->addRowSet('COD:','Cidade:','Nome:','Usual:','Foto');
        $table->addRowSet($prenumero,$precodigo,$prenomep,$preapep,$prefotop);
        $frame1->add($table);
        
        $table = new TTable;
        $table->class = "table";
        $table->addRowSet('Endereço:','Bairro:','Cep:','Email:','DDD','Fone:','Celular:','Partido');
        $table->addRowSet($preendereco,$prebairro,$precep,$preemail,$preddd,$prefone,$precelular,$prepartidop);
        $frame1->add($table);
        $this->form->add($frame1);
        
        $table = new TTable;
        $table->class = "table";
        $table->addRowSet('Tipo:','Escolaridade:','Estado Civil:','Título Eleitor:','CPF:','Gênero','Data Nasc.');
        $table->addRowSet($pretipo,$preescola,$precivil,$pretitulo,$precpf,$presexop,$preniverp);
        $frame1->add($table);
        $this->form->add($frame1);
        
         $table = new TTable;
        $table->class = "table";
        $table->addRowSet('TSE:','RG:','Orgão Expedidor:','UF Expedição','Data Expedição');
        $table->addRowSet($pretse,$prerg,$prergorgao,$prerguf,$prergdata);
        $frame1->add($table);
        $this->form->add($frame1);
        
        $table = new TTable;
        $table->class = "table";
        $table->addRowSet('Histórico:');
        $table->addRowSet($historico);
        $frame1->add($table);
        $this->form->add($frame1);
        
        $table = new TTable;
        $table->class = "table";
        $table->addRowSet('Hino:');
        $table->addRowSet($prehino);
        $frame1->add($table);
        $this->form->add($frame1);
        
        
        
        $frame2 = new TFrame('frame2');
        $frame2->setLegend('Cônjuge');
        $frame2->style = "border:1px dotted #CCC";
        $this->form->add($frame2);
        
         $table = new TTable;
        $table->class = "table";
        $table->addRowSet('Nome:','Usual:','Gênero:','Data Nasc:','Celular','Foto');
        $table->addRowSet($preconjuge,$preconusual,$presexoc,$preniverc,$precelulac,$prefotoc);
        $frame2->add($table);
         
        $table = new TTable;
        $table->class = "table";
        $save = TButton::create('save', array($this, 'onSave'), 'Salvar', 'fa:floppy-o blue');
        $this->form->addField($save);
        $novo = TButton::create('novo', array($this, 'onClear'), 'Novo', 'bs:plus-sign green');
        $this->form->addField($novo);  
        $lista = TButton::create('lista', array('PrefeitoList', 'onReload'), 'Voltar ', 'bs:replay red');
        $this->form->addField($lista);        
        $row =  $table->addRowSet([$save,$novo,$lista]);
        $row->class = "active";
        $gridpack = new TVBox;
        $gridpack->style = "width:100%";
        $gridpack->add($table)->style = 'background:whiteSmoke;border:1px solid #cccccc; padding: 3px;padding: 5px;';
        $this->form->add($gridpack);
        
        $cidade = TSession::getValue('setPrefeitura');
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $prefotop->setAllowedExtensions($permite);
        $prefotoc->setAllowedExtensions($permite);

        
       // $precodigo->setChangeAction(new TAction(array($this, 'onChangerTipo')));

        // add the fields
        $this->form->addField($prenumero);
        $this->form->addField($precodigo);
        $this->form->addField($pretipo);
        $this->form->addField($preescola);
        $this->form->addField($preendereco);
        $this->form->addField($precep);
        $this->form->addField($prebairro);
        $this->form->addField($preemail);
        $this->form->addField($preapep);
        $this->form->addField($prenomep);
        $this->form->addField($prefotop);
        $this->form->addField($prepartidop);
        $this->form->addField($pretitulo);
        $this->form->addField($precpf);
        $this->form->addField($prerg);
        $this->form->addField($prergdata);
        $this->form->addField($prerguf);
        $this->form->addField($prergorgao);
        $this->form->addField($preddd);
        $this->form->addField($prefone);
        $this->form->addField($precelular);
        $this->form->addField($precivil);
        $this->form->addField($historico);
        $this->form->addField($preniverp);
        $this->form->addField($presexop);
        $this->form->addField($preconjuge);
        $this->form->addField($preconusual);
        $this->form->addField($preniverc);
        $this->form->addField($presexoc);
        $this->form->addField($precelulac);
        $this->form->addField($prefotoc);
        $this->form->addField($pretse);




        if (!empty($prenumero)) {
            $prenumero->setEditable(FALSE);
        }
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 150%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Cadastro de Prefeito', $this->form));

        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave($param) {
        try {
            TTransaction::open('conexao'); // open a transaction

            /**
              // Enable Debug logger for SQL operations inside the transaction
              TTransaction::setLogger(new TLoggerSTD); // standard output
              TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
             * */
            $this->form->validate(); // validate form data

            $object = new Prefeito;  // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray((array) $data); // load the object with data
           
            $object->preniverp = TDate::date2us($object->preniverp);
            $object->preniverc = TDate::date2us($object->preniverc);
            $object->prergdata = TDate::date2us($object->prergdata);

            $prefeitura = new Prefeitura($object->precodigo);
            $destino  = $prefeitura->getDiretorio();
            $path  = "tmp/";

            if (!file_exists($destino)) {
                mkdir($destino, 777, true);
            }
            if (is_file($path . $object->prefotop)) {
                $object->prefotop = File::moveRenomeando($path . $object->prefotop, $destino, true);
            }
            if (is_file($path . $object->prefotoc)) {
                $object->prefotoc = File::moveRenomeando($path . $object->prefotoc, $destino, true);
            }



            $object->store(); // save the object
            // get the generated prenumero
            $data->prenumero = $object->prenumero;

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        } catch (Exception $e) { // in case of exception
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData($this->form->getData()); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear($param) {
        $this->form->clear(TRUE);
    }

    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit($param) {
        try {
            if (isset($param['key'])) {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('conexao'); // open a transaction
                $object = new Prefeito($key); // instantiates the Active Record
                 $object->preniverp = TDate::date2br($object->preniverp);
                 $object->preniverc = TDate::date2br($object->preniverc);
                 $object->prergdata = TDate::date2br($object->prergdata);
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
            } else {
                $this->form->clear(TRUE);
            }
        } catch (Exception $e) { // in case of exception
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
   
   public static function onChangerTipo($param) {
       if(!empty(trim($param['precodigo']))){
        TSession::setValue('setcidade',$param['precodigo']);
        new TMessage('warning',"Você é um usuário Admin apert F5 para atualizar as Sessões!");
        }
    }

}
