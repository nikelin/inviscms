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
include "../lib/core/others/init.php";
if(isset($_POST['make']))
{
	$data=$tools->getEnvVars("POST",true);
	$errors=new Errors();
	if($tools->checkValues($data,array("company","product","version","readme","license")))
	{
		#die_r($_FILES);
		if(!isset($_FILES['files']) || !isset($data['paths']) || count($_FILES['files']['tmp_name'])!=count($data['paths']))
		{
			$errors->appendJSError("Ошибка во время проверки файлового списка!");
		}else
		{
			$xziparch=new xziparch();
			$xml_info='';
			$arch=$xziparch->makeArchive();
			$pack=$xziparch->makeArchive();
			$root=$xziparch->make_dir($arch,'/');
			for($i=0;$i<count($_FILES['files']['tmp_name']);$i++)
			{
				$xziparch->add($pack,$_FILES['files']['tmp_name'][$i],$data['paths'][$i],false,$root);
			}
			$pack_data=$xziparch->saveArchive($pack);
			$xziparch->add($arch,$data['readme'],'readme.txt',true,$root);
			$xziparch->add($arch,$data['license'],'license.txt',true,$root);
			$xziparch->add($arch,$pack_data,'pack.zip',true,$root);
			$xziparch->add($arch,md5($data['readme'].$data['license'].$pack_data.time().$company),'hash.md5',true,$root);
			$xziparch->add($arch,$xml_info,'info.xml',true,$root);
			$xziparch->add($arch,$pack_data,'pack.gz',true,$root);
			die_r($xziparch->saveArchive($arch));
			if($data['passwd_protect'])
			{
				$xziparch->protectArchByPasswd($arch,$data['passwd']);
			}
		}
	}else{
		$errors->appendJSError("Ошибка во время формы!");
	}
	print $errors->outputData();
}
?>
<html>
	<head>
		<title>PatchMaker</title>
		<script type='text/javascript' src='/lib/gt/invis.js'></script>
		<script type='text/javascript' src='/lib/gt/ui.js'></script>
		<link rel='stylesheet' href='/lib/gt/stylesheet.css' type='text/css'/>
		<link rel='stylesheet' href='/lib/gt/table.css' type='text/css'/>
		<script type='text/javascript'>
			<!--
			var f_count=1;
			
			var agree=function(){
				document.getElementById('agreement').style.display='none';
			}
			
			var disagree=function()
			{
				window.location.href="/?disable=true"
			}
			
			var add_file=function()
			{
				var el=document.createElement("div");
				f_count+=1;
				el.innerHTML+="<div class='row' id='f"+f_count+"_area'>";
				el.innerHTML+="<div class='col'>";
				el.innerHTML+="Файл:";
				el.innerHTML+="</div>";
				el.innerHTML+="<div class='col'>";
				el.innerHTML+="<input type='file' name='files[]'/>";
				el.innerHTML+="</div>";
				el.innerHTML+="<div class='col'>";
				el.innerHTML+="Относительный путь в системе (без лидирующего "/"):";
				el.innerHTML+="</div>";
				el.innerHTML+="<div class='col'>";
				el.innerHTML+="<input type='text' name='paths[]' value='Пример: lib/gt/jal'/>";
				el.innerHTML+="</div>";
				el.innerHTML+="<div class='col'>";
				el.innerHTML+="<button id='"+f_count+"' onclick='delete_file(this.id);return false;'>Убрать</button>";
				el.innerHTML+="</div>";
				el.innerHTML+="</div>";
				document.getElementById("files").appendChild(el);
			}
			
			var delete_file=function(e)
			{
				document.getElementById(e).replaceNode(null);
			}
			initL();
			-->
		</script>
	</head>
	<body id='body' onload='return dInit();' style='display:none;'>
		<form action='' method='post' enctype='multipart/form-data'>
			<div class='uform' style='width:100%;'>
				<div class='legend'>Создание нового пакета обновлений</div>
				<div class='row'>
					<div class='col'>
						Компания поставщик
					</div>
					<div class='col'>
						<input type='text' name='company'/>
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						Адрес официального релиза:
					</div>
					<div class='col'>
						<input type='text' name='release_url'/>
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						Название продукта (модуля):
					</div>
					<div class='row'>
						<input type='text' name='product'/>
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						Версия продукта:
					</div>
					<div class='col'>
						<input type='text' name='version'/>
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						Тип обновления:
					</div>
					<div class='col'>
						<select name='type'>
							<option value='critical'>Критическое обновление</option>
							<option value='evolution'>Обновление системы(функций)</option>
							<option value='integrity'>Интеграционное обновление</option>
							<option value='addon'>Дополнение к продукту</option>
						</select>
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						Содержание файла `readme.txt`:
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						<textarea name='readme' style='width:100%;height:150px;'></textarea>
					</div>
				</div>
				<div class='row'>
					<div class='col'>Содержимое файла license.txt</div>
				</div>
				<div class='row'>
					<div class='col'>
						<textarea name='license' style='width:100%;height:150px;'></textarea>
					</div>
				</div>
				<div id='files'>
					<div class='row' id='f1_area'>
						<div class='col'>
							Файл:
						</div>
						<div class='col'>
							<input type='file' name='files[]'/>
						</div>
						<div class='col'>
							Относительный путь в системе (без лидирующего "/"):
						</div>
						<div class='col'>
							<input type='text' name='paths[]' value='Пример: lib/gt/jal'/>
						</div>
						<div class='col'>
							<button id='f1' onclick='delete_file(this.id);return false;'>Убрать</button>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						<button style='width:100%' onclick='add_file();return false;'>Добавить</button>
					</div>
				<div class='row'>
					<div class='col'>
						Дата релиза:
					</div>
					<div class='col'>
						<input type='text' name='release_date' value='<?=date("H:i:s d.m.Y");?>'/>
					</div>
				</div>
				<div id='agreement'>
					<div class='row'>
						<div class='col'>Правовые положения относительно патчей компании InnoWeb Studio</div>
					</div>
					<div class='row'>
						<div class='col'>
							<textarea name='agreement' style='width:100%;height:90px;' readonly='true'>
								Текст лицензии
							</textarea>
						</div>
					</div>
					<div class='row'>
						<div class='col submit'>
							<button onclick='agree();'>Принять</button>
							<button onclick='disagree()'>Отклонить</button>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col'>
						Защитить результирующий архив паролем ?
					</div>
					<div class='col'>
						<input type='checkbox' onclick='Invis.tools.changeElVis("passwd_area","switch");' name='passwd' style='width:30px;height:30px;'/>
					</div>
				</div>
				<div class='row' id='passwd_area' style='display:none;'>
					<div class='col'>
						Введите пароль для защиты:
					</div>
					<div class='col'>
						<input type='text' name='passwd'/>
					</div>
				</div>
				<div class='row'>
					<div class='col submit'>
						<input type='submit' name='make' value='Создать'/>
					</div>
				</div>
			</div>
		</form>		
	</body>
</html>
