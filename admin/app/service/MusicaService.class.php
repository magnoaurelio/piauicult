<?php
/**
 * Created by PhpStorm.
 * User: Marcelo
 * Date: 16/07/2019
 * Time: 23:35
 */

class MusicaService extends \Adianti\Service\AdiantiRecordService
{
    const DATABASE = "conexao";
    const ACTIVE_RECORD = Musica::class;

    public function getMusicasAleatorias($param)
    {
        \Adianti\Database\TTransaction::open(self::DATABASE);
         $musicas = Musica::where("musaudio","IS NOT", null)->take(20)->orderBy("RAND()")->load();
         $response =  [];

         foreach ($musicas as $musica){
                $dados = $musica->toArray();
                $artista = new Artista($musica->artcodigo);
                $filenamme =  FILEPATH."musicas/audio/".$musica->musaudio;
                $dados["file"] = $filenamme;
                $dados["codigo"] = $musica->muscodigo;
                $dados["title"] = $musica->musnome;
                $dados["artista"] = $artista->toArray();
                $disco =  MusicaDisco::where("muscodigo", "=", $musica->muscodigo)->take(1)->load();
                if ($disco) {
                    $disco =  $disco[0];
                    $disc = new Disco($disco->discodigo);
                    $dados["disco"] = $disc->toArray();
                }
                $dados["howl"] = null;

                $response[] =  $dados;
         }

        \Adianti\Database\TTransaction::close();

        return $response;

    }

    public function getMusicasDisco($param)
    {
        \Adianti\Database\TTransaction::open(self::DATABASE);
        $disco = new Disco($param["discodigo"]);
        $musicas = $disco->getMusicas();
        $response =  [];

        foreach ($musicas as $musica){
            $dados = $musica->toArray();
            $artista = new Artista($musica->artcodigo);
            $filenamme =  FILEPATH."musicas/audio/".$musica->musaudio;
            $dados["file"] = $filenamme;
            $dados["codigo"] = $musica->muscodigo;
            $dados["title"] = $musica->musnome;
            $dados["artista"] = $artista->toArray();
            $disco =  MusicaDisco::where("muscodigo", "=", $musica->muscodigo)->take(1)->load();
            if ($disco) {
                $disco =  $disco[0];
                $disc = new Disco($disco->discodigo);
                $dados["disco"] = $disc->toArray();
            }
            $dados["howl"] = null;

            $response[] =  $dados;
        }

        \Adianti\Database\TTransaction::close();

        return $response;

    }

}