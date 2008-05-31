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
$part=isset($GLOBALS['params']['params'][2])?$GLOBALS['params']['params'][2]:null;
switch($part)
{
	case 'client':
	break;
	case 'banner':
		$id=isset($GLOBALS['params']['params'][3])?$GLOBALS['params']['params'][3]:null;
		if(!is_numeric($id) || $id<=0)
		{
			if($database->deleteRow("banners",array("id"=>$id)))
			{
				$errors->appendJSError("Баннер успешно удалён!");
				$errors->redirect("/admin/banners/banners");
			}else
			{
				$errors->appendJSError("Ошибка во время диалога с БД!");
				$errors->redirect("/server_.html");
			}
		}else{
			$errors->appedJSError("Ошибочное значение параметров!");
			$errors->redirect("/admin/banners/banners");
		}
	break;
	default:
		$errors->redirect("/admin/banners/banners");
}
print $errors->outputData();
?>
