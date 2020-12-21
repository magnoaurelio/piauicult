<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 8/9/2018
 * Time: 9:07 AM
 */

class Request
{
    private $URL;
    private $cURL;

    /**
     * Request constructor.
     * @param $cURL
     */
    public function __construct($URL)
    {
        $this->URL = $URL;
    }


    /**
     * @return mixed
     */
    private function getURL()
    {
        return $this->URL;
    }

    /**
     * @param mixed $URL
     */



    public function onRequest($endPoint, $dados, $decode=true){
        $ch = curl_init($this->getURL().$endPoint);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
        curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent );
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
        $object = curl_exec($ch);
        if($object === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        if ($decode)
            $object = json_decode($object);

        curl_close($ch);

        return $object;
    }
}