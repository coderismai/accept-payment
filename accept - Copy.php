<?php
//authentication
///error_reporting(E_ALL);
//ini_set('display_errors', 1);

//print_r($_GET);
//success
$success = $_GET['success'];

//check if the user has completed the payment
if($success != "")
{
switch ($success) {
  case 'true':
    echo "<b style='color:green;font-size:17px;'>You have successfully placed your order and made the payment!</b>";
    break;
  
  default:
  echo "<b style='color:red;font-size:17px;'>Your payment was not processed unfortunately!</b>";
      break;
}
exit;
}


//exchange tokens
$host = "https://accept.paymobsolutions.com/api/auth/tokens";
$token = '';


$json = '{
  "api_key": ""
}';


//$payloadName = array("client_id"=>$client, "client_secret"=>$secret,"code"=>$code);
$additionalHeaders = array(
//	"Host: .myshopify.com",
  //  "X-Shopify-Access-Token: ",
    "Content-Type: application/json"
  );

//make the curl request
$chm = curl_init($host);

curl_setopt($chm, CURLOPT_HTTPHEADER, $additionalHeaders);
//curl_setopt($chm, CURLOPT_HEADER, 1);
//curl_setopt($ch, CURLOPT_USERPWD, ":");
curl_setopt($chm, CURLOPT_TIMEOUT, 30);
curl_setopt($chm, CURLOPT_POST, 1);
curl_setopt($chm, CURLOPT_POSTFIELDS, $json);
curl_setopt($chm, CURLOPT_RETURNTRANSFER, TRUE);
$return1 = curl_exec($chm);
curl_close($chm);
//print_r($return1);
$return1 = json_decode($return1);
$tokenx = $return1->token;
//echo($tokenx);
echo "<br /><br />";
//print_r($return1);
//exit;
//merchant id 
unset($chm);
unset($return1);
$time = time();


//create an order
$host2 = "https://accept.paymobsolutions.com/api/ecommerce/orders?token=$tokenx";
$json2 = '{
  "access_token": "'.$tokenx.'",
  "delivery_needed": "true",
  "merchant_id": "",
  "amount_cents": "200",
  "currency": "EGP",
  "merchant_order_id": '.$time.',
  "shipping_data": {
    "apartment": "", 
    "email": "", 
    "floor": "", 
    "first_name": "", 
    "street": "",
    "building": "", 
    "phone_number": "", 
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
//curl_setopt($ch, CURLOPT_USERPWD, ":");
curl_setopt($chm, CURLOPT_TIMEOUT, 30);
curl_setopt($chm, CURLOPT_POST, 1);
curl_setopt($chm, CURLOPT_POSTFIELDS, $json2);
curl_setopt($chm, CURLOPT_RETURNTRANSFER, TRUE);
$return1 = curl_exec($chm);
curl_close($chm);
//print_r($return1);
$return1 = json_decode($return1);
//print_r($return1);
echo "<br /><Br />";
$orderid = $return1->shipping_data->order_id;
echo $orderid;
unset($return1);
unset($chm);
//exit;
//request payment link - 3rd step
$json = '{
  "auth_token": "'.$tokenx.'",
  "amount_cents": "",
  "expiration": ,
  "order_id": "'.$orderid.'",
  "billing_data": {
    "apartment": "1",
    "email": "",
    "floor": "",
    "first_name": "",
    "street": "",
    "building": "",
    "phone_number": "",
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
$host = "https://accept.paymobsolutions.com/api/acceptance/payment_keys?token='.$tokenx.'";
//$host = "https://accept.paymobsolutions.com/api/acceptance/payment_keys";
echo "<br /><br />";

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
//echo 'hi';

//generate the iframe/payment link
echo '<iframe src="https://accept.paymobsolutions.com/api/acceptance/iframes/8065?payment_token='.$paytoken.'" height="810" width=720></iframe>';
//print_r($return1->token);

//iframe id 
?>
