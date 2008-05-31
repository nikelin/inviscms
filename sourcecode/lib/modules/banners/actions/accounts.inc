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
$errorsB=new Errors();
if(isset($_POST['ids']) && count($_POST['ids'])>0){
  foreach($_POST['ids'] as $k=>$v){
	 if(is_numeric($v) && $v!=0){
		switch($_POST['action']){
		  case 'delete':($database->deleteRow("banners",array("id"=>$v)))?$errorsB->appendJSError("Баннер успешно удалён !"):$errorsB->appendJSError("Ошибка во время удаления баннера !");break;
		  case 'deny': ($database->updateRow("banners",array("status"=>"off"),array("id"=>$v)))?$errorsB->appendJSError("Баннер успешно заблокирован."):$errorsB->appendJSError("Ошибка во время блокировки баннера !");break;
		  case 'restore': ($database->updateRow("banners",array("status"=>"on"),array("id"=>$v)))?$errorsB->appendJSError("Баннер успешно восстановлен!"):$errorsB->appendJSError("Ошибка во время восстановления сбаннера !");break;
		  default: $errorsB->appendJSError("Неправильный идентификатор действия !");break;
		}
		if($database->isError()){
		  $errorsB->appendJSError("Ошибка во время диалога с БД !");
		}
	 }else{
			 $errorsB->appendJSError("Недопустимое значение идентификатора !");
	 }
  }
}
$errorsB->redirect("/admin/banners/accounts");
print $errorsB->outputData();
?>
