<?php
/**
 * Created by PhpStorm.
 * User: MAGNUSOFT-PC
 * Date: 2/20/2019
 * Time: 11:59 AM
 */
 use Facebook\Facebook;

class FacebookAuth extends Facebook
{
    private $token;

    public function __construct()
    {

            parent::__construct(
                [
                    'app_id' => '2485915204769831',
                    'app_secret' => '{app-secret}',
                    'default_graph_version' => 'v3.2',
                    //'default_access_token' => '{access-token}', // optional
                ]
            );
    }

    function getToken(){
        try {
            $response = $this->get(
                '/288245738509481',
                '{access-token}'
            );
        } catch(FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
    }

    function postar(){
        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $this->post(
                '/288245738509481/feed',
                array (
                    'message' => 'Teste postagem pelo site'
                ),
                '{access-token}'
            );
        } catch(FacebookExceptionsFacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookExceptionsFacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $response->getGraphNode();
    }

}