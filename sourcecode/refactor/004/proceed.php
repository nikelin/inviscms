<?php
$d='./lib/modules';
$dir=opendir($d);
while(false!==($el=@readdir($dir)))
{
	$path=$d.'/'.$el;
	if(is_dir($path) &&  preg_match('/^[a-zA-Z0-9_]+$/',$el))
	{
		$xml=@simplexml_load_file($path.'/info.xml');
		if($xml)
		{
				$data="<config>
				    <parts>";
				for($i=0;$i<count($xml->actions->action);$i++)
				{
					$ob=$xml->actions->action[$i];
				        $data.="<item>
				             <name>".(String)$ob."</name>
				             <system>".(String)$ob['id']."</system>
				             <description>".(String)$ob."</description>
				             <status value='on'/>
				        </item>";
				}
				 $data.="</parts>
				     <system>
					 	 <id>".(String)$xml['id']."</id>
				         <name>".(String)$xml->title."</name>
				         <part>admin</part>
				         <status value='".(String)$xml['status']."'/>
				     </system>
				</config>";print($data);
				if($fp=fopen($path.'/config.xml','w+'))
				{
					flock($fp,LOCK_EX);
					if(fwrite($fp,$data))
					{
						print "Файл успешно записан !\n";
					}else
					{
						print "Ошибка во время записи !\n";
					}
					flock($fp,LOCK_UN);
					fclose($fp);
				}else
				{
					print "Ошибка во время открытия файла!\n";
				}
		}else
		{
			print "Ошибка во время чтения файла данных XML !(`".$el."`)\n";
		}
	}else
	{
		print "Пропускаем `".$el."`!\n";
	}
}
?>