<?php

$url = 'http://www.totvs.sobelmaster.com.br:8081/afvweb/Login/RealizarLogin';

$user = 'rp212.02';
$passwd = 'rp212.02';

$ch = curl_init($url);
$data = array(
    'usuario' => $user,
    'senha' => $passwd
);
$payload = json_encode($data);
//echo $payload;

if(file_exists('file.txt'))
{
    unlink('file.txt'); 
}
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_COOKIEJAR, "file.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "file.txt");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$cookie = file_get_contents('file.txt');
//  print $cookie;
$pattern = "/[A-Za-z0-9]{24}/i";
preg_match_all($pattern, $cookie, $value);
$value =  $value[0][0];
setcookie("ASP.NET_SessionId", $value);

$obj = json_decode($result);
print $obj->{'IsValido'};

// Se retorno verdadeiro executta query buscando dados do vendedor

/*
SELECT V.NOME                      AS 'VENDEDOR', 
       V.CODIGOVENDEDOR            AS 'CODVENDACACIA', 
	   LEFT(V.CODIGOVENDEDORESP,6) AS 'CODVENDPROTHEUS'
FROM T$_USUARIO U
INNER JOIN T_VENDEDOR V ON V.CODIGOVENDEDOR = U.CODIGOEMPRESA
WHERE USUARIO = 'rp212.02'
*/

