
<?php

if(!isset($_POST["text"])){
?>
<h1> Enter Text for image </h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  
    <textarea rows="10" cols="70" name="text">
some text
</textarea></br>
   <input type="submit" name="submit" value="Submit"><br>
</form>
<?php
}
else{



$acctKey = '1mzubwjtNao95YdUjIqj94ZYqAtNIAa+iuVg0weIVnM';
$rootUri = 'https://api.datamarket.azure.com/Bing/Search';

$text=$_POST['text'];
echo $text."</br>";

include "module/AlchemyAPI.php";

$con=new Mongo("mongodb://picturelanguage:haribabu123@ds035702.mongolab.com:35702/picturelanguage");
$dbname = $con->selectDB('picturelanguage'); // this is where feed urls stores
$collection = $dbname->selectCollection("picturelanguage");

// Create an AlchemyAPI object.
$alchemyObj = new AlchemyAPI();

// Load the API key from disk.
$alchemyObj->loadAPIKey("api_key.txt");

$namedEntityParams = new AlchemyAPI_NamedEntityParams();
$namedEntityParams->setSentiment(1);
$alcEntities = @$alchemyObj->TextGetRankedNamedEntities($text,'json', $namedEntityParams) ;
$alcRelations = @$alchemyObj->TextGetRelations($text,'json');
	
$alcEntityArr = json_decode($alcEntities, true); 
$alcResponseArr = json_decode($alcRelations, true);

$ab=array_merge($alcEntityArr,$alcResponseArr);
$collection->insert($ab);
	
echo "<h1>People</h1></br>";
		
	foreach($alcEntityArr['entities'] as $e)
	{	 			
		if(trim($e['type']) == "Person") 
	    {
		echo $e["text"]."</br>";
		$query = $e["text"];
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
		$response=json_decode($response,true);
		$collection->insert(array($e["text"]=>$response));
		for($i=0;$i<5;$i++){
			echo "<img src='".$response["d"]["results"][$i]["MediaUrl"]."' width='200' height='200'>";
		}
		}
	}
echo "<h1>Company</h1></br>";

	foreach($alcEntityArr['entities'] as $e)
	{		 			
	if(trim($e['type']) == "Company")
	{
		echo $e["text"]."</br>";
		$query = $e["text"];
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
		$response=json_decode($response,true);
		$collection->insert(array($e["text"]=>$response));
		for($i=0;$i<4;$i++){
			echo "<img src='".$response["d"]["results"][$i]["MediaUrl"]."' width='200' height='200' >";
		}
	}
	}	 
		
echo "<h1>Other Entities</h1></br>";


	foreach($alcEntityArr['entities'] as $e)
	{	 			
	if(trim($e['type']) != "Company" && trim($e['type']) != "Person")
	{
		echo $e["text"]."</br>";
	}
	} 

echo "</br></br></br>";
echo "<h1>Relations</h1></br>";
  
if ($alcResponseArr['status'] == 'OK') 
	{
	foreach ($alcResponseArr['relations'] as $relation) {
		
		if (array_key_exists('subject', $relation)) {
			echo "Subject --".$relation['subject']['text']."</br> ";
					}
				
		if (array_key_exists('action', $relation)) {
			echo "Action --".$relation['action']['text']."</br> ";
					}
				
		if (array_key_exists('object', $relation)) {
			echo "Object --".$relation['object']['text']."</br> ";
					}
		echo "</br></br>";
	}
	}	
	}
?>
