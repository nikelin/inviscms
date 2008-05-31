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
$path="../lib/core/packages";
$d=opendir($path);
while(false!==($dir=@readdir($d)))
{
	if($dir!='.' && $dir!='..' && is_dir($path.'/'.$dir))
	{
		$file=join('',file($path.'/'.$dir.'/info.xml'));
		$file=preg_replace("/<item value='([a-zA-Z0-9\.]*)'(.*)\/>/m","<item name='$1' $2/>",$file);
		$file=preg_replace("/<node name='([a-zA-Z0-9_]*)' value='(.*)'\/>/m","<$1>$2</$1>",$file);
		$fp=fopen($path.'/'.$dir.'/info.xml','w+');
		fwrite($fp,$file);
		fclose($fp);
	}
}
?>