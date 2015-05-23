<?php

$acctKey = '1mzubwjtNao95YdUjIqj94ZYqAtNIAa+iuVg0weIVnM';
$rootUri = 'https://api.datamarket.azure.com/Bing/Search';
$query = 'stevejobs';
$serviceOp ='Image';
$market ='en-us';
$query = urlencode("'$query'");
$market = urlencode("'$market'");
$requestUri = "$rootUri/$serviceOp?\$format=json&Query=$query&Market=$market";
$auth = base64_encode("$acctKey:$acctKey");
$data = array(  
            'http' => array(
                        'request_fulluri' => true,
                        'ignore_errors' => true,
                        'header' => "Authorization: Basic $auth"
                        )
            );
$context = stream_context_create($data);
$response = file_get_contents($requestUri, 0, $context);
$response=json_decode($response);
echo "<pre>";
print_r($response);
echo "</pre>";
/*

// Replace this value with your account key
    $accountKey = '1mzubwjtNao95YdUjIqj94ZYqAtNIAa+iuVg0weIVnM';            
    $ServiceRootURL =  'https://api.datamarket.azure.com/Bing/SearchWeb/';                    
    $WebSearchURL = $ServiceRootURL . 'Web?$format=json&Query=';

    $cred = sprintf('Authorization: Basic %s', 
      base64_encode($accountKey . ":" . $accountKey) );

    $context = stream_context_create(array(
        'http' => array(
            'header'  => $cred
        )
    ));
$searchText="stevejobs";
    $request = $WebSearchURL . urlencode( '\'' . $searchText . '\'');

    $response = file_get_contents($request, 0, $context);

    echo $response;
	
	$jsonobj = json_decode($response);

    
	echo('<ul >');

    foreach($jsonobj->d->results as $value)
    {                        
        echo('<li ><a href="' 
                . $value->URL . '">'.$value->Title.'</a>');
    }

    echo("</ul>");*/


?>