<?php

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$params = array('username' => $username, 'password' => $password);
$soap_client = new SoapClient('https://passport.psu.ac.th/authentication/authentication.asmx?WSDL');
$soap_auth = $soap_client->Authenticate($params);
$now = new DateTime();

echo json_encode(
    [
        'authentication' => $soap_auth->AuthenticateResult,
        'timeStamp' => $now->format('Y-m-d H:i:s')
    ]);