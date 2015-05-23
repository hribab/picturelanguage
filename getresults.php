<?php 

$r=json_decode(file_get_contents("res.json"),'ture');

foreach($r["d"]["results"] as $r2){
echo $r2["MediaUrl"]."\n";

}