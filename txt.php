<?php

$url="http://www.totvs.sobelmaster.com.br:8081/afvweb/Login/RealizarLogin"; 
//username and password of account
$user = 'rp212.02';
$passwd = 'rp212.02';

$ch = curl_init($url);
$data = array(
    'usuario' => $user,
    'senha' => $passwd
);
$payload = json_encode($data);

//set the directory for the cookie using defined document root var
//build a unique path with every request to store. the info per user with custom func. I used this function to build unique paths based on member ID, that was for my use case. It can be a regular dir.
//$path = build_unique_path($path); // this was for my use case

//login form action url



if(file_exists('file.txt'))
{
    unlink('file.txt'); 
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_COOKIEJAR, 'file.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, "file.txt");

$cookie = file_get_contents('file.txt');
//  print $cookie;
$pattern = "/[A-Za-z0-9]{24}/i";
preg_match_all($pattern, $cookie, $value);
$value =  $value[0][0];
setcookie("ASP.NET_SessionId", $value);

echo $value;
//set the cookie the site has for certain features, this is optional
curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=".uniqid());
curl_setopt($ch, CURLOPT_USERAGENT,
    "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_exec($ch);

//page with the content I want to grab
curl_setopt($ch, CURLOPT_URL, "http://www.totvs.sobelmaster.com.br:8081/AFVWeb/Principal");
//do stuff with the info with DomDocument() etc
$html = curl_exec($ch);
curl_close($ch);

echo $html;