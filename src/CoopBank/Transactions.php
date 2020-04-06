<?php


namespace Bennito254\CoopBank;

class Transactions extends \Bennito254\CoopBank\Bank
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get Transactions of a particular account
     *
     * @param $accountNumber string|int The account number
     * @param $messageReference string Message reference
     * @param bool|int $transactions string|int Number of transactions to fetch
     * @return bool|string|null
     */
    public function accountTransactions($accountNumber, $messageReference, $transactions = false)
    {
        $url = "https://developer.co-opbank.co.ke:8243/Enquiry/AccountTransactions/1.0.0/";
        $data = [
            'MessageReference' => $messageReference,
            'AccountNumber' => $accountNumber,
            'NoOfTransactions' => $transactions ? $transactions : 1
        ];

        return $this->sendRequest($url, $data);
    }

    /**
     * Get transaction status by MessageReference
     *
     * @param string $messageReference MessageReference
     * @return bool|string|null
     */
    public function transactionStatus($messageReference)
    {
        $live_url = "http://developer.co-opbank.co.ke:8280/Enquiry/TransactionStatus/2.0.0";
        $url = "https://developer.co-opbank.co.ke:8243/Enquiry/TransactionStatus/2.0.0";

        $data = [
            'MessageReference' => $messageReference
        ];

        return $this->sendRequest($url, $data);
    }
}