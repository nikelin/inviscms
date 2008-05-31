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
if(!$tools->checkValues($data,array("title")))
{
	$errors->appendJSError("Ошибка во время проверки формы!");
}else 
{
	if($database->checkRowExists("cats",array("id"=>$_POST['id'])))
	{
		if($database->updateRow("cats",array("title"=>$data['title'],"pos"=>$data['pos'],"pid"=>$data['pid']),array("id"=>$data['id'])))
		{
			$errors->appendJSError("Информация успешно сохранена!");
		}else
		{
			$errors->appendJSError("Ошибка во время диалога с БД!");
		}	
	}else
	{
		$errors->appendJSError("Данная категория не существует!");
	}
}
print $errors->outputData();
?>
