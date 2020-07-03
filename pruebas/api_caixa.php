<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "20443",
  CURLOPT_URL => "https://apis-i.redsys.es:20443/psd2/xs2a/api-entrada-xs2a/services/REPLACE_ASPSP/v1.1/accounts?withBalance=false",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Bearer 6yBnsqnMQQ",
    "consent-id: 7890-asdf-4321",
    "digest: REPLACE_THIS_VALUE",
    "psu-accept: REPLACE_THIS_VALUE",
    "psu-accept-charset: REPLACE_THIS_VALUE",
    "psu-accept-encoding: REPLACE_THIS_VALUE",
    "psu-accept-language: REPLACE_THIS_VALUE",
    "psu-device-id: c8d8515d-4319-4f85-bee8-8c5552999a45",
    "psu-geo-location: GEO:52.506931,13.144558",
    "psu-http-method: GET",
    "psu-ip-address: REPLACE_THIS_VALUE",
    "psu-ip-port: REPLACE_THIS_VALUE",
    "psu-user-agent: REPLACE_THIS_VALUE",
    "signature: REPLACE_THIS_VALUE",
    "tpp-signature-certificate: TestTPPCertificate",
    "x-ibm-client-id: REPLACE_THIS_KEY",
    "x-request-id: REPLACE_THIS_VALUE"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}