<?php
/**
 * SecretariaTipoFormView Form
 * @author  <your name here>
 */
class SecretariaTipoFormView extends TPage
{
    /**
     * Show data
     */
    public function onEdit( $param )
    {
        try
        {
            // convert parameter to object
            $data = (object) $param;
            
            // load the html template
            $html = new THtmlRenderer('app/resources/secretariatipoformview.html');
            
            TTransaction::open('conexao');
            if (isset($data->sectipocodigo))
            {
                // load customer identified in the form
                $object = SecretariaTipo::find( $data->sectipocodigo );
                if ($object)
                {
                    // create one array with the customer data
                    $array_object = $object->toArray();
                    
                    // replace variables from the main section with the object data
                    $html->enableSection('main',  $array_object);
                }
                else
                {
                    throw new Exception('SecretariaTipo not found');
                }
            }
            else
            {
                throw new Exception('<b>sectipocodigo</b> not detected in parameters');
            }
            
            TTransaction::close();
            
            // vertical box container
            $container = new TVBox;
            $container->style = 'width: 90%';
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
            $container->add($html);
            parent::add($container);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}
