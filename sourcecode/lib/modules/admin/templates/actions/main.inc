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
		  case 'delete':
		  	die_r($database->checkLinks("templates","id",$v,array("catalog","tid")));
		  	$d=($database->deleteRow("templates",array("id"=>$v)))?$errorsB->appendJSError("Позиция №".$v." удалена !"):$errorsB->appendJSError("Ошибка во время удаления позиции №".$v." !");
			break;
		  case 'deny': $d=($database->updateRow("templates",array("status"=>"off"),array("id"=>$v)))?$errorsB->appendJSError("Позиция №".$v." успешно заблокирована."):$errorsB->appendJSError("Ошибка во время блокировки позиции №".$v." !");break;
		  case 'restore': $d=($database->updateRow("templates",array("status"=>"on"),array("id"=>$v)))?$errorsB->appendJSError("Позиция №".$v." успешно восстановлена!"):$errorsB->appendJSError("Ошибка во время восстановления позиции №".$v." !");break;
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
$errorsB->redirect("/admin/templates");
print $errorsB->outputData();
?>
