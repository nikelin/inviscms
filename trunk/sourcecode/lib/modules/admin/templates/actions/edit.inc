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
$data=$tools->getEnvVars("POST");
$errors=new Errors();
if($database->checkRowExists("templates",array("id"=>$data['id'])))
{
	if(!$tools->checkValues($data,array('title','back','front','developer','price')))
	{
		$errors->appendJSErrors("Вы не ввели некоторые обязательные поля формы!");
		$errors->redirect("/admin/templates/edit/".$_POST['id']);
	}else{
		if($database->updateRow("templates",array("developer"=>$data['developer'],"title"=>$data['title'],"price"=>$data['price'],'cid'=>(@$data['cat'])?$data['cat']:0,'back'=>$data['back'],'front'=>$data['front']),array('id'=>$data['id'])) && !$database->isError())
		{
			$errors->appendJSError("Правка шаблона №".$data['id']." прошла успешно!");
			$errors->redirect('/admin/templates/main');
		}else{
			$errors->appendJSError("Ошибка во время диалога с БД!");
			$errors->redirect('/server_.html');
		}
	}
}else{
	$errors->appendJSError("Данная футболка не существует!");
	$errors->redirect("/admin/templates/main");
}
print $errors->outputData();
?>