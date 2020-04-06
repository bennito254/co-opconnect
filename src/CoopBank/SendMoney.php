<?php


namespace Bennito254\CoopBank;


use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class SendMoney extends \Bennito254\CoopBank\Bank
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Send money to M-Pesa phone numbers
     *
     * @param string $accountNumber The Account Number
     * @param string $messageReference
     * @param string $callbackURL
     * @param string $currency
     * @param int $amount
     * @param array $destinations
     * @param string $narration
     * @return bool|string|null
     */
    public function sendToMpesa($accountNumber, $messageReference, $callbackURL, $currency = 'KES', $amount = 0, $destinations = array(), $narration = "Send to M-Pesa")
    {
        $url = "https://developer.co-opbank.co.ke:8243/FundsTransfer/External/A2M/Mpesa/v1.0.0";
        $data = [
            'MessageReference' => $messageReference,
            'CallBackUrl' => $callbackURL,
            'Source' => [
                'AccountNumber' => $accountNumber,
                'Amount' => $amount,
                'TransactionCurrency' => $currency,
                'Narration' => $narration
            ],
            'Destinations' => [$destinations]
        ];

        return $this->sendRequest($url, $data);
    }

    /**
     * @param $accountNumber
     * @param $messageReference
     * @param $callbackURL
     * @param string $currency
     * @param int $amount
     * @param array $destinations
     * @param string $narration
     * @return bool|string|null
     */
    public function pesalinkSendToAccount($accountNumber, $messageReference, $callbackURL, $currency = 'KES', $amount = 0, $destinations = array(), $narration = "Send to PesaLink")
    {
        $url = "https://developer.co-opbank.co.ke:8243/FundsTransfer/External/A2A/PesaLink/1.0.0";
        $data = [
            'MessageReference' => $messageReference,
            'CallBackUrl' => $callbackURL,
            'Source' => [
                'AccountNumber' => $accountNumber,
                'Amount' => $amount,
                'TransactionCurrency' => $currency,
                'Narration' => $narration
            ],
            'Destinations' => [$destinations]
        ];

        //return json_encode($data);
        return $this->sendRequest($url, $data);
    }

    public function accountToAccount($accountNumber, $messageReference, $callbackURL, $currency = 'KES', $amount = 0, $destinations = array(), $narration = "Send to Account")
    {
        $url = "https://developer.co-opbank.co.ke:8243/FundsTransfer/Internal/A2A/2.0.0";
        $data = [
            'MessageReference' => $messageReference,
            'CallBackUrl' => $callbackURL,
            'Source' => [
                'AccountNumber' => $accountNumber,
                'Amount' => $amount,
                'TransactionCurrency' => $currency,
                'Narration' => $narration
            ],
            'Destinations' => [$destinations]
        ];

        return $this->sendRequest($url, $data);
    }

    public function INSSimulation($data, $callbackUrl = 'https://dev.bennito254.com/cb.php', $endpointCredential = 'WeLoveUsTillTheEndOfTime')
    {
        $live_url = "http://developer.co-opbank.co.ke:8280/Notifications/INS/Simulation/1.0.0";
        $url = "https://developer.co-opbank.co.ke:8243/Notifications/INS/Simulation/1.0.0/Transaction";

        $token = $this->getToken();
        if (!$token) {
            return FALSE;
        }
        try {
            $client = new Client(['verify' => false]);
            $request = $client->post($url, array(
                'headers' => array('Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'NotificationEndpoint' => $callbackUrl,
                    'EndpointCredential' => $endpointCredential
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
}