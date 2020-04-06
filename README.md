# CO-OP Connect
PHP wrapper for the Co-op Bank API at https://developer.co-opbank.co.ke:9443/store for the sandbox only.

Support for Production API will be coming soon!

## Installation
! Package Gist is not set up yet. The following won't work.
```$cli
composer require bennito254/co-opconnect
```

## Setup
Initialize the Bank class with Consumer Key, Consumer Secret and Production environment as arguments
```$php
$bank = \Bennito254\CoopBank\Bank($consumerKey, $consumerSecret, $env = 'sandbox'); //or live
```

## Usage
### Account Information
#### Account Balance
```$xslt
$accountNumber = "36001873000";
$messageReference = "Randomstr1ng";
$balance = $bank->account()->balance($accountNumber, $messageReference);
```
#### Exchange Rates
```$xslt
$messageReference = "Randomstr1ng";
$fromCurrency = "KES";
$toCurrency = "USD";
$rate = $bank->account()->exchangeRate($messageReference, $fromCurrency, $toCurrency);
```

#### Account Number Validation
```$xslt
$messageReference = "Randomstr1ng";
$accountNumberToCheck = "36001873000";
$rate = $bank->account()->validation($messageReference, $accountNumberToCheck);
```

### Send Money
#### Send To M-Pesa
```$xslt
$mpesa_destination = [
    'ReferenceNumber'   => 'Rand0mStrseing',
    'MobileNumber'      => "0716483805",
    'Amount'            => 10,
    'Narration'         => 'Awesome sendoff'
];
$response = $bank->sendMoney()->sendToMpesa('36001873000', 'newRandomString', 'https://dev.bennito254.com/cb.php', 'KES', 10, $mpesa_destination, 'Send to Bennito');
```

#### Send via PesaLink
```$xslt
$pesalink_destination = [
    'ReferenceNumber'   => 'Rand0mStringss',
    'AccountNumber'     => "54321987654321",
    'BankCode'          => "11",
    'Amount'            => 10,
    'TransactionCurrency'   => 'KES',
    'Narration'         => 'Awesome sendoff'
];
$response = $bank->sendMoney()->pesalinkSendToAccount('36001873000', 'newRandomString', 'https://dev.bennito254.com/cb.php', 'KES', 10, $pesalink_destination, 'Send to Bennito');
```

#### Send to Another Account
```$xslt
$account_destination = [
    'ReferenceNumber'   => 'Rand0mStringasss',
    'AccountNumber'     => "54321987654321",
    'Amount'            => 10,
    'TransactionCurrency'   => 'KES',
    'Narration'         => 'Awesome sendoff'
];
$response = $bank->sendMoney()->accountToAccount('36001873000', 'benniastweo23', 'https://dev.bennito254.com/cb.php', 'KES', 10, $account_destination, 'Send to Bennito');
```

#### Simulate Transaction
```$xslt
$simulation = [
    'MessageReference'      => 'jkgasjkfgsaf',
    'MessageDateTime'       => '2020-04-06T10:19:07.100Z',
    'ServiceName'           => '',
    'NotificationCode'      => '',
    'PaymentRef'            => 'REF000012323',
    'AccountNumber'         => '823547857835434',
    'Amount'                => "12000.00",
    'TransactionDate'       => '20190301165420',
    'EventType'             => 'DEBIT',
    'Currency'              => 'KES',
    'ExchangeRate'          => '1',
    'Narration'             => 'Supplier payments',
    'CustMemo'              => [
        'CustMemoLine1' => '785347855 75',
        'CustMemoLine2' => '',
        'CustMemoLine3' => ''
    ],
    'ValueDate'             => '20190301',
    'EntryDate'             => '20190301',
    'TransactionId'         => '8963478382745'
];
$response = $bank->sendMoney()->INSSimulation($simulation);
```

### Account Statements
#### Mini Statement
```$xslt
$accountNumber = '36001873000';
$messageReference = 'randomString';
$bank->statements()->miniStatement($accountNumber, $messageReference);
```
#### Full Statement
```$xslt
$accountNumber = '36001873000';
$messageReference = 'randomString';
$startDate = "2020-03-01";
$endDate = "2020-04-01";
$bank->statements()->miniStatement($accountNumber, $messageReference, $startDate, $endDate);
```

### Transactions
#### Latest Transactions
```$xslt
$accountNumber = '36001873000';
$messageReference = 'randomString';
$numberOfTransactions = "10";
$bank->transactions()->accountTransactions($accountNumber, $messageReference, $numberOfTransactions);
```

#### Transaction Status
```$xslt
$messageReference = 'ExistingRandomString';
$bank->transactions()->transactionStatus($messageReference);
```

## Licence
MIT Licence