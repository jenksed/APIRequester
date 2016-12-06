<?php
$intapiurl = "https://*****.com/";

if (php_sapi_name() === 'cli') {
	unset($intapiuser);
	unset($intapipw); 
	$intapiuser = readline("Billing API Username: ");
	echo "Billing API Password: ";
	system('stty -echo');
	$intapipass = trim(fgets(STDIN));
	system('stty echo');
	echo "\n";
} 

function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

function int_api_call($method, $params) {
       global $intapiurl, $intapiuser, $intapipw;
       
       //ensure that the $params is valid JSON:
       if (isJson($params) == false) {
           exit();
        } else {
       
       $uri = "$intapiurl" . "$method" . ".json";
        print $uri;
    
        //open connection
        $ch = curl_init($uri);
        //set the url, returntransfer, login credentials, and the auth type 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array("Content-Type: application/json", "Accept: application/json"));
        curl_setopt($ch, CURLOPT_USERPWD, $intapiuser . ":" . $intapipw);
        $output = curl_exec($ch);
       
        curl_close($ch); 
        return json_decode($output);
        }
}
int_api_call(
