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
define("MAIN_SCRIPT_LOADED",1);
include "./lib/kernel/others/init.php";
if(!$database->isError())
{
	$GLOBALS['params']=isset($_GET['q'])?$system->convertURL2HUA($_GET['q'],"news"):array("mod"=>"home");
	$errors=new Errors();
	if($params['mod']=='admin'){
		include 'sl.php';
	}else{
		if($params['mod']=="lang")
		{
			$sessions->registerData("lang",$i18n->getLandId($params['params'][0]),array(time(),3600*60));
		}else{
			$sessions->registerData("lang",$i18n->delaultLang(),array(time(),3600*60));
		}
		include 'upart.php';
	}
}else
{
	header("Location: /server_.html");
}
exit();
?>
