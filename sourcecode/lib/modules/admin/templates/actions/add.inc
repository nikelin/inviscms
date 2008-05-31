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
$data=$tools->getEnvVars("POST",true);
if(!$tools->checkValues($data,array("title","type","developer","price","front","back")))
{
	$errors->appendJSError("Не заполнены обязательные поля формы !");
	$errors->redirect('/admin/templates/add');
}else
{
	if($database->checkRowExists("templates",array('title'=>$data['title'])))
	{
		$errors->appendJSError("Футболка с таким названием уже существует в базе!");
		$errors->redirect('/admin/templates/main');
	}else{
		if(false!==($tid=$database->insertRow("templates",array("",$data['back'],$data['front'],$data['developer'],$data['title'],$data['type'],$data['description'],$data['price'],time(),(@$data['cat'])?$data['cat']:0,"on"))))
		{
			$errors->appendJSError("Футболка под №".$tid." успешно добавлена в базу.");
			$errors->redirect('/admin/templates/main');
		}else
		{die_r($database->sqlErrorString());
			$errors->appendJSError("Ошибка во время диалога с БД!");
			$errors->redirect("/server_.html");
		}
	}
}
print $errors->outputData();
?>
