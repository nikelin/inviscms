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
$data=$tools->getEnvVars("POST",true);
$errors=new Errors();
if(strcmp(rawurldecode($data['action_delete']),'Нет')!=-1)
{
	$errors->redirect("/admin/languages/main");
}else{
	if($database->deleteRow("dicts",array("id"=>$data['did'])))
	{
		if($database->deleteRow("texts",array('partition'=>"dicts",'param'=>$data['did'])))
		{
			$errors->appendJSerror("Данные успешно удалены !");
			$errors->redirect("/admin/languages");
		}else{
			$errors->appendJSError("Ошибка во время удаления данных!");
			$errors->redirect("/server_.html");
		}
	}else{
		$errors->appendJSError("Ошибка во время удаления данных!");
		$errors->redirect("/server_.html");
	}
}
print $errors->outputData();
?>