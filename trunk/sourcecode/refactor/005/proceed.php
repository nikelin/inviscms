<?php
$d='./lib/modules';
$dir=opendir($d);
while(false!==($el=@readdir($dir)))
{
	$path=$d.'/'.$el;
	if(is_dir($path) &&  preg_match('/^[a-zA-Z0-9_]+$/',$el))
	{
		if($fp=@fopen($path.'/info.xml',"w+"))
		{
			$data="<?xml version='1.0'?>
			<info>
			    <authors>
			        <people name='Kirill K. Karpenko' role='Author'/>
			    </authors>
			    <companies/>
			    <support>
			        <item name='support' value='LoRd1990@gmail.com'/>
			    </support>   
			    <version>0.1-beta</version>
			    <published>".date("d-m-Y")."</published>
			    <i18n>
			        <lang id='en-US'/>
			    </i18n>
			    <description/>
			    <system-min-version value='0.1.5-stable'/>
			</info>";
			@flock($fp,LOCK_EX);
			if(@fwrite($fp,$data))
			{
				print "Информация успешно сохранена!\n";
			}else
			{
				print "Ошибка во время записи данных!\n";
			}
			@flock($fp,LOCK_UN);
			@fclose($fp);
		}else
		{
			print "Ошибка во время чтения данных!\n";
		}
	}
}
?>
