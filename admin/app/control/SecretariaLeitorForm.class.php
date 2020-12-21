<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * SecretariaForm Form
 * @author  <your name here>
 */
class SecretariaLeitorForm extends TPage
{
    protected $form; // form
    protected $dados;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct($param)
    {
        parent::__construct();

        // creates the form
        $this->form = new TQuickForm('form_Secretaria');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new \Adianti\Wrapper\BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style

        // define the form title
        $this->form->setFormTitle('Secretaria');


        $arquivo = new TFile('arquivo');
        $tipo = new \Adianti\Widget\Wrapper\TDBCombo('sectipocodigo ', 'conexao', 'SecretariaTipo', 'sectipocodigo', 'sectiponome', 'sectiponome');

        $tipo->enableSearch();

        $this->form->addQuickField('Arquivo (.xlsx)', $arquivo, 300);
        $this->form->addQuickField('Tipo', $tipo, 300);


        // create the form actions
        $this->form->addQuickAction('Processar', new TAction(array($this, 'onSave')), 'fa:floppy-o');


        $this->datagrid = new TDataGrid;
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->datatable = 'true';

        $column_precodigo = new \Adianti\Widget\Datagrid\TDataGridColumn('precodigo', 'Precodigo', 'right');
        $column_secsecretario = new \Adianti\Widget\Datagrid\TDataGridColumn('secsecretario', 'Secretário', 'left');
        $column_secusual = new \Adianti\Widget\Datagrid\TDataGridColumn('secusual', 'Usual', 'left');
        $column_secendereco = new \Adianti\Widget\Datagrid\TDataGridColumn('secendereco', 'Nome', 'left');
        $column_secfone = new \Adianti\Widget\Datagrid\TDataGridColumn('secfone', 'Fone', 'left');
        $column_secemail = new \Adianti\Widget\Datagrid\TDataGridColumn('secemail', 'Email', 'left');
        $column_save = new \Adianti\Widget\Datagrid\TDataGridColumn('save', 'Salvo', 'left');


        $column_precodigo->setTransformer(function ($value, $object, $row) {
            $precodigo = new \Adianti\Widget\Wrapper\TDBCombo('precodigo' . $value, 'conexao', 'Prefeitura', 'precodigo', 'prenome');
            $precodigo->setValue($value);
            $precodigo->setEditable(false);
            return $precodigo;
        });


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_precodigo);
        $this->datagrid->addColumn($column_secsecretario);
        $this->datagrid->addColumn($column_secsecretario);
        $this->datagrid->addColumn($column_secusual);
        $this->datagrid->addColumn($column_secendereco);
        $this->datagrid->addColumn($column_secfone);
        $this->datagrid->addColumn($column_secemail);
        $this->datagrid->addColumn($column_save);

        $this->datagrid->createModel();
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Processamento de Arquivos', $this->form));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));


        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave($param)
    {
        try {
            TTransaction::open('conexao'); // open a transaction

            /**
             * // Enable Debug logger for SQL operations inside the transaction
             * TTransaction::setLogger(new TLoggerSTD); // standard output
             * TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
             **/

            $this->form->validate(); // validate form data
            $data = $this->form->getData();
            $path = "tmp/";


            $reader = IOFactory::createReader("Xlsx");
            $reader->setReadDataOnly(TRUE);
            $spreadsheet = $reader->load($path . $data->arquivo);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
            $primeiroValue = true;
            for ($row = 1; $row <= $highestRow; ++$row) {
                $secretaria = new stdClass();

                if (!$primeiroValue) {
                    break;
                }

                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();

                    if ($col > 8 && $value == NULL) continue;


                    if ($row > 3) {
                        if ($col == 1 && $value == NULL) {
                            $primeiroValue = false;
                            break;
                        }


                        switch ($col) {
                            case 1:
                                $secretaria->precodigo = $value;
                                break;
                            case 2:
                                break;
                            case 3:
                                $secretaria->secendereco = $value;
                                break;
                            case 4:
                                $secretaria->secendereco .= " " . $value;
                                break;
                            case 5:
                                $secretaria->secfone = $value;
                                break;
                            case 6:
                                break;
                            case 7:
                                $secretaria->secsecretario = $value;
                                $secretaria->secusual = strtok($value, " ");
                                break;
                            case 8:
                                $secretaria->secfone .= " " . $value;
                                break;
                            case 9:
                                $secretaria->secemail =  $value;
                                break;
                        }

                    }
                }

                if (isset($secretaria->precodigo)) {
                    $secretaria->tipo = $data->sectipocodigo;
                    $this->dados[$secretaria->precodigo] = $secretaria;
                }

            }

            if ($this->dados) {

                foreach ($this->dados as $key => $secretariaData) {
                    $prefeitura = new Prefeitura(intval($secretariaData->precodigo));
                    $tipo = new SecretariaTipo($secretariaData->tipo);


                    if (!$prefeitura->codigoUnidGestora){
                        new \Adianti\Widget\Dialog\TMessage("info","Não adicionamos a secretaria para a prefeitura de <b>{$secretariaData->precodigo}</b> porque esta, não possui Código da Unidade Gestora");
                        continue;
                    }

                    $secretarias = Secretaria::where('sectipocodigo', '=', $secretariaData->tipo)
                        ->where('unidadeGestora', '=', $prefeitura->codigoUnidGestora)
                        ->load();


                    $secretaria = sizeof($secretarias) ? $secretarias[0] : new Secretaria();
                    $secretaria->fromArray((array) $secretariaData);
                    $secretaria->precodigo =  $prefeitura->precodigo;
                    $secretaria->unidadeGestora =  $prefeitura->codigoUnidGestora;
                    $secretaria->sectipocodigo =  $secretariaData->tipo;
                    $secretaria->secnome =  $tipo->sectiponome;
                    $secretaria->save =  "Sim";
                    $this->dados[$key] =  $secretaria;

                    $secretaria->store();
                }
            }

            TTransaction::close(); // close the transaction


            \Adianti\Registry\TSession::setValue('dados', $this->dados);

            $param = array();
            $param['offset'] = 0;
            $param['first_page'] = 1;

            $this->onReload($param);


        } catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData($this->form->getData()); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onReload($param = NULL)
    {
        try {
            // open a transaction with database 'conexao'
            TTransaction::open('conexao');
            $this->dados = \Adianti\Registry\TSession::getValue('dados');

            $limit = 10;


            if (is_callable($this->transformCallback)) {
                call_user_func($this->transformCallback, $this->dados, $param);
            }

            $this->datagrid->clear();
            if ($this->dados) {

                $page = array_slice($this->dados, $param["offset"], $limit);
                // iterate the collection of active records
                foreach ($page as $object) {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }


            $count = sizeof($this->dados);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit(10); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        } catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

}
