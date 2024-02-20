<?php

namespace app\library;

use Google\Client;
use Google\Service\Oauth2;
use Google\Service\Oauth2\Userinfo;
use GuzzleHttp\Client as GuzzleClient;

class GoogleClient
{
    public readonly Client $client;
    private Userinfo $data;
    public function __construct()
    {
        $this->client = new Client;
    }

    public function init()
    {
        $guzzleClient = new GuzzleClient([
            "curl" => [
                CURLOPT_SSL_VERIFYPEER => false,
            ]
        ]);
        $this->client->setHttpClient($guzzleClient);
        $this->client->setAuthConfig(__DIR__ . "/../../credentials.json");
        $this->client->setRedirectUri("http://localhost:9090");
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function generateAuthLink()
    {
        return $this->client->createAuthUrl();
    }

    public function authorized()
    {
        if (isset($_GET["code"])) {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET["code"]);
            $this->client->setAccessToken($token["access_token"]);

            $googleService = new Oauth2($this->client);
            $this->data = $googleService->userinfo->get();
            // var_dump($this->data);
        }
    }

    public function getData()
    {
        return $this->data;
    }
}
