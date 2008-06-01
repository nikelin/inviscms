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
﻿<?php
$description='';
$title='';
$keywords='';
if(@include("lib/modules/client/".$GLOBALS['params']['mod']."/rules.php"))
{
	$description=description();
	$title=slug();
	$keywords=keywords();
}
	$css='';
	$rss='';
	$scripts='';
if($data=@simplexml_load_file("lib/modules/client/".$GLOBALS['params']['mod']."/info.xml"))
{
	if(isset($data->css))
	{
		if(isset($data->css->item))
		{
			for($i=0;$i<count($data->css->item);$i++)
			{
				$ob=$data->css->item[$i];
				$css.="<link rel='stylesheet' href='".$ob['href']."' type='".$ob['type']."' media='".$ob['media']."'/>";
			}
		}else
		{
			if($data->css['href']!='')
				$css='<link rel="stylesheet" type="'.$data->css['type'].'" href="'.$data->css['href'].'" media="'.$data->css['media'].'"/>';
		}
	}
	if(isset($data->rss))
	{
		if(isset($data->rss->item))
		{
			for($i=0;$i<count($data->rss->item);$i++)
			{
				$ob=$data->rss->item[$i];
				if($ob['href']!='')
					$rss.="<link rel='alternate' href='".$ob['href']."' type='".$ob['type']."'/>";
			}
		}else
		{
			if($data->rss['href']!='')
				$rss='<link rel="alternate" type="'.$data->css['type'].'" href="'.$data->rss['href'].'"/>';
		}
	}
	
	if(isset($data->scripts))
	{
		if(isset($data->scripts->item))
		{
			for($i=0;$i<count($data->scripts->item);$i++)
			{
				$ob=$data->scripts->item[$i];
				if($ob['href']!='')
				{
					$scripts.=('Invis.tools.loadLib("js","'.$data->scripts['href'].'");'."\n");
				}
			}
		}else
		{
			if($data->scripts['href']!='')
			{
				$scripts.=('Invis.tools.loadLib("js","'.$data->scripts['href'].'");'."\n");
			}
		}
	}
	
}
$curr_sets=$tools->getSettings();
if(!$database->isError())
{
	#die_r($googletranslate->translate("Дом","en","ru",array("Invis.tools.googletranslate._successful","dafna"),false));
	#die_r($googletranslate->detect("My house - my forrtress !"));
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
