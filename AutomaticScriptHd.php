<?php

$url = "http://localhost/MicroMail/AutomaticScript/asHd";
$curl = curl_init();
        
$this_header = array(
	"content-type: application/x-www-form-urlencoded;charset=UTF-8"
);
        
curl_setopt($curl, CURLOPT_HTTPHEADER, $this_header);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, 1);
        
$result = curl_exec($curl);
curl_close($curl);

