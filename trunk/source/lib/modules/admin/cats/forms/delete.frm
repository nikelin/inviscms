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
	if($database->checkRowExists("cats",array("id"=>$_POST['pid'])))
	{
		$q=$database->getRows("cats","*",array("pid"=>$_POST['pid']));
		if($database->getNumrows($q)!=0)
		{
			$errors->appendJSError("Найдены элементы, которые связаны с данным элеменов родственными связями.");
			$errors->appendJSError("Они будут заблокированы.");	
		}
		if($database->deleteRow("cats",array("id"=>$_POST['pid'])))
		{
			$errors->appendJSError("Категория успешно удалена!");
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
