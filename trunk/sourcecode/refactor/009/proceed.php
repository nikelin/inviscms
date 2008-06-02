<?php
$d="./lib/system/kernel";
$dir=opendir($d);
$dirs=array("abstract","errors","interfaces","classes","logs");
while(false!==($el=@readdir($dir)))
{
	$path=$d.'/'.$el;
	foreach($dirs as $s_p)
	{
		if(!file_exists($path.'/'.$s_p))
		{
			print "Директория `".$s_p."` добавлена к структуре пакета `".$el."` !\n";
		}
	}
}
?>
