<?php
/**
 * Videos Active Record
 * @author  <your-name-here>
 */
class Videos extends TRecord
{
    const TABLENAME = 'videos';
    const PRIMARYKEY= 'vidcodigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('artcodigo');
        parent::addAttribute('vidurl');
        parent::addAttribute('vidliberado');
        parent::addAttribute('viddata');
        parent::addAttribute('vidtipo');
        parent::addAttribute('viddescricao');
        parent::addAttribute('vidfoto');
        parent::addAttribute('vidpublica');
        
    }
    function get_artista(){
        return new Artista($this->artcodigo);
    }


    function getArtistas () {
        $repository = new TRepository('VideoArtista');
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id_video','=', $this->vidcodigo));
        $collection = $repository->load($criteria);
        $artistas = array();
        if ($collection){
            foreach ($collection as $video_artista){
                $artista = new Artista($video_artista->id_artista);
                $artistas[] =  $artista;
            }
        }
        return $artistas;
        
    }

    function getArtista($id){
        $repository = new TRepository('VideoArtista');
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id_video','=', $this->vidcodigo));
        $criteria->add(new TFilter('id_artista','=', $id));
        $collection =  $repository->load($criteria);
        return $collection ? $collection[0] : null;
    }


    function addArtistaSave ($id) {
        if (!$this->existeArtista($id)) {
            $video_artista = new VideoArtista();
            $video_artista->id_artista = $id;
            $video_artista->id_video = $this->vidcodigo;
            $video_artista->store();
        }
    }

    function removeArtistaSave ($id) {
        if ($this->existeArtista($id)) {
            $repository = new TRepository('VideoArtista');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('id_video','=', $this->vidcodigo));
            $criteria->add(new TFilter('id_artista','=', $id));
            $repository->delete($criteria);
        }
    }


    function existeArtista($id){
       return ($this->getArtista($id));
    }

}
