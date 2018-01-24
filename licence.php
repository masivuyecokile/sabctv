<?php
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
//Generate GUID
function getGUID()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid   = chr(123) // "{"
            . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12) . chr(125); // "}"
        return trim($uuid, '{}');
    }
}

$quid = getGUID();


$licencetype = isset($_POST['licencetype']) ? $_POST['licencetype'] : NULL;
switch ($licencetype) {
    
    case 'domestic':
        $holder_id = isset($_POST['holder_id']) ? $_POST['holder_id'] : NULL;
        try {
            $client = new SoapClient($wdsl, $soapClientOptions);
            $client->__setLocation('https://secure4.tvlic.co.za/AccountEnquiryService_1.0/AccountEnquiryService.svc');
            // setup parameters
            $arrParams = array(
                'request' => array(
                    'Header' => array(
                        'Rquid' => $quid,
                        'ApiKey' => '2c261e98-90ca-4f7d-90a0-1f5e91ebf416'
                    ),
                    'AccountIdentifier' => $holder_id,
                    'AccountIdentifierType' => 'SaidNumber'
                )
            );
            // request parameters passed in the body not the header
            $account   = $client->GetAccount($arrParams);
            echo json_encode($account);
        }
        catch (\Exception $e) {
            echo "Error!";
            echo json_encode($e->getMessage());
            echo 'Last response: ' . $client->__getLastResponse();
        }
        break;
    
    case 'business':
        $tvlicencenumber = isset($_POST['tvlicence']) ? $_POST['tvlicence'] : NULL;
        try {
            $client = new SoapClient($wdsl, $soapClientOptions);
            $client->__setLocation('https://secure4.tvlic.co.za/AccountEnquiryService_1.0/AccountEnquiryService.svc');
            // setup parameters
            $arrParams = array(
                'request' => array(
                    'Header' => array(
                        'Rquid' => $quid,
                        'ApiKey' => '2c261e98-90ca-4f7d-90a0-1f5e91ebf416 '
                    ),
                    'AccountIdentifier' => $tvlicencenumber,
                    'AccountIdentifierType' => 'AccountNumber'
                )
            );
            // request parameters passed in the body not the header
            $account   = $client->GetAccount($arrParams);
            echo json_encode($account);
        }
        catch (\Exception $e) {
            echo "Error!";
            echo json_encode($e->getMessage());
            echo 'Last response: ' . $client->__getLastResponse();
        }
        break;
    
    case 'dealer':
        $tvlicencenumber = isset($_POST['tvlicence']) ? $_POST['tvlicence'] : NULL;
        try {
            $client = new SoapClient($wdsl, $soapClientOptions);
            $client->__setLocation('https://secure4.tvlic.co.za/AccountEnquiryService_1.0/AccountEnquiryService.svc');
            // setup parameters
            $arrParams = array(
                'request' => array(
                    'Header' => array(
                        'Rquid' => $quid,
                        'ApiKey' => '2c261e98-90ca-4f7d-90a0-1f5e91ebf416 '
                    ),
                    'AccountIdentifier' => $tvlicencenumber,
                    'AccountIdentifierType' => 'AccountNumber'
                )
            );
            // request parameters passed in the body not the header
            $account   = $client->GetAccount($arrParams);
            echo json_encode($account);
        }
        catch (\Exception $e) {
            echo "Error!";
            echo json_encode($e->getMessage());
            echo 'Last response: ' . $client->__getLastResponse();
        }
        break;
    
    default:
        
        echo json_encode('Please select licence type');
}
?>