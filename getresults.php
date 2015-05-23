<?php 

$r=json_decode(file_get_contents("res.json"),'ture');

for($i=0;$i<4;$i++){
echo $r["d"]["results"][$i]["MediaUrl"]."\n";

}