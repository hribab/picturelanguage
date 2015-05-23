<?php 



$text="Gaffigan was also one of the first comedians to sell his specials online, and he sees the Internet as a great place to get noticed in comedy. While it helps that he has 5 million or so Twitter followers, he wants to see comedians, performers, and producers embrace the Internet and not fear it… a tall order from an industry that still doesn’t know what the make of a great comedian giving away his first show for free.";

include "module/AlchemyAPI.php";


// Create an AlchemyAPI object.
$alchemyObj = new AlchemyAPI();

// Load the API key from disk.
$alchemyObj->loadAPIKey("api_key.txt");


//$alcEntities = @$alchemyObj->TextGetRankedNamedEntities($text,'json', $namedEntityParams) ;
//$alcRelations = @$alchemyObj->TextGetRelations($text,'json');
$alcKeyowrds = @$alchemyObj->TextGetRankedKeywords($text, 'json');

$alckeywordarr = json_decode($alcKeyowrds, true); 


for($i=0;$i<4;$i++)
{
echo $alckeywordarr["keywords"][$i]["text"]."\n";
}
/*
$r=json_decode(file_get_contents("res.json"),'ture');

for($i=0;$i<4;$i++){
echo $r["d"]["results"][$i]["MediaUrl"]."\n";

}

*/

?>