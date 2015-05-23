<?php
echo "hi";
/* Pre-requisite: Download the required PHP OAuth class from http://oauth.googlecode.com/svn/code/php/OAuth.php. This is used below */
    require("OAuth.php"); 
    $cc_key  = "dj0yJmk9VVFxR2pFQ1ZNaExEJmQ9WVdrOU1tdzVTMHQ1TjJFbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD0xZA--";
    $cc_secret = "9b021f06236243bbb2d9d53cd6095bf7735e67e4";
    $url = "https://yboss.yahooapis.com/ysearch/images";
    $args = array();
    $args["q"] = "steve";
    $args["format"] = "json";
 
    $consumer = new OAuthConsumer($cc_key, $cc_secret);
    $request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
    $url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));
    $ch = curl_init();
    $headers = array($request->to_header());
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $rsp = curl_exec($ch);
    echo $rsp;
	//$results = json_decode($rsp);
    //print_r($results);
?>

http://api.search.live.net/json.aspx?AppId=1mzubwjtNao95YdUjIqj94ZYqAtNIAa+iuVg0weIVnM&Query=xbox%20site:microsoft.com&Sources=Image&Version=2.0&Market=en-us&Adult=Moderate&Image.Count=10&Image.Offset=0


https://api.datamarket.azure.com/Bing/Search/v1/Image?Query=%27xbox%27

MdeJjjbjRULdnGROZpA5Dx66ht/MqTJQtYsxdlSKtqg=