<?php

namespace app\library;

use Google\Client;
use GuzzleHttp\Client as GuzzleClient;

class GoogleClient
{
    public readonly Client $client;
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
        $this->client->setAuthConfig("credentials.json");
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
            var_dump($token);
        }
    }
}
