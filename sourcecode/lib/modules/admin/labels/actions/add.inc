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
$errorB=new Errors();
if(!$tools->checkValues($data,array("title","file")))
{
	$errorB->appendJSError("Ошибка во время проверки формы !");
}else
{
	if($database->checkRowExists("labels",array("title"=>$data['title'])))
	{
		$errorB->appendJSError("Данная картинка уже добавлена в БД !");	
	}else
	{
		$tid=$database->insertRow("labels",array("",isset($data['cat'])?$data['cat']:0,$data['file'],$data['title'],"vector",'on'));
		if($tid)
		{
			$errorB->appendJSError("Картинка успешно сохранена под №".$tid." !");
			$errorB->redirect("/admin/labels/main");
		}else{
			die($database->sqlErrorString());
			$errorB->appendJSError("Ошибка во время добавлена картинки в БД !");
		}
	}
}
print $errorB->outputData();
?>
