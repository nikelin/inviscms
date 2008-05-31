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
$errorB=new Errors();
if(!$tools->checkValues($data,array("_tid")))
{
	$errorB->appendJSError("Ошибка во время проверки формы !");
	$errorB->redirect("/admin/labels");
}else{
	if($database->checkRowExists("labels",array("id"=>$data['_tid'])))
	{
		$t=$database->updateRow("labels",array("title"=>$data['title'],"cid"=>$data['cat']),array("id"=>$data['_tid']));
		if(!$database->isError())
		{
			$errorB->appendJSError("Изменения успешно внесены !");
			$errorB->redirect("/admin/labels");
		}else{
			$errorB->appendJSError("Ошибка во время диалога с БД !");
			$errorB->redirect("/server_.html");
		}
	}else{
		$errorB->appendJSError("Выбранный элемент не существует !");
		$errorB->redirect("/admin/labels");
	}
}
print $errorB->outputData();