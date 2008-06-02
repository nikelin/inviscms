<?php
# Abstractizer :)
$d="./lib/system/kernel";
$dir=opendir($d);
while(false!==($el=@readdir($dir)))
{
	$path=$d.'/'.$el;
	if(is_dir($path) &&  preg_match('/^[a-zA-Z0-9_]+$/',$el))
	{
		$d=file_get_contents("./lib/system/kernel/system/classes/class.system.php");
	#	die($d);
		$methodPattern="((public|private|protected)*[\s]*function[\s]*([a-zA-Z_]{1,1}[a-zA-Z0-9_]*)[\s](?:\()+(.*)(?:\)))+";
		preg_match_all("/".$methodPattern."/m","public function dF()",$j);
		print_r($j);
		exit;
	}
}
?>
