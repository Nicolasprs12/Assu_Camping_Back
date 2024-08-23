<?php

namespace App\Models;


function generateJWT($payload, $secretKey, $expiration = 48000) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload['exp'] = time() + $expiration;
    $encodedHeader = base64_encode($header);
    $encodedPayload = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', $encodedHeader . '.' . $encodedPayload, $secretKey, true);
    $encodedSignature = base64_encode($signature);
    return $encodedHeader . '.' . $encodedPayload . '.' . $encodedSignature;
}


function lireBoolSQL($str,$traitementNull = false){
	//retourne true/false pour 1/0
	//peut retourner null si traitementNull vrai
	return ($str == 1)? true : (($traitementNull && (is_null($str) || $str == ''))? null : false);
}

function strToSQL($str){
	return (is_null($str) || $str == '')? 'NULL' : '\''.addslashes($str).'\'';
}

function lireSQL($str){
	return (is_null($str) || $str == '')? null : stripslashes($str);
}


function ecritBoolSQL($str,$traitementNull = false){
	//retourne 1/0 pour true/false
	//retourne NULL si si traitementNull vrai
	return ($str === true)? 1 : (($str === false)? 0 : (($traitementNull && (is_null($str) || $str == ''))? 'NULL' : 0));
}

function lireDateHeureSQL($str){
	if(is_null($str)) $retour = null;
	else{
		$retour = new dateheure();
		$retour->lireSQL($str);
	}
	return $retour;
}

function ecritDateHeureSQL($date){
	return (!is_null($date) && is_object($date))? '\''.$date->ecritDateHeureSQL().'\'' : 'NULL';
}

function ecritDateSQL($date){
	return (!is_null($date) && is_object($date))? '\''.$date->ecritDateSQL().'\'' : 'NULL';
}

function affPrix($number,$virg = false)
{// Retourne une valeur xxxx.xx format x xxx,xx
    if(is_numeric($number)) return ($virg)? number_format($number,2, ',','') : number_format($number,2, '.','');
	else return $number;
}