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
$id=$GLOBALS['params']['params'][2];
if(!is_numeric($id) || $id<=0)
{
	$errors->appendJSError("Ошибка во время проверки параметров!");
	$errors->redirect("/admin/banners/banners");
}else{
	if(!$database->checkRowExists("banners",array("id"=>$id)))
	{
		$errors->appendJSError("Данный баннер не существует!");
		$errors->redirect("/admin/banners/banners");
	}else
	{
		$status=($database->getSQLParameter("banners","status",array("id"=>$id))=="off")?"on":"off";
		$q=$database->updateRow("banners",array("status"=>$status),array("id"=>$id));
		if(!$database->isError())
		{
			$errors->appendJSError("Баннер успешно ".(($status=='on')?'разблокирован':'заблокирован').".");
			$errors->redirect('/admin/banners/banners');
		}else{
			$errors->appendJSError("Ошибка во время диалога с БД!");
			$errors->redirect('/server_.html');
		}
	}
}
print $errors->outputData();
?>