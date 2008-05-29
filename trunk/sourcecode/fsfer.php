<?php
# This file is part of InvisCMS .
#
#    InvisCMS is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    Foobar is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with InvisCMS.  If not, see <http://www.gnu.org/licenses/>.
?><?php
$count=0;function proceed($dir){
	global $count;
	$d=opendir($dir);
	while(false!==($file=readdir($d)))
	{
		if($file!='.' && $file!='..')
		{
			if(is_file($dir.'/'.$file))
			{
				if(preg_match('/(php|tpl|inc|ism|frm)+$/',$file))
				{
					$count+=1;
					/**$data=join("",file($dir.'/'.$file));					$data=preg_replace("/[\n\r]{2,2}/","\n",$data);
					#die($data);					if($fp=fopen($dir.'/'.$file,"w+"))
					{
						if(fwrite($fp,$data))
						{
							print "Файл ".$dir.'/'.$file." успешно изменён !<br/>\n\r";
						}else
						{
							print "Ошибка вывода в файл ".$dir.'/'.$file."!<br/>\n\r";
						}
					}else
					{
						print "Ошибка во время открытия файла !<br/>\n\r";
					}**/
				}
			}else
			{
				proceed($dir.'/'.$file);
			}
		}
	}
}
proceed(".");
print "Всего файлов: ".$count;
?>