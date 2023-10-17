<?php

class ZotaPay
{
    private $access_type; // 0 testing, 1 production
    private $merchantId = 'FOREXMART';

    protected $url = [
        '0' => 'https://api.zotapay-sandbox.com/api/v1/deposit/request/',
        '1' => 'https://mg-api.zotapay.com/api/v1/deposit/request/',
      ];

    protected $secretKey = [
        '0' => '1d3c5670-144b-4a14-b132-c2a377c191ef',
        '1' => 'f5b255bb-4d09-487e-93e0-ed47b8d81cf1',
      ];

    protected $endpointIDs = [
        '0' => [
              'THB' => 503762,
              'VND' => 503761,
              'MYR' => 503760,
              'CNY' => 503759,
            ],

        '1' => [
              'THB' => 406414,
              'VND' => 406415,
              'MYR' => 406416,
              'IDR' => 406417,
              'USD' => 406599, //credit card
              'EUR' => 406598, //credit card
           ],
    ];

    public function setAccessType($type)
    {
        $this->access_type = $type;
    }

    public function getAccessType()
    {
        return $this->access_type;
    }

    public function getMerchantSecretKey()
    {
        return $this->secretKey[$this->getAccessType()];
    }

    private function getPaymentData($params = [])
    {
        $concatData = strtolower($this->endpointIDs[$this->getAccessType()][$params['orderCurrency']].$params['merchantOrderID'].$params['orderAmount'].$params['customerEmail'].$this->secretKey[$this->getAccessType()]);
        $signature = hash('sha256', $concatData);

        $parameters =
            [
                'merchantOrderID' => $params['merchantOrderID'],
                'merchantOrderDesc' => $params['merchantOrderDesc'],
                'orderAmount' => $params['orderAmount'],
                'orderCurrency' => $params['orderCurrency'],
                'customerEmail' => $params['customerEmail'],
                'customerFirstName' => $params['customerFirstName'],
                'customerLastName' => $params['customerLastName'],
                'customerAddress' => $params['customerAddress'],
                'customerCountryCode' => $params['customerCountryCode'],
                'customerCity' => $params['customerCity'],
                'customerZipCode' => $params['customerZipCode'],
                'customerState' => $params['customerState'],
                'customerPhone' => $params['customerPhone'],
                'customerIP' => $params['customerIP'],
                'redirectUrl' => 'https://my.forexmart.com/deposit/zotapay-return',
                'callbackUrl' => 'https://my.forexmart.com/deposit/zotapay-callback',
                'checkoutUrl' => 'https://my.forexmart.com/deposit/zotapay',
        ];

        $parameters['signature'] = $signature;

        return $parameters;
    }

    public function paymentRequest($params = [])
    {
        $data = $this->getPaymentData($params);

        $url = $this->url[$this->getAccessType()].$this->endpointIDs[$this->getAccessType()][$params['orderCurrency']].'/';
        // if (IPloc::IPOnlyForVenus() || $_SERVER['REMOTE_ADDR'] == '195.201.40.47') {
        //     echo $url;
        //     echo '<pre>';
        //     var_dump($data);
        // }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($ch);
        curl_close($ch);

        if ($return) {
            $decode = json_decode($return, true);

            // if (IPloc::IPOnlyForVenus() || $_SERVER['REMOTE_ADDR'] == '195.201.40.47') {
            //     echo $url;
            //     echo '<pre>';
            //     var_dump($data);
            //     var_dump($decode);
            //     exit();
            // }

            return $decode;
        } else {
            return false;
        }
    }


    public function orderStatusRequest($data)
    {
        $dataToSign = [
            $data['merchantID'],
            $data['merchantOrderID'],
            $data['orderID'],
            $data['timestamp'],
            $this->secretKey[0], // live - secret key
        ];
        $stringToSign = implode($dataToSign);
        $data['signature'] = hash('sha256', $stringToSign);
        $qs = http_build_query($data);
        // $api_base = 'https://api.zotapay.com/api/v1/query/order-status/?'.$qs;
        $api_base = 'https://api.zotapay-sandbox.com/api/v1/query/order-status/?'.$qs;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $api_base,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            $decodeOrder = json_decode($response, true);

            return $decodeOrder;
        } else {
            return false;
        }
    }


    public function getStateCode($countryCode){
        $state = [
            'AU' => [
                'AC' => 'Australian Capital Territory',
                'NS' => 'New South Wales',
                'NT' => 'Northern Territory',
                'QL' => 'Queensland',
                'SA' => 'South Australia',
                'TA' => 'Tasmania',
                'VI' => 'Victoria',
                'WA' => 'Western Australia',
           ],
            'CA' => [
                'AB' => 'Alberta',
                'BC' => 'British Columbia',
                'MB' => 'Manitoba',
                'NB' => 'New Brunswick',
                'NL' => 'Newfoundland and Labrador',
                'NT' => 'Northwest Territories',
                'NS' => 'Nova Scotia',
                'NU' => 'Nunavut',
                'ON' => 'Ontario',
                'PE' => 'Prince Edward Island',
                'QC' => 'Quebec',
                'SK' => 'Saskatchewan',
                'YT' => 'Yukon',
           ],
            'US' => [
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AS' => 'American Samoa',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                'CO' => 'Colorado',
                'CT' => 'Connecticut',
                'DE' => 'Delaware.',
                'DC' => 'District of Columbia',
                'FL' => 'Florida',
                'GA' => 'Georgia',
                'GU' => 'Guam',
                'HI' => 'Hawaii',
                'ID' => 'Idaho',
                'IL' => 'Illinois',
                'IN' => 'Indiana',
                'IA' => 'Iowa',
                'KS' => 'Kansas',
                'KY' => 'Kentucy',
                'LA' => 'Louisiana',
                'ME' => 'Maine',
                'MD' => 'Maryland',
                'MA' => 'Massachusetts',
                'MI' => 'Michigan',
                'MN' => 'Minnesota',
                'MS' => 'Mississippi',
                'MO' => 'Missouri',
                'MT' => 'Montana',
                'NE' => 'Nebraska',
                'NV' => 'Nevada',
                'NH' => 'New Hampshire',
                'NJ' => 'New Jersey',
                'NC' => 'North Carolina',
                'NM' => 'New Mexico',
                'NY' => 'New York',
                'ND' => 'North Dakota',
                'OH' => 'Ohio',
                'OK' => 'Oklahoma',
                'OR' => 'Oregon',
                'PA' => 'Pennsylvania',
                'PR' => 'Puerto Rico',
                'RI' => 'Rhode Island',
                'SC' => 'South Carolina',
                'SD' => 'South Dakota',
                'TN' => 'Tennessee',
                'TX' => 'Texas',
                'UT' => 'Utah',
                'VT' => 'Vermont',
                'VI' => 'Virgin Islands',
                'VA' => 'Virginia',
                'WA' => 'Washington',
                'WV' => 'West Virginia',
                'WI' => 'Wisconsin',
                'WY' => 'Wyoming',
            ]
        ];

        return $state[$countryCode];




    }
}
