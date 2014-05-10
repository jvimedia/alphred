<?php

require('workflows.php');
$w = new Workflows();
date_default_timezone_set("Europe/Helsinki");
$token =  $w->get( 'token', 'settings.plist' );
$count=$argv["c"];
if(!$count){$count=5;}
$url='https://alpha-api.app.net/stream/0/users/me/mentions?include_deleted=0&count='.$count;
$headers=array(
	'Authorization: Bearer '.$token,
);
$output = connect($url,$headers);
#var_dump($output);
$posts = $output->data;
foreach ($posts as $post){
	$arg = $argv[1];
	$source = $post->source;
	$user = $post->user;
	$posttext=$post->text;
#	$mentionleader=>
	
	#$ex=$post->mentions;
	$username=$user->username;
	#$avurl= $post->user->avatar_image->url;
	#exec("curl $avurl > ./avatar/user.$username.png");
#$avurl= $post->user->id;
	
print `/usr/bin/php -q load_avatar.php $username  > /dev/null 2>/dev/null &`;

 
	$icon = './avatar/user.'.$username.'.png';
	if (!file_exists($icon)){
	$icon='icon.png';}
/// Time operations
	$date = strtotime($post->created_at);
	$fixed = date('Y-m-d - g:ia', $date);
	$postime = date('H:m:s', $date);
	$datex = date('Y-m-d', $date);
	if($datex == date('Y-m-d')) {
      $day_name = 'at '.$postime;
   # } else if($x == date('Y-m-d',now() - (24 * 60 * 60))) {
    #  $day_name = 'Yesterday at '.$postime;
    } else {
    	$day_name=$fixed;
    	}
//
$usrstr=strlen($username);
$postln=strlen($posttext);
$lenght=45-$posttext;
$postup = substr($posttext,0,$lenght).'...';
if($lenght>=1) {
	$postdown = " • ".substr($posttext,$lenght,$postln);
	}
else{
	$postdown ="";
}
	$random = rand();
	
//$w->result('unifiedstream-'.$post->id. '-' .$random, $post->id.' '.$arg, ''.$user->username.' mentioned you: '.$postup,'['.$day_name.']'.$postdown." • Posted with".$source->name, $icon, 'yes', "@".$username.' ');
		
		
		$show=true;
		//SEARCH in mentions
		if (strpos($arg,'§s')!=false){
			$show=true;
			$search=str_replace("§s","");
			$hay=explode($search," ");
			foreach ($hay as $search){

		if (strpos($post->text,$search) !== false) {
$show=true;
} else {$show=false;}
		}}		
		
		
		if($show!=false){$w->result('unifiedstream-'.$post->id. '-' .$random, $post->id.' '.$arg, $post->text, "@".$user->username." mentioned you " .$day_name.$postdown. " • Posted with " .$source->name, $icon, 'yes', "@".$username,'yes' );}

}
	echo $w->toxml();


function connect($url,$headers){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$output=json_decode(curl_exec($ch));
	curl_close ($ch);
	if($output->meta->code==200){
		return $output;
	}else{
		$error = $output->error;
		echo 'Error Retrieving Posts. Error Code' .$error;
	}
	
}
 ?>