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
$errors=new Errors();
$part=isset($GLOBALS['params']['params'][0])?$GLOBALS['params']['params'][0]:'normal';
$data=$_FILES['patch']['tmp_name'];
if(!file_exists($data) || filesize($data)<=0)
{
	$errors->appendJSError("Пустой, либо несуществующий файл!");
}else
{
	$patch=new patchcontroller();
	if(!$patch->init($data))
	{
		$errors->appendJSError("Ошибка во время инициализации сессии обработчика!");
	}else
	{
		if($patch->validate_package() && $patch->security_validate())
		{
			print $patch->show_package_info();
			?>
			<form action='' method='post'>
				<strong>Для продолжения, нажмите "Далее"</strong>
				<button name='action_pach_info'>Далее</button><button onclick='Invis.core.loadPage("patch","main");'>Отмена</button>
			</form>
			<?
		}else{
			$errors->appendJSError("Пакет не прошёл проверки на безопастность/целостность !");
		}
	}
}
print $errors->outputData();
?>