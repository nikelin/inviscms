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
		<title>ФутболкаPrint <?=$title;?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="K.Karpenko aka LoRd1990 at ISDC TNT-43 Ltd." />
		<meta name='yandex-verification' content='781bd51d154b9875' />  
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
			Invis.tools.loadLib("js","http://www.google-analytics.com/urchin.js");
			Invis.tools.loadLib("js","/lib/gt/ui.js");
		-->
		</script>
	</head>
	<body id='body' style='display:none;' onload='return dInit();'>
		<div class='opera' style='background-color:#CCCCCC;text-align:center;'>
			<div id='opera-invite' style='font-size:18px;background-color:#777777;color:#FFFFFF;text-align:left;'>
			</div>
		</div>
		<div class='versioning' style='background-color:#000000;color:#FFFFFF;text-align:right;'>
			Сайт работает в <span style='color:#EE2200;'>Бета-режиме</span>. Текущая версия сайта: <strong>1.1.3 Beta</strong> <a href='/feedback'>помочь нам</a>
		</div>
		<div class='doc'>
			<div class="content">
				<div class="header">
					<div class="topong" >
						<?include($GLOBALS['skin_path']."/top_basket_menu.tpl");?>
					</div>
					<div class='logo'>
						<a href='/about' title='Кто мы есть, где мы есть, и зачем мы есть'>
							<img src='<?=$curr_sets['logotype'];?>' alt='Магазин модных футболок ФутболкаPrint&copy;' />
						</a>
						<div class='slogan' title='Магазин ФутболкаPrint !'>
							Интернет-магазин индивидуальных футболок		
						</div>
					</div>
					<a href='/home' title='Последние поступления в каталог'>
						<img src='/images/mens_without_face.gif' alt='Они пришли к нам такими, но ушли совершенно иными !' style='float:left;margin-top:5px;margin-left:80px;'/>
					</a>
					<div class="slogan" title='Голос футболки говорит:'>
				 			<?=$GLOBALS['uinterface']->getUIParam("site_slogan",$GLOBALS['i18n']->getLangID());?>
					</div>
				</div>
				<?include($GLOBALS['skin_path']."/top_menu.tpl");?>
				<div class='bar03f'>
						<div title='TOP-10 самых покупаемых футболок' style='margin:0;padding:0;float:left;font-size:17px;font-weight:bold;'>
							<span style='color:#FF0000;' title='В этом разделе показаны лучшие из лучших наших футболок'>TOP-10</span> 
							/ <a title='{^show_top10_shirts^}' href='#' onclick='Invis.tools.changeElVis("marqueeD","off");return false;' title='Спрятать их' id='hide'>{^hide^}</a>
							- 
							<a title='{^hide_top10_shirts^}' id='show' href='#' onclick='Invis.tools.changeElVis("marqueeD","on");return false;' title='Показать вновь'>{^show^}</a>
						</div>
						<div class='userbar'>
							<!--load_form("auth_form");-->
							<?php
							if(!$GLOBALS['security']->authorized("client"))
							{
							?>
							<a href='/form/auth_form' title='Если вы уже в рядах наших клиентов, то вам сюда' id='auth_link'>
								{^authorization^}
							</a>
							<a href='/form/reminder' title='Если с памятью плохо...' id='reminder_link'>
								{^reminder^}
							</a>	
							<?php
							}else{
							?>
								<a href="/account" id='paccount_link' title='Перейти на страницу персонального аккаунта'>
									{^account^}   ::
								</a>	
								<a href="/logout" id='logout_link' title='Покинуть магазин'>
									{^logout^}
								</a>	
							<?php
							}
							?>
						</div>
				</div>
				<div  id='marqueeD' style='display:none;'>
					<div style='margin:0;padding:0;'>
						<marquee title='Футболки которые заставляют нас гордится ими' scrollamount='2' scrolldelay='3' direction='right' behavior='alternate' onmouseover='this.stop();' onmouseout='this.start();'>
							<?=$GLOBALS['uinterface']->getMarquee(10);?>
						</marquee>
					</div>
				</div>
				<div id='sub1'>
					<div class='search_bar'>
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
						<select title='Выберите язык интерфейса сайта' id='lngField' onchange='changeLang();'>
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
				<noindex>
					<a target="_top" href="http://top.mail.ru/jump?from=1410865">
					<img src="http://d7.c8.b5.a1.top.list.ru/counter?js=na;id=1410865;t=130" alt=''/></a>
					<a href='http://www.stat24.meta.ua'>
						<img alt='' src='http://stat24.meta.ua/img/counter/11.gif' />
					</a>
					<a href="http://click.hotlog.ru/?507300">
					<img src="http://hit26.hotlog.ru/cgi-bin/hotlog/count?s=507300&amp;im=104" alt=''/></a>
					<a href='http://www.liveinternet.ru/click'
					target=_blank><img src='http://counter.yadro.ru/hit?t14.6;" alt=''
					border=0 width=88 height=31></a>
				</noindex>
			</div>
		</div>
		<div id="footer" style='margin:0;margin-top:10px;'>
			<?include($GLOBALS['skin_path']."/footer.tpl");?>
		</div>
		</div>
	</body>
</html>