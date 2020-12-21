<?php
/**
 * Teatro Active Record
 * @author  <your-name-here>
 */
class Teatro extends TRecord
{
    const TABLENAME = 'teatro';
    const PRIMARYKEY= 'teacodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('teanome');
        parent::addAttribute('teagenero');
        parent::addAttribute('teaduracao');
        parent::addAttribute('teasobre');
        parent::addAttribute('teadata');
        parent::addAttribute('fescodigo');
        parent::addAttribute('teaimagem');
        parent::addAttribute('fesprecodigo');
    }


}
