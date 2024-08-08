<?php

namespace App\Services\Easebuzz;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class EasebuzzService
{
    protected $key;
    protected $salt;
    protected $env;
    protected $client;
    protected $surl;
    protected $furl;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->key = env('EASEBUZZ_KEY');
        $this->salt = env('EASEBUZZ_SALT');
        $this->env = env('EASEBUZZ_ENV', 'test'); // default to 'test' if not set
        $this->surl = route('payment.success');
        $this->furl = route('payment.failure');

        // Determine the base URL based on the environment
        $this->baseUrl = $this->env === 'production'
            ? 'https://pay.easebuzz.in/payment/initiateLink'
            : 'https://testpay.easebuzz.in/payment/initiateLink';
    }

    public function initiatePayment($data)
    {
        $hash = $this->generateHash($data);
        $data['key'] = $this->key;
        $data['hash'] = $hash;
        $data['surl'] = $this->surl;
        $data['furl'] = $this->furl;

        $response = $this->client->post($this->baseUrl, [
            'form_params' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function generateHash($data)
    {
        $hashSequence = $this->key . '|' . $data['txnid'] . '|' . $data['amount'] . '|' . $data['productinfo'] . '|' . $data['firstname'] . '|' . $data['email'] . '|||||||||||' . $this->salt;
        return hash('sha512', $hashSequence);
    }

    public function getPaymentRedirectUrl($data)
    {
        $baseUrl = $this->env === 'production' ? 'https://pay.easebuzz.in/v2/pay/' : 'https://testpay.easebuzz.in/v2/pay/';
        return $baseUrl . $data;
    }
}
