<?php
echo `date`;
	$width=45;
	$input=$argv[1];
#var_dump($argv);
	#$input=str_replace("\n","",$input);
$data=$input;
#$data=explode(":",$input);
#	$op=$data['1'];
	$username=$data;
	$avurl="https://alpha-api.app.net/stream/0/users/@".$username."/avatar?w=$width";
	$curl="curl -L -s -z ./avatar/user.$username.png \"$avurl\" -o ./avatar/user.$username.png ";
	exec("$curl");
echo `date`;

?>

