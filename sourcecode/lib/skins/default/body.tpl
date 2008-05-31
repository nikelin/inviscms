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
$params=$GLOBALS['params'];
$mod_path="lib/modules/client/".$params['mod']."/forms/main.frm";
ob_start();
if(!file_exists($mod_path)){
	print $GLOBALS['uinterface']->buildClientPage($params['mod']);

}else{	
	if(!$GLOBALS['modules']->deniedModule("client",$params['mod']))
	{
		print $GLOBALS['modules']->loadModule("client",rawurlencode($params['mod']),"main");
	}else{
		print "Модуль заблокирован !";
	}
}
$content=ob_get_contents();
ob_end_clean();
print $GLOBALS['tools']->applyWrappers($params['mod'],$content);
?>
