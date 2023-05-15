<?php
//authentication
///error_reporting(E_ALL);
//ini_set('display_errors', 1);

$host = "https://accept.paymobsolutions.com/api/auth/tokens";
$token = '';
$token = '';
$json = '{
  "api_key": ""
}';


//$payloadName = array("client_id"=>$client, "client_secret"=>$secret,"code"=>$code);
$additionalHeaders = array(
    "Content-Type: application/json"
  );


$chm = curl_init($host);

curl_setopt($chm, CURLOPT_HTTPHEADER, $additionalHeaders);
//curl_setopt($chm, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_USERPWD, "");
curl_setopt($chm, CURLOPT_TIMEOUT, 30);
curl_setopt($chm, CURLOPT_POST, 1);
curl_setopt($chm, CURLOPT_POSTFIELDS, $json);
curl_setopt($chm, CURLOPT_RETURNTRANSFER, TRUE);
$return1 = curl_exec($chm);
curl_close($chm);
//print_r($return1);
$return1 = json_decode($return1);
$token = $return1->token;

//print_r($return1);
//exit;
//merchant id 2087
unset($chm);
unset($return1);
$time = time();
//exit;
$host2 = "https://accept.paymobsolutions.com/api/ecommerce/orders?token=$token";
$json2 = '{
  "access_token": "'.$token.'",
  "delivery_needed": "true",
  "merchant_id": "",
  "amount_cents": "",
  "currency": "EGP",
  "merchant_order_id": '.$time.',
  "shipping_data": {
    "apartment": "", 
    "email": "", 
    "floor": "", 
    "first_name": "", 
    "street": "",
    "building": "", 
    "phone_number": "+", 
    "postal_code": "", 
    "city": "", 
    "country": "EG", 
    "last_name": "", 
    "state": ""
  }
}';
//echo "hi";
$chm = curl_init($host2);

curl_setopt($chm, CURLOPT_HTTPHEADER, $additionalHeaders);
//curl_setopt($chm, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_USERPWD, "");
curl_setopt($chm, CURLOPT_TIMEOUT, 30);
curl_setopt($chm, CURLOPT_POST, 1);
curl_setopt($chm, CURLOPT_POSTFIELDS, $json2);
curl_setopt($chm, CURLOPT_RETURNTRANSFER, TRUE);
$return1 = curl_exec($chm);
curl_close($chm);
//print_r($return1);
$return1 = json_decode($return1);
//print_r($return1);
$orderid = $return1->shipping_data->order_id;
//echo "$orderid";
unset($return1);
unset($chm);
//exit;
//request payment link - 3rd step
$json = '{
  "auth_token": "'.$token.'",
  "amount_cents": "",
  "expiration": ,
  "order_id": "'.$orderid.'",
  "billing_data": {
    "apartment": "1",
    "email": "",
    "floor": "",
    "first_name": "",
    "street": "",
    "building": "5",
    "phone_number": "+",
    "shipping_method": "UNK",
    "postal_code": "",
    "city": "",
    "country": "EG",
    "last_name": "",
    "state": ""
  }, 
  "currency": "EGP", 
  "integration_id": ,
  "lock_order_when_paid": "false"
}';
$host = "https://accept.paymobsolutions.com/api/acceptance/payment_keys?token='.$token.'";
//$host = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";


//$json = json_decode($json);
//print_r($json);
//exit;
$chm = curl_init($host);

curl_setopt($chm, CURLOPT_HTTPHEADER, $additionalHeaders);
//curl_setopt($chm, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_USERPWD, "");
curl_setopt($chm, CURLOPT_TIMEOUT, 30);
curl_setopt($chm, CURLOPT_POST, 1);
curl_setopt($chm, CURLOPT_POSTFIELDS, $json);
curl_setopt($chm, CURLOPT_RETURNTRANSFER, TRUE);
$return1 = curl_exec($chm);
curl_close($chm);
//print_r($return1);
$return1 = json_decode($return1);
//print_r($return1);
$paytoken =  $return1->token;
//echo "$paytoken";
$iframe = '';

$json = '{
  "source": {
    "identifier": "", 
    "subtype": "WALLET"
  },
  "payment_token": "'.$paytoken.'"
}';
$host = "https://accept.paymobsolutions.com/api/acceptance/payments/pay?token=$token";
  
//echo "$host";
$chm = curl_init($host);

curl_setopt($chm, CURLOPT_HTTPHEADER, $additionalHeaders);
//curl_setopt($chm, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_USERPWD, "");
curl_setopt($chm, CURLOPT_TIMEOUT, 30);
curl_setopt($chm, CURLOPT_POST, 1);
curl_setopt($chm, CURLOPT_POSTFIELDS, $json);
curl_setopt($chm, CURLOPT_RETURNTRANSFER, TRUE);
$return1 = curl_exec($chm);
curl_close($chm);
//print_r($return1);
$return1 = json_decode($return1);
//print_r($return1);
echo '<a href="'.$return1->redirect_url.'">please pay here!</a>';
//print_r($return1->token);

//iframe id 
?>
