<?php

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$params = array('username' => $username, 'password' => $password);
$soap_client = new SoapClient('https://passport.psu.ac.th/authentication/authentication.asmx?WSDL');
$soap_auth = $soap_client->Authenticate($params);
$now = new DateTime();

if ($soap_auth->AuthenticateResult) {
    $soapResult = $soap_client->GetUserDetails($params);
    $firstName = $soapResult->GetUserDetailsResult->string[1];
    $lastName = $soapResult->GetUserDetailsResult->string[2];
    $studentId = $soapResult->GetUserDetailsResult->string[3];
    $gender = $soapResult->GetUserDetailsResult->string[4];
    $personalId = $soapResult->GetUserDetailsResult->string[5];
    $faculty = $soapResult->GetUserDetailsResult->string[8];
    $campus = $soapResult->GetUserDetailsResult->string[10];
    $prefix = $soapResult->GetUserDetailsResult->string[12];
    $email = $soapResult->GetUserDetailsResult->string[13];

    $userDetail = array(
        'prefix' => $prefix,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'studentId' => $studentId,
        'email' => $email,
        'gender' => $gender == 'M' ? "Male" : "Female",
        'idNumber' => $personalId,
        'faculty' => $faculty,
        'campus' => $campus,
        'timeStamp' => $now->format('Y-m-d H:i:s')
    );

    echo json_encode($userDetail);

} else {
    echo json_encode(
        [
            'authentication' => $soap_auth->AuthenticateResult,
            'timeStamp' => $now->format('Y-m-d H:i:s')
        ]);
}