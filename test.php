<?php
$wdsl = "https://secure4.tvlic.co.za/AccountEnquiryService_Test_1.0/AccountEnquiryService.svc?wsdl";

$options = array(
    'trace' => true,
    'exceptions' => true,
    'connection_timeout' => 1
);

try {
    $client = new SoapClient($wdsl, $options);
    $client->__setLocation('https://secure4.tvlic.co.za/AccountEnquiryService_Test_1.0/AccountEnquiryService.svc');
    
    // setup parameters
    $arrParams = array(
        'request' => array(
            'Header' => array(
                'Rquid' => '98739423-usd7fds6s0-dd7s7s0-a9a9s988',
                'ApiKey' => '5957237e-101c-4ff2-8fdc-4bd6c9393a1d'
            ),
            'AccountIdentifier' => '9211186012088',
            'AccountIdentifierType' => 'SaidNumber'
        )
    );
    
    // request parameters passed in the body not the header
    $account = $client->GetAccount($arrParams);
    
    $json = json_encode($account);
    
    echo $json;
    
}
catch (\Exception $e) {
    echo "Error!";
    echo $e->getMessage() . "<br>";
    echo 'Last response: ' . $client->__getLastResponse();
}
?>