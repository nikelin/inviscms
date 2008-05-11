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
if(!defined("MAIN_SCRIPT_LOADED"))die("Structure error !");
$mtime = microtime();
//Разделяем секунды и миллисекунды
$mtime = explode(" ",$mtime);
//Составляем одно число из секунд и миллисекунд
$mtime = $mtime[1] + $mtime[0];
//Записываем стартовое время в переменную
$tstart = $mtime;
$m_path="lib/modules/admin";
$p=opendir($m_path);
$params=$GLOBALS['params'];
if(!isset($params['params'][0]))
{
	$params['params'][0]='home';
}
$GLOBALS['info']=array();
$errorsB=new Errors();
while(false!==($file=readdir($p))){
	if($file!='.' && $file!='..' && is_dir($m_path.'/'.$file)){
		$info[$file]['info']=(file_exists($m_path.'/'.$file.'/info.xml'))?simplexml_load_file($m_path.'/'.$file.'/info.xml'):array();
  	$info[$file]['lang']=(file_exists($m_path.'/'.$file.'/langs/ru.xml'))?simplexml_load_file($m_path.'/'.$file.'/langs/ru.xml'):array();
	}
}
$modules_on=array();
foreach($info as $k=>$v){
	#die_r($v);
	#print_rbr($v);
 if(isset($v['info']['status']) && $v['info']['status']=='on'){
	 $modules_on[(string)$v['info']['id']]=array(
	 																				'indefier'=>(string)$v['info']['id'],
		 																			'title'=>(string)$v['info']->title
																					 );
 }
}
$auth=$security->authorized("admin");
$sessions->registerData("last_access_time".md5($_SERVER['REMOTE_ADDR']),time());
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>
			InvisibleSystems&copy; AdminPart
		</title>
    	<script type='text/javascript' src='/lib/gt/invis.js'></script>
		<link rel='stylesheet' type='text/css' href='/lib/skins/default/styles/table.css' media='all'/>
		<link rel='stylesheet' type='text/css' href='/lib/skins/default/styles/forms.css' media='all'/>
		<link rel='stylesheet' type='text/css' href='/lib/skins/default/styles/stylesheet.css' media='all'/>
		<link rel='stylesheet' type='text/css' href='/lib/skins/default/styles/admin.css' media='all'/>
		<script type='text/javascript' src='/lib/gt/editor/tiny_mce.js'></script>
		<script type='text/javascript'>
			<!--
				tinyMCE.init({
				  	theme : "advanced",
				  	mode : "exact",
                    elements : "editor,content",
					theme : "simple",
					cleanup:true
				});
				var Invis=new Invis();
			-->
		</script>
	</head>
	<body id='body'>
		<div class='doc' style='background-color:#FFFFFF;'>
			<h1 class='logo' style='width:100%;background-color:#FFFFEF;'>
				InvisibleSystem AdminPart
			</h1>
			<div class='top_menu admenu'>
				<?=$html->topRounded('100%');?>
				<?php
					if($auth){
						 foreach($modules_on as $k=>$v){
							?>
      							<button style='margin:0;margin-left:10px;margin-bottom:2px;width:147px;' onclick='Invis.core.loadPage("<?php print($v['indefier']); ?>","main");'>
									<?=$v['title'];?>
								</button>
							<?php
						}
					}else{
                		 print "Вы не прошли процедуру авторизации !";
          			}
				?>
			</div>
				<?php
					if($auth){
				?>
			<?=$html->bottomRounded('100%');?>
			<div class='sinfo'>
				<?=$html->topRounded('100%');?>
				<div class='container'>
					<span>
						Ваш последний визит:
					</span>
					<strong class='value'>
						<?=date("d.m.Y",$database->getSQLParameter("users","laccess",array("ip"=>$_SERVER['REMOTE_ADDR'])));?>
					</strong>
					<hr/>
					<span>
						До конца сессии:
					</span>
					<strong class='value'>
						<?=round($security->timeElapsed("admin"),0);?> минут
					</strong>
					<hr/>
					<span>
						Время проведённое на сайте:
					</span>
					<strong class='value'>
						<?=$database->getSQLParameter("users","ttime",array('ip'=>$_SERVER['REMOTE_ADDR']));?> секунд
					</strong>
					<br/>
				</div>
				<?=$html->bottomRounded('100%');?>
					<button style='width:100%;font-weight:bold;' onclick='Invis.core.loadPage("logout","main");return false;'>Выйти</button>
			</div>
			<?
			}
			?>
			<!--CENTER_BAR;-->
			<div class='centerBar'>
				<?=$html->topRounded('100%');?>
				<div class='container''>
					<span class='bodyTopPart'>
						AdminPart
						<big>!</big>
					</span>
				</div>
				<div class='container'>
					<?php
					if($auth || $params['params'][0]=='admins'){
						$mod=isset($params['params'][1])?$params['params'][1]:'main';
						$mod=($mod=="main" || $mod=="list")?($modules->modExists('admin',$params['params'][0],'main')?'main':'list'):$mod;
						print $modules->loadModule("admin",rawurlencode($params['params'][0]),$mod);
					}else{
						 print $modules->loadModule("admin","auth","main");
					}
					?>
				</div>
				<?=$html->bottomRounded('100%');?>
			</div>
								<?php
						if($auth){
						?>
			<div class='centerBar'>
		</div>
		<?php
		}
		?>
		</div> &nbsp;
	</div>
	<?=$errors->outputData();?>
	</div>
  </body>
</html>
<?php
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
//Записываем время окончания в другую переменную
$tend = $mtime;
//Вычисляем разницу
$totaltime = ($tend - $tstart);
//Выводим не экран
$database->proceedQuery("UPDATE `#prefix#_users` SET ttime=ttime+".$totaltime." WHERE ip='".$_SERVER['REMOTE_ADDR']."' LIMIT 1");
?>
