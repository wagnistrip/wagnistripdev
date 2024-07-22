<?php
namespace App\Services;

use GuzzleHttp\Client;

class EasebuzzService
{
    protected $client;
    protected $apiKey;
    protected $apiSecret;
    protected $merchantId;

    public function __construct($apiKey , $apiSecret , $merchantId)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.easebuzz.in/', // Replace with the correct API URL
        ]);
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->merchantId = $merchantId;
    }

    public function initiatePayment($data)
    {
        // Example API request for payment initiation
        $response = $this->client->post('/payment/initiate', [
            'form_params' => array_merge($data, [
                'api_key' => $this->apiKey,
                'merchant_id' => $this->merchantId,
            ]),
        ]);
        return json_decode($response->getBody()->getContents());
    }

    public function verifyPayment($data)
    {
        // Example API request for payment verification
        $response = $this->client->post('/payment/verify', [
            'form_params' => array_merge($data, [
                'api_secret' => $this->apiSecret,
            ]),
        ]);

        return json_decode($response->getBody()->getContents());
    }
}



