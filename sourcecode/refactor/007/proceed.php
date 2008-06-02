<?php
$d="./lib/system/kernel";
$dir=opendir($d);
while(false!==($el=@readdir($dir)))
{
	$path=$d.'/'.$el;
	if(is_dir($path) &&  preg_match('/^[a-zA-Z0-9_]+$/',$el))
	{
		if($fp=@fopen($path.'/errors/eclass.'.$el.'.php',"w+"))
		{
			$data="<?php
				class ".strtoupper(substr($el,0,1)).substr($el,1)."Error extends SException
				{
					
					/* Methods */
					public function __construct (\$message, \$code=DATABASE_DEFAULT_ERROR )
					{}
				}
				?>";
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
