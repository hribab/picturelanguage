
<?php


$text="Gaffigan was also one of the first comedians to sell his specials online, and he sees the Internet as a great place to get noticed in comedy. While it helps that he has 5 million or so Twitter followers, he wants to see comedians, performers, and producers embrace the Internet and not fear it… a tall order from an industry that still doesn’t know what the make of a great comedian giving away his first show for free.";

include "module/AlchemyAPI.php";

$con=new MongoClient("mongodb://picturelanguage:haribabu123@ds035702.mongolab.com:35702/picturelanguage");
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
			echo "Object --".$relation['object']['text'];
					}
	}
	}	
	
?>
