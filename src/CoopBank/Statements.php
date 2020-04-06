<?php


namespace Bennito254\CoopBank;


class Statements extends \Bennito254\CoopBank\Bank
{
    public function __construct()
    {
        parent::__construct();
    }

    public function miniStatement($accountNumber, $messageReference)
    {
        $live_url = "http://developer.co-opbank.co.ke:8280/Enquiry/MiniStatement/Account/1.0.0";
        $url = "https://developer.co-opbank.co.ke:8243/Enquiry/MiniStatement/Account/1.0.0";

        $data = [
            'MessageReference' => $messageReference,
            'AccountNumber' => $accountNumber
        ];

        return $this->sendRequest($url, $data);
    }

    public function fullStatement($accountNumber, $messageReference, $startDate, $endDate)
    {
        $live_url = "http://developer.co-opbank.co.ke:8280/Enquiry/FullStatement/Account/1.0.0";
        $url = "https://developer.co-opbank.co.ke:8243/Enquiry/FullStatement/Account/1.0.0";

        $data = [
            'MessageReference' => $messageReference,
            'AccountNumber' => $accountNumber,
            'StartDate' => $startDate,
            'EndDate' => $endDate
        ];

        return $this->sendRequest($url, $data);
    }
}