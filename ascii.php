<?php   

/**
 * Modelo de descriptografia de senha acacia - em 240 registros 195 possuem a mesmo usuario e senha no sistema
 * <CRIP>
 * 
 * 
*/

$ascii = "!\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz" ;
$crip  = "¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿ" ;

$ascii = str_split($ascii,1);

$crip  = str_split($crip, 1);


$passwd = 'ÝÞß';

echo count($crip);
/** percorrer passwd quebrar em caracter */



/*** para cada caracter localizar sua posicao em crip */
/** para cada caracter localizar caracter correspondente em ascii utilizando a posicao correspondente em crip */

//echo $ascii[0] . '<br>';

//echo $crip[0] . '<br>';

//var_dump($dataset);
