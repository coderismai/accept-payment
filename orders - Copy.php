<?php

$token = '';

$host = "https://accept.paymobsolutions.com/api/auth/tokens";
$token = '';


$json = '{
  "api_key": ""
}';


//$payloadName = array("client_id"=>$client, "client_secret"=>$secret,"code"=>$code);
$additionalHeaders = array(
//	"Host:.myshopify.com",
  //  "X-Shopify-Access-Token: ",
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
$tokenx = $return1->token;

$additionalHeaders = array(
//	"Host: .myshopify.com",
  //  "X-Shopify-Access-Token: ",
    "Content-Type: application/json",
    "Authorization: Bearer $tokenx"
  );

$host = "https://accept.paymobsolutions.com/api/ecommerce/orders";

$chm = curl_init($host);

curl_setopt($chm, CURLOPT_HTTPHEADER, $additionalHeaders);
curl_setopt($chm, CURLOPT_TIMEOUT, 30);
curl_setopt($chm, CURLOPT_RETURNTRANSFER, TRUE);
$return1 = curl_exec($chm);
curl_close($chm);
$return1 = json_decode($return1);
foreach ($return1->results as $key => $value) {
print_r($value);
if($value->merchant_order_id == 20)
{
echo "order found!";
echo "order id: ". $value->id;
break;
}
}
//
$host2 = "https://accept.paymobsolutions.com/api/ecommerce/orders?token=$tokenx";
$json2 = '{
  "access_token": "'.$tokenx.'",
  "delivery_needed": "true",
  "merchant_id": "",
  "amount_cents": "200",
  "currency": "EGP",
  "merchant_order_id": "",
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
echo "<br /><Br />";
$orderid = $return1->shipping_data->order_id;
//echo $orderid;
if($orderid == "")
{
echo $return1->message;
if($return1->message == "duplicate")
{
	echo "some error found!";
}
}else
{
	echo($orderid);
}
?>