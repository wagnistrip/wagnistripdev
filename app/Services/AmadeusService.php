<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;
use SimpleXMLElement;
class AmadeusService
{
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $accessTokenExpiry;
    private $client;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->client = new Client(['base_uri' => 'https://test.api.amadeus.com']);
    }

    public function getAccessToken(): string
    {
        if (empty($this->accessToken) || time() >= $this->accessTokenExpiry) {
            $this->fetchAccessToken();
        }
        return $this->accessToken;
      
    }

    private function fetchAccessToken(): void
    {
        try {
            $response = $this->client->post('/v1/security/oauth2/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new Exception('Failed to retrieve access token: ' . $response->getBody());
            }

            $data = json_decode($response->getBody(), true);
            $this->accessToken = $data['access_token'];
            $this->accessTokenExpiry = time() + $data['expires_in'];

        } catch (RequestException $e) {
            // Log::error('Amadeus Access Token Error', [
            //     'message' => $e->getMessage(),
            //     'response' => $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : null,
            // ]);
            throw new Exception('Failed to fetch access token.');
        }
    }
    public function request(string $method, string $endpoint, array $options)
    {
        try {
            $response = $this->client->request($method, $endpoint, $options);

            // Log request and response
            $this->logAmadeusRequest($method, $endpoint, $options, $response, 'request_success');

            return $response;
        } catch (RequestException $e) {
            // Log error if request fails
            $this->logAmadeusRequest($method, $endpoint, $options, null, 'request_failed', $e->getMessage(), $e->getCode());
            throw $e;
        }
    }

    public function logAmadeusRequest(string $method, string $url, array $requestOptions, $response, string $status, string $errorMessage = null, int $errorCode = null)
    {
        $logData = [
            'request' => [
                'method' => $method,
                'url' => $url,
                'data' => $requestOptions['json'] ?? [],
            ],
        ];
        if ($response) {
            $logData['response'] = [
                'status_code' => $response->getStatusCode(),
                'headers' => $response->getHeaders(),
                'body' => json_decode($response->getBody(), true),
            ];
        } else {
            $logData['error'] = [
                'message' => $errorMessage,
                'code' => $errorCode,
            ];
        }

        // Convert log data to XML
        $xml = $this->arrayToXml($logData, new SimpleXMLElement('<amadeus_request></amadeus_request>'));

        // Generate a unique filename for each log
        $date = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "amadeus_{$status}_{$date}.xml";
        $logPath = storage_path('logs/amadeus');

        // Create log directory if it doesn't exist
        if (!is_dir($logPath)) {
            mkdir($logPath, 0775, true);
        }

        // Write the XML log to a file
        file_put_contents($logPath . '/' . $filename, $xml->asXML());
    }

    private function arrayToXml($data, SimpleXMLElement $xml)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key; // Change numeric keys to 'item<key>'
            }
            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
        return $xml;
    }

}
