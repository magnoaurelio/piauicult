<?php
/**
 * BandaTipoForm Registration
 * @author  <your name here>
 */
class BandaTipoForm extends TPage
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
        $this->setActiveRecord('BandaTipo');     // defines the active record
        
        // creates the form
        $this->form = new TQuickForm('form_BandaTipo');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('BandaTipo');
        


        // create the form fields
        $bantipocodigo = new TEntry('bantipocodigo');
        $bantiponome = new TEntry('bantiponome');
        $bantipofoto = new TFile('bantipofoto');

        // incluir foto do ARTISTA
        $data_now = date('dmYHis');
        $getid = TSession::getValue('userid');
        $nome_arquivo = 'BANTIP'.$data_now.'_'.$getid;
        $permite = array('GIF','gif','JPG','PNG','jpg','png','JPEG','jpeg');
        $bantipofoto->setParametros('files/banda_tipo/',$nome_arquivo,$permite); 
        
        // add the fields
        $this->form->addQuickField('Codigo', $bantipocodigo,  100 );
        $this->form->addQuickField('Tipo de Grupo', $bantiponome,  300 );
        $this->form->addQuickField('Foto Tipo de Grupos', $bantipofoto,  300 );



        
        if (!empty($bantipocodigo))
        {
            $bantipocodigo->setEditable(FALSE);
        }
        
        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'bs:plus-sign green');
        $this->form->addQuickAction('Voltar', new TAction(array('BandaTipoList', 'onReload')), 'fa:reply green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Banda Tipo', $this->form));
        
        parent::add($container);
    }
}
