<?php

namespace kubacode;

use GuzzleHttp\Client;

/**
 * Class telstraSMS
 * @package kubacode\telstraSMS
 */
class telstraSMS
{
    const API_URL = 'https://api.telstra.com/';
    const API_VERSION = 'v1';

    /**
     * @var Client
     */
    private $client;

    private $clientID;

    private $clientSecret;

    private $accessToken;

    /**
     * telstraSMS constructor.
     */
    public function __construct($clientID, $clientSecret)
    {
        $client = new Client([
            'base_uri' => self::API_URL . self::API_VERSION . '/'
        ]);

        $this->client = $client;

        $this->clientID = $clientID;

        $this->clientSecret = $clientSecret;

        $this->authenticate();
    }

    /**
     *
     */
    private function authenticate()
    {
        $response = $this->client->get('oauth/token',
            ['query' => [
                'client_id' => $this->clientID,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'scope' => 'SMS'
            ]]);

        $accessToken = json_decode($response->getBody())->access_token;

        $this->accessToken = $accessToken;
    }

    /**
     * @param $to
     * @param $body
     * @return mixed
     */
    public function send($to, $body)
    {
        $to = $this->formatNumber($to);

        $response = $this->client->post('sms/messages', [
               'headers' => [
                   'Authorization' => 'Bearer '.$this->accessToken,
                   'Content-Type' => 'application/json'
               ],
                'json' => [
                    'to' => $to,
                    'body' => $body
                ]
            ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $messageID
     * @return mixed
     */
    public function getStatus($messageID)
    {
        $response = $this->client->get('sms/messages/'.$messageID, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->accessToken
            ]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $messageID
     * @return mixed
     */
    public function getResponse($messageID)
    {
        $response = $this->client->get('sms/messages/'.$messageID.'/response', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->accessToken
            ]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $number
     * @return mixed
     */
    private function formatNumber($number)
    {
        return str_replace(' ', '', $number);
    }


}