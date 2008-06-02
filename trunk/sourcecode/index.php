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
include "./lib/core/others/init.php";
$parts=$tools->currentPageParts();
$curr_sets=$uinterface->getSettings();
if(!$database->isError())
{
	if(isset($_GET['q'])){
		$GLOBALS['params']=$system->convertURL2HUA($_GET['q'],"news");
	}else{
		$params['mod']="home";	
	}
	$errors=new Errors();
	if($params['mod']=='admin'){
		include 'sl.php';
	}else{
		if($tools->firstTime())
		{
			$sessions->registerData("welcome",1,array(time(),3600*60),true);
			header("Location: hello.html");
		}else
		{
			if($i18->currentLanguageSet())
			{
				if(!$tools->siteClosed())
				{
					if($i18n->initializeDictionary($invisparser))
					{
						$tools->registerWrapper(array("articles","developers","cats","home","delivery"),array(array(&$sape_context,"replace_in_text_segment")));
						print $tools->postfetchProceed(stripslashes($invisparser->fetch(($GLOBALS['path_to_site']."/lib/skins/default/main.tpl"))));
					}
				}else
				{
					header("Location: hello.html");
					exit;
				}
			}
		}
	}
}else
{
	header("Location: /server_.html");
}
exit;
?>
