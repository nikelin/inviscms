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
if(isset($_POST['proceed']))
{
	$data=$tools->getEnvVars("POST");
	if(!$tools->checkValues($data,array()))
	{
		$arch=$xziparchive->makeArchive();
		$root=$xziparchive->make_dir("/");
		$infoxml=join('',file('./tmpls/corepack.xmlt'));
		$invisparser->fetch($infoxml);	
	}
}
?>
<html>
	<head>
		<title>CorePackage maker</title>
		<link rel='stylesheet' href='/lib/gt/stylesheet.css' type='text/css'/>
		<script type='text/javascript' src='/lib/gt/invis.js'></script>
		<script type='text/javascript' src='/lib/gt/ui.js'></script>
		<script type='text/javascript'>
			<!--
			var f_count=1;
			var active_proceed=false;
			
			var proceed=function(e)
			{
				return active_proceed;
			}
			
			
			var agree=function(){
				document.getElementById('agreement').style.display='none';
				document.getElementById('proceed').disabled=false;
			}
			
			var disagree=function()
			{
				window.location.href="/?disable=true"
			}
			
			var add_file=function()
			{
				var el=document.createElement('div');
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
				document.getElementById('files').appendChild(el);
			}
			
			var delete_file=function(e)
			{
				document.getElementById(e).replaceNode(null);
			}
			
			
			var licdo=function(e){
				alert(e.src);
				return false;
			}
			var localInit = function(e){
				dInit(null);
				document.getElementById("accept").addEventListener("click",licdo,false);
				document.getElementById("disagree").addEventListener("click",function(e){alert("false");return false;},false)
				Invis.tools.loadLib("css","/lib/gt/admin.css");
			}
			
			-->
		</script>
	</head>
	<body id='body' onload='return localInit();'>
		<form action='' method='post' onsubmit='proceed()'>
			<div class='uform' style='width:100%;'>
				<div class='legend'>Создание core-пакета</div>
				<div class='row'>
					<div class='label'>Компания поставщик:</div>
					<div class='value'>
						<input type='text' name='company'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Автор пакета:</div>
					<div class='col'>
						<input type='text' name='author'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Лицензия поставки:</div>
					<div class='col'>
						<input type='text' name='license'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Адрес для ознакомления с лицензией:</div>
					<div class='col'>
						<input type='text' name='license_url'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Название пакета:</div>
					<div class='col'>
						<input type='text' name='title'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Версия пакета:</div>
					<div class='col'>
						<input type='text' name='version'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Дата официального релиза:</div>
					<div class='col'>
						<input type='text' name='pub_date'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Регистрационный RSP-ключ:</div>
					<div class='col'>
						<input type='text' name='regcode'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>E-mail для откликов</div>
					<div class='col'>
						<input type='text' name='reply-to'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1' style='width:100%;clear:both;text-align:center;background-color:#FFFFEF;color:#000000;'>Структура пакета:</div>
				</div>
				<div class='row'>
					<div class='label label1'>Абстракция пакета (abstractions.{pack}.php):</div>
					<div class='col'>
						<input type='file' name='abstraction'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Интерфейс пакета (interface.{pack}.php):</div>
					<div class='col'>
						<input type='file' name='interface'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Основной файл пакета (package.{pack}.php):</div>
					<div class='col'>
						<input type='file' name='package'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Набор исключений (errors.{pack}.php):</div>
					<div class='col'>
						<input type='file' name='errors'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1' style='width:100%;clear:both;text-align:center;background-color:#FFFFEF;color:#000000;'>Дополнительные файлы (/lib/core/others):</div>
				</div>
				<div class='files_area'>
					<div class='row' id='f0_area'>
						<div class='label label1'>Путь к файлу:</div>
						<div class='col'>
							<input type='file' name='others[]'/>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='label label1' style='text-align:center'>
						<input type='submit' onclick='return add_file();' value='Добавить'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1' style='width:100%;clear:both;text-align:center;background-color:#FFFFEF;color:#000000;'>Зависимости пакета</div>
				</div>
				<div class='row'>
					<div class='label label1' style='text-align:center;width:100%;clear:both;'>Пакеты</div>
				</div>
				<div id='packages' style='width:100%;'>
					<div class='row'>
						<div class='label label1' style='width:100%;clear:both'>
							<input style='width:68%;' type='text' name='packages[]' value='Идентификатор пакета'/>
							<input style='width:30%;' type='text' name='packages_version[]' value='Версия пакета'/>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='label submit'>
						<button style='width:100%;' id='add_package'>Добавить пакет</button>
					</div>
				</div>
				<div class='row'>
					<div class='label label1' style='text-align:center;width:100%;clear:both;'>Абстракции</div>
				</div>
				<div id='packages' style='width:100%;'>
					<div class='row'>
						<div class='label label1' style='width:100%;clear:both'>
							<input style='width:68%;' type='text' name='packages[]' value='Идентификатор абстрактного класса'/>
							<input style='width:30%;' type='text' name='packages_version[]' value='Версия класса'/>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='label submit'>
						<button style='width:100%;' id='add_package'>Добавить абстракцию</button>
					</div>
				</div>
				<div class='row'>
					<div class='label label1' style='text-align:center;width:100%;clear:both;'>Библиотеки</div>
				</div>
				<div id='packages' style='width:100%;'>
					<div class='row'>
						<div class='label label1' style='width:100%;clear:both'>
							<input style='width:100%;' type='text' name='packages[]' value='Идентификатор библиотеки'/>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='label submit'>
						<button style='width:100%;' id='add_package'>Добавить библиотеку</button>
					</div>
				</div>
				<div id='agreement'>
					<div class='row'>
						<div class='label label1' style='width:100%;clear:both;text-align:center;background-color:#FFFFEF;color:#000000;'>Лицензия InnoWeb Studio</div>
					</div>
					<div class='row'>
						<div class='label label1' style='width:100%;clear:both;text-align:center;background-color:#FFFFEF;color:#000000;'>
							<textarea id='innolic' readonly="true" style='width:100%;height:150px;'></textarea>
						</div>
					</div>
					<div class='row'>
						<div class='label label1' style='width:100%;text-align:center;'>
							<button style='width:49%;' onclick="agree();return false;">Принять</button>
							<button style='width:49%;' onclick='disagree();return false;'>Отклонить</button>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Защитить архив паролем:</div>
					<div class='value'>
						<input type='text' name='passwd'/>
 					</div>
				</div>
				<div class='row'>
					<div class='label label1' style='width:100%;clear:both;'>
						<button style='width:100%;' disabled='true' id='proceed' name='proceed'>Сформировать</button>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
