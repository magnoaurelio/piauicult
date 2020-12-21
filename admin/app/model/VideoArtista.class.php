<?php
/**
 * VideoArtista Active Record
 * @author  <your-name-here>
 */
class VideoArtista extends TRecord
{
    const TABLENAME = 'video_artista';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id_video');
        parent::addAttribute('id_artista');
    }


}
