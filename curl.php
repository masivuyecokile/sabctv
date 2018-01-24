<?php
ini_set("default_socket_timeout", 6000);
require_once('curl2.php');

$wdsl    = "https://secure4.tvlic.co.za/AccountEnquiryService_Test_1.0/AccountEnquiryService.svc?wsdl";
$opts = array(
    'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
);

$context = stream_context_create($opts);

$soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
    );



   $client = new SoapClientCurl($wdsl,$soapClientOptions);
   $client->__setLocation('https://secure4.tvlic.co.za/AccountEnquiryService_1.0/AccountEnquiryService.svc');
$arrParams = array(
                'request' => array(
                    'Header' => array(
                        'Rquid' => '40CB7049-331F-874D-1841-48DE403D308C',
                        'ApiKey' => '2c261e98-90ca-4f7d-90a0-1f5e91ebf416 '
                    ),
                    'AccountIdentifier' => "99292992",
                    'AccountIdentifierType' => 'SaidNumber'
                )
            );
            // request parameters passed in the body not the header
            $account   = $client->GetAccount($arrParams);
            echo json_encode($account);