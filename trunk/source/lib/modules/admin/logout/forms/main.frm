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
if(!$sessions->isDeath("admin_auth_".substr(md5($_SERVER['REMOTE_ADDR']),0,6)))
{
	if($security->dropSession("admin"))
	{
		$errors->appendJSError("Рабочая сессия успешно завершена !");
		$errors->redirect("/admin");
	}else{
		$errors->appendJSError("Ошибка во время завершения рабочей сессии !");
	}
}else
{
		
}
print $errors->outputData();
?>