<?php
/**
 * LinksForm Registration
 * @author  <your name here>
 */
class LinksForm extends TPage
{
    protected $form; // form
    
    use Adianti\Base\AdiantiStandardFormTrait; // Standard form methods
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('conexao');              // defines the database
        $this->setActiveRecord('Links');     // defines the active record
        
        // creates the form
        $this->form = new TQuickForm('form_Links');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Links');
        


        // create the form fields
        $lincodigo = new TEntry('lincodigo');
        $artcodigo = new TDBCombo('artcodigo','conexao','Artista','artcodigo','artnome','artnome');
        $linnome = new TEntry('linnome');
        $linurl = new TEntry('linurl');
        $linresponsavel = new TEntry('linresponsavel');
        $linusual = new TEntry('linusual');
        $lincontato = new TEntry('lincontato');
        $linemail = new TEntry('linemail');
        $linimagem = new TFile('linimagem');
        $linfoto = new TFile('linfoto');

        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'LIN_'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png');
        $linimagem->setParametros('files/links/',$nome_arquivo,$permite); 
        $linfoto->setParametros('files/links/',$nome_arquivo,$permite); 
        
        // add the fields
        $this->form->addQuickField('Cd_Link', $lincodigo,  100 );
        $this->form->addQuickField('Cd Artista', $artcodigo,  300 );
        $this->form->addQuickField('Nome do Site', $linnome,  300 );
        $this->form->addQuickField('URL', $linurl,  300 );
        $this->form->addQuickField('Responsável', $linresponsavel,  300 );
        $this->form->addQuickField('nome Usual', $linusual,  200 );
        $this->form->addQuickField('Contato', $lincontato,  300 );
        $this->form->addQuickField('E-mail', $linemail,  300 );
        $this->form->addQuickField('Imagem do Site', $linimagem,  300 );
        $this->form->addQuickField('Foto do Autor', $linfoto,  300 );



        
        if (!empty($lincodigo))
        {
            $lincodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar',  new TAction(array('LinksList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Links Form', $this->form));
        
        parent::add($container);
    }
}
