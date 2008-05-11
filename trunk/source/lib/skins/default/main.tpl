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
?>﻿<?php
$description='';
$title='';
$keywords='';

#
# FIXME: must be rewritted as part of `tools` package in differ of current linier style
#

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
$curr_sets=$GLOBALS['database']->fetchQuery($GLOBALS['database']->getRows("settings","*"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head id='head'>
		<title><?=$title;?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="K.Karpenko aka LoRd1990 at ISDC TNT-43 Ltd." />
		<meta name='description' content='<?=$description;?>'/>
		<meta name='keywords' content='<?=$keywords;?>'/>
		<?=$css;?>
		<?=$rss;?>
		<script type='text/javascript' src='/lib/gt/invis.js'></script>
		<script type='text/javascript'>
		<!-- 
			var Invis=new Invis(); 
			Invis.tools.loadLib("css","/lib/skins/default/styles/stylesheet.css");
			Invis.tools.loadLib("css","/lib/skins/default/styles/table.css");
			Invis.tools.loadLib("js","/lib/gt/ui.js");
		-->
		</script>
	</head>
	<body id='body' style='display:none;' onload='return dInit();'>
		<div class='doc'>
			<div class="content">
				<div class="header">
					<div class="slogan">
				 			<?=$GLOBALS['uinterface']->getUIParam("site_slogan",$GLOBALS['i18n']->getLangID());?>
					</div>
				</div>
				<div id='sub1'>
					<div class='search_bar'>
						<?php
						#
						# FIXME: user must have abilities to apply changes to predefined google.com variables
						#
						?>
						<!-- Google CSE Search Box Begins  -->
						<form action="/search" id="searchbox_001418051629243380186:9nyforrlbuy">
							<input type="hidden" name="cx" value="001418051629243380186:9nyforrlbuy" />
							<input type="hidden" name="cof" value="FORID:11" />
							<input type="text" name="q" size="25" />
							<input type="submit" name="sa" value="{^search^}" />
						</form>
						<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=searchbox_001418051629243380186%3A9nyforrlbuy&lang=ru"></script>
					</div>
					<div class='sMA_rbar'>
						<span class='lang_label'>{^site_lang^}</span>
						<select id='lngField' onchange='changeLang();'>
							<optgroup label='{^site_lang^}'/>
							<?=$GLOBALS['uinterface']->user_lang_bar();?>
						</select>
					</div>
				</div>
				<div id="modules">
					<div id="maincontent">
						<div class='lmenu'>
							<?=$GLOBALS['uinterface']->block_place("left");?>
						</div>
						<div class='izone'>
							<div class='content'>
								<?include($GLOBALS['skin_path']."/body.tpl");?>
							</div>
						</div>
						<div class='rmenu'>
							<?=$GLOBALS['uinterface']->block_place("right");?>
						</div>
					</div>
				</div>
				<div id="menu" style='clear:both;margin:0;'>
					<?include($GLOBALS['skin_path']."/bottom_menu.tpl");?>
				</div>
				<div id='blockAdvert' title='Наша реклама' style='margin-bottom:0;padding-bottom:0;'>
					<?include($GLOBALS['skin_path']."/blockadvert.tpl");?>
				</div>
			</div>
		</div>
		<div class='counters' style='clear:both;width:100%;margin:0;text-align:left;'>
			<div class='item' style='text-align:center;width:100%;'>
				<div id='counters'></div>
			</div>
		</div>
		<div id="footer" style='margin:0;margin-top:10px;'>
			<?include($GLOBALS['skin_path']."/footer.tpl");?>
		</div>
		</div>
	</body>
</html>