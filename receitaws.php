<?php

$cnpj  = '27865757000102';
$url   = "https://www.receitaws.com.br/v1/cnpj/" .$cnpj. "/days/10";
$token = '824606074dc05f6c1f6828ac0d0ae18f445ee029af0b7a47ee0407661de3f1ec';

$ch = curl_init($url);

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer {$token}",'Content-Type:application/json'));
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

//set the cookie the site has for certain features, this is optional
curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=".uniqid());
curl_setopt($ch, CURLOPT_USERAGENT,
    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_exec($ch);

//page with the content I want to grab
curl_setopt($ch, CURLOPT_URL, $url);
//do stuff with the info with DomDocument() etc
$html = curl_exec($ch);
curl_close($ch);

echo $html;