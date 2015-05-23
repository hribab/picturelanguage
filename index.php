Hi
anotehr test

asdf
asd
f 
sd
fa
sdf
<?php

if(!isset($_POST["text"])){
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <input type="text" name="text"><br>
   <input type="submit" name="submit" value="Submit"><br>
</form>
<?php
}
else{


$text=$_POST['text'];

include "module/AlchemyAPI.php";

$con=new Mongo(" mongodb://picturelanguage:haribabu123@ds035702.mongolab.com:35702/picturelanguage");
$dbname = $con->selectDB('picturelanguage'); // this is where feed urls stores
$collection = $dbname->selectCollection("picturelanguage");

// Create an AlchemyAPI object.
$alchemyObj = new AlchemyAPI();

// Load the API key from disk.
$alchemyObj->loadAPIKey("api_key.txt");

$namedEntityParams = new AlchemyAPI_NamedEntityParams();
$namedEntityParams->setSentiment(1);
$alcEntities = @$alchemyObj->TextGetRankedNamedEntities($text,'json', $namedEntityParams) ;
$alcRelations = @$alchemyObj->URLGetRelations($text,'json');
	
$alcEntityArr = json_decode($alcEntities, true); 
$alcResponseArr = json_decode($alcRelations, true);

$ab=array_merge($alcEntityArr,$alcResponseArr);
$collection->insert($ab);
				
foreach($alcEntityArr['entities'] as $e)
{	 
				
	if(trim($e['type']) == "Person") 
	    {
		
		echo "<h1>People</h1></br>";
	    echo $e["text"]."</br>";
		}				
	if(trim($e['type']) == "Company")
				{
				
		echo "<h1>Company</h1></br>";
	    echo $e["text"]."</br>";
		}
  }
  
echo "</br></br></br>";
 echo "<h1>Relations</h1></br>";
  
if ($alcResponseArr['status'] == 'OK') 
	{
	foreach ($alcResponseArr['relations'] as $relation) {
		
		if (array_key_exists('subject', $relation)) {
			echo "Subject --".$relation['subject']['text']." ";
					}
				
		if (array_key_exists('action', $relation)) {
			echo "Action --".$relation['action']['text']." ";
					}
				
		if (array_key_exists('object', $relation)) {
			echo "Object --"..$relation['object']['text']." , ";
					}
	}
	}	
	}
?>
