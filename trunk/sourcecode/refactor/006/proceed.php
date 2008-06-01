<?php
chdir("./lib/modules");
$d='./';
function calcHash($path)
{
	$dir=@opendir($path);
	$data='';
	while(false!==($el=@readdir($dir)))
	{
		if(substr($el,0,1)!='.')
		{
			if($path!='./')
			{
				$p=$path.'/'.$el;
			}else
			{
				$p=$path.$el;
			}
			print($p."\n\n");
			if(is_file($p))
			{
		    	$data.="			<item path='".$p."' type='md5' value='".md5(file_get_contents($p))."'/>\n";
			}else
			{
				$data.=calcHash($p);
			}
		}
	}
	return $data;
}
$dir=opendir($d);
while(false!==($el=readdir($dir)))
{
	if(substr($el,0,1)!='.')
	{
		chdir('./'.$el);
		$data="<?xml version='1.0'?>
<authority>\n";
	$hash="	<data>\n";
	$hash.=calcHash("./");
	$hash.="	</data>\n";
	$data.=$hash;
	$data.='	<check>'.md5($hash)."</check>
</authority>";
		if($fp=@fopen("./hash.xml","w+"))
		{
			@flock($fp,LOCK_EX);
			if(@fwrite($fp,$data))
			{
				print "Информация успешно сохранена !\n";
			}else
			{
				print "Ошибка во время записи данных !\n";
			}
			@flock($fp,LOCK_UN);
			@fclose($fp);
		}else
		{
			print "Ошибка во время открытия файла на чтение !\n";
		}
		chdir("../");
	}
}
?>