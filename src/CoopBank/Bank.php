<?php


namespace Bennito254\CoopBank;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class Bank
{
    /**
     * @var string Consumer Key
     */
    private $consumerKey;
    /**
     * @var string Consumer Secret
     */
    private $consumerSecret;
    /**
     * @var string Environment
     */
    private $env;

    public function __construct($consumerKey = 'jcdMws6ujnyxinL1YQ3jevN9IYQa', $consumerSecret = 'UmWvyxAr_GtWU2MLec9MfLJtXoUa', $env = 'sandbox')
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->env = $env;
    }

    public function getToken()
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        try {
            $client = new Client(['verify' => false]);
            $request = $client->post('https://developer.co-opbank.co.ke:8243/token', array(
                'headers' => array('Authorization' => 'Basic ' . $credentials,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ),
                'body' => 'grant_type=client_credentials',
            ));
            $response = $request->getBody()->getContents();
            if ($response && $response = json_decode($response)) {
                return $response->access_token;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            //print_r($e->getMessage());
            return FALSE;
        }
    }

    public function sendRequest($url, $data)
    {
        $token = $this->getToken();
        if (!$token) {
            return FALSE;
        }
        try {
            $client = new Client(['verify' => false]);
            $request = $client->post($url, array(
                'headers' => array('Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ),
                'body' => json_encode($data),
            ));
            $response = $request->getBody()->getContents();
            if ($response) {
                return $response;
            } else {
                return FALSE;
            }
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            } else {
                return FALSE;
            }
        } catch (ServerException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            } else {
                return FALSE;
            }
        } catch (ConnectException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public function sendMoney() {
        return new \Bennito254\CoopBank\SendMoney();
    }

    public function account() {
        return new \Bennito254\CoopBank\Account();
    }

    public function statements() {
        return new \Bennito254\CoopBank\Statements();
    }

    public function transactions() {
        return new \Bennito254\CoopBank\Transactions();
    }
}