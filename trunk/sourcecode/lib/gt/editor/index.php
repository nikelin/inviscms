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
?><?
	                 /**
	                  * Исходный код официального сайта организации "НСПУ"
	                  * Все права на данный код защищены согласно закона об авторском праве Украины,
	                  * и несанкционированное использование данного файла или части исходного кода
	                  * программы преследуются по закону.
	                  *
	                  * Автор комплекса: Карпенко Кирилл
	                  * Служба техподдержки: LoRd1990@gmail.com
	                  * Все права принадлежат компании ИНПП "ТНТ-43"
	                  */
	                 ?><?
	                 /**
	                  * Исходный код официального сайта организации "НСПУ"
	                  * Все права на данный код защищены согласно закона об авторском праве Украины,
	                  * и несанкционированное использование данного файла или части исходного кода
	                  * программы преследуются по закону.
	                  *
	                  * Автор комплекса: Карпенко Кирилл
	                  * Служба техподдержки: LoRd1990@gmail.com
	                  * Все права принадлежат компании ИНПП "ТНТ-43"
	                  */
	                 ?><?php
ini_set('magic_quotes_gpc',0);
ini_set('register_globals',0);
ini_set('safe_mode',0);
ini_set('short_open_tag',0);
$loadings=array('mForm_loaded'=>0,'mPieces_loaded'=>0,'mAction_loaded'=>0);
//Считываем текущее время
$mtime = microtime();
//Разделяем секунды и миллисекунды
$mtime = explode(" ",$mtime);
//Составляем одно число из секунд и миллисекунд
$mtime = $mtime[1] + $mtime[0];
//Записываем стартовое время в переменную
$tstart = $mtime;
header('Content-Type:text/html;charset=utf-8');
include 'common.php';
if($security->EatCookie()){
?>
<html>
<head>
  <meta http-equiv='Content-Type' Content='text/html;charset=utf-8'/>
  <title>Адміністративна частина сайту "Національної Спілки Письменників"</title>
  <meta name='owner' Content='National Ukrainian Writters Community'/>
  <meta name='developer' Content='K.Karpenko <LoRd1990@gmail.com>'/>
  <meta name='author' Content='ISDK "TNT-43"'/>
  <meta name='reply-to' Content='LoRd1990@gmail.com'/>
  <style type='text/css'>
   <!--
   .attchContainer{
    width:100%;background-color:#CCCCCC;color:inherit;border-width:1px;border-color:#000000;border-style:ridge;
   }
   .btn{
    color:#FF0000;background-color:inherit;
   }
    -->
  </style>
  <script type='text/javascript' src='./core/internal/editor/tiny_mce.js'></script>
  <script language="javascript" type="text/javascript">
  	<!--
tinyMCE.init({
	mode : "textareas",
	theme : "simple"
});

  	function showFilePswdProtectArea(){
  	    if(document.getElementById('crypt').checked){
  	        document.getElementById('crc_protect_area').style.display='table-row';
  	    }else{
  	        document.getElementById('crc_protect_area').style.display='none';
  	    }
  	}
	  <?=sajax_show_javascript();?>
   var temp=new Array();
   var file;

  		function showImageArea(dir){
		var el=document.getElementById('imageArea');
		var img=document.getElementById('imgElem');
		var value=document.getElementById('image').value;
		if(value!='' && value!='none'){
			el.style.display='block';
			img.src=value;
		}else{
			el.style.display='none';
		}
	}

  	function hightlightArea(id,color,def){
  		var el=document.getElementById(id);
  		alert(color+'::'+el.style.backgroundColor);
  		el.style.backgroundColor=(el.style.backgroundColor==color)?def:color;
  	}

  	function delete_cb(bool){
  		if(bool){
  			alert('Зображення успішно видалене !');
  			window.location.href='files_imageload.html';
  		}else{
  			alert('Помилка під час видалення зображення !');
  		}
  	}

  	function delete_file(name){
  		x_deleteFile(name,delete_cb);
  	}

	function selectAll(id){
		var id=id+'[]';
		var elem=document.getElementsByTagName('input');
		for(var i=0;i<elem.length;i++){
			if(elem[i].name==id){
				if(elem[i].checked){
					elem[i].checked=false;
				}else{
					elem[i].checked=true;
				}
			}
		}
	}
	  	<?=eval($engine->putjs($_GET['act']));?>
  -->
  </script>
  <script type='text/javascript'  src='core/menu/stmenu.js'></script>
  <script type='text/javascript' src='core/menu/context.php'></script>
</head>
<body>
<table style='width:90%;height:auto;background-color:#FFFFFF;border-color:#000000;border-width:1px;border-style:ridge;' align='center'>
<tr>
	<td colspan='2' style='background-color:#FFFFFF;color:#000000;text-align:left;font-size:20px;font-weight:bold;'>
		<div style='clear:both;'>
			<div style='float:left;'>
			<img src='images/admin_logo.png' height='45' alt='Адміністративна частина сайту НСПУ'/>
			</div>
			<div style='float:right;width:300px;'>
				<div style='width:50%;clear:both;font-size:11px;font-weight:bold;color:#FF0000;background-color:#CCCCCC;'>Швидка допомога:</div>
				<div style='width:100%;clear:both;overflow:scroll;font-size:12px;background-color:#EEEEEE;color:inherit;'>
					<?php
					$engine->sql_connect();
					$q=$engine->sql_query("SELECT value FROM `#prefix#_help_messages` ORDER BY RAND()");
					if($q){
						if($engine->sql_numrows($q)!=0){
							$row=$this->sql_fetch($q);
							print $row['message'];
						}else{
						?>
							Повідомлень не знайдено !
						<?
						}
					}else{
						?>
						Помилка під час діалогу з БД !
						<?
					}
					?>
				</div>
			</div>
		</div>
	</td>
</tr>
<tr>
	<td colspan='2' style='height:10px;text-align:center;background-color:#000000;color:#FFFFFF;'>
		<table style='height:100%;width:100%;' align='left'>
			<tr>
				<td style='width:20%;text-align:left;color:#FFFFFF;background-color:inherit;'>Новини в світі:</td>
				<td>
					<marquee scrollamount='3' scrolldelay='2' style='color:#FFFFFF;background-color:inherit;'>

					</marquee>
				</td>
		</table>
	</td>
</tr>
<tr>
   <td style='vertical-align:top;width:10%;background-color:#FF8040;color:inherit;'>
   <?include('core/menu/menu.js');?>
   </td>
   <td style='margin-bottom:0px;background-color:#FFBF80;color:#FFFFFF;text-align:center;'>
   	<table style='width:100%;'>
		<tr><td colspan='2' style='height:170px;text-align:center;'>
		<div style='font-size:11px;text-align:left;overflow:auto;height:50px;width:100%;background-color:#FFFFFF;color:#FF3333;border:1px #FFFFFF dotted;font-weight:bold;'>
			 <?php
			 $engine->sql_connect();
			 $q=$engine->sql_query("SELECT * FROM `tnt43_announces` WHERE project='nspu' AND status='on'");
			 if($q){
							if($engine->sql_numrows($q)!=0){
								?>
								<ol>
								<?
								while($row=$engine->sql_fetch($q)){
									 ?>
									 <li><?=$row['text'];?></li>
									 <?php
								}
								?>
								</ol>
								<?
							}
			 }
			 $engine->sql_close();
			 ?>
		</div>
			<?php
			if(!isset($_GET['act'])){
			?>
			<div align='center'>
				<span style='font-weight:bold;font-size:26px;font-weight:bold;'>Увага !</span><br>
				Доступ до цієї частини сайту тілько для адміністраторів та персоналу. <br>Під час генерування
				сторінки ваши данні були занесені в Глобальний Протокол безпеки сайту, та будуть перевірені<br>
				службою підтримки сайту.<br>
			</div>
			<?php
			}else{
				if($engine->actionExpected($_GET['do']) && !$security->checkUserPermission($_GET['act'],'w')){
					print $engine->genError('Недостатньо прав для внесення змін в інформаційну базу !');
				}else{
					if($security->checkUserPermission($_GET['act'],'r')){
					       print eval($engine->loadModule($_GET['act'],$_GET['do']));
					}else{
					?>
						<span style='font-weight:bold;font-size:18px;color:#FF0000;background-color:inherit;'>У вас немає прав доступу до цього розділу !</span>
					<?
					}
				}
			}
			?>
		</td></tr>
		<tr>
			<td style='text-align:center;height:50px;'>
				Права доступу: <span style='color:#FF0000;font-weight:bold;'><a href='?act=checkperms&do=main' title='Ваші повноваження'><?=$security->getPermissionProfile();?></a></strong>
			</td>
			<td style='text-align:center;'>
				IP-адреса: <span style='color:#FF0000;font-weight:bold;'><?=$_SERVER['REMOTE_ADDR'];?></strong>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
			<!--
				<div id='help_advice' style='width:80%;'>
					<div id='head' style='border-color:#000000;border-width:1px;border-style:ridge;width:55%;background-color:#FFFA00;color:inherit;'>
						<strong>'<?=$tools->getModuleTitle($_GET['act']);?>'</strong>
					</div>
					<div id='message' style='overflow:scroll;height:55px;border-color:#000000;border-width:1px;border-style:ridge;width:100%;background-color:#FFFFFF;color:inherit;'>
						Текст поради
					</div>
				</div>
			-->
			</td>
		</tr>
   	</table>
   </td>
</tr>
<tr><td colspan='2' style='height:10px;text-align:center;background-color:#000000;color:#FFFFFF;'>&nbsp;</td></tr>
<tr>
 <td colspan='2' style='background-color:#000053;color:inherit;text-align:center;font-style:italic;font-weight:bold;font-size:18px;'><a href='http://tnt43.com'>
 <img style='border-width:0px;height:40px;width:300px;' src='images/tnt43_logo.png' alt='Промиловий супермаркет TNT-43'/>
 </a></td>
</tr>
</table>
</body>
</html>
<?php
}else{
	header('Location:auth.php');
}
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
//Записываем время окончания в другую переменную
$tend = $mtime;
//Вычисляем разницу
$totaltime = ($tend - $tstart);
//Выводим не экран
printf ("Страница сгенерирована за %f секунд !", $totaltime);
?>
