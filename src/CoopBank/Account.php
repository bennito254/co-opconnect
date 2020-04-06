<?php

namespace Bennito254\CoopBank;

class Account extends \Bennito254\CoopBank\Bank
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get balance of an account
     *
     * @param $accountNumber string|int The account number
     * @param $messageReference string Message Reference
     * @return bool|string
     */
    public function balance($accountNumber, $messageReference)
    {
        $url = "https://developer.co-opbank.co.ke:8243/Enquiry/AccountBalance/1.0.0";
        $live_url = "http://developer.co-opbank.co.ke:8280/Enquiry/AccountBalance/1.0.0";

        $data = [
            'MessageReference' => $messageReference,
            'AccountNumber' => $accountNumber
        ];

        return $this->sendRequest($url, $data);
    }

    /**
     * Get exchange rate
     * @param $messageReference
     * @param $fromCurrencyCode
     * @param $toCurrencyCode
     * @return bool|string|null
     */
    public function exchangeRate($messageReference, $fromCurrencyCode, $toCurrencyCode)
    {
        $url = "https://developer.co-opbank.co.ke:8243/Enquiry/ExchangeRate/1.0.0";
        $live_url = "http://developer.co-opbank.co.ke:8280/Enquiry/ExchangeRate/1.0.0";

        $data = [
            'MessageReference' => $messageReference,
            'FromCurrencyCode' => $fromCurrencyCode,
            'ToCurrencyCode' => $toCurrencyCode
        ];

        return $this->sendRequest($url, $data);
    }

    /**
     * Validate an account number
     *
     * @param $messageReference
     * @param $accountNumber
     * @return bool|string|null
     */
    public function validation($messageReference, $accountNumber)
    {
        $live_url = "http://developer.co-opbank.co.ke:8280/Enquiry/Validation/Account/1.0.0";
        $url = "https://developer.co-opbank.co.ke:8243/Enquiry/Validation/Account/1.0.0";

        $data = [
            'MessageReference' => $messageReference,
            'AccountNumber' => $accountNumber
        ];

        return $this->sendRequest($url, $data);
    }
}