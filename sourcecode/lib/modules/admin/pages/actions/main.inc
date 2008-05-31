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
  $stop=0;
  foreach($_POST['ids'] as $k=>$v){
	 if(is_numeric($v) && $v!=0 && !$stop){
		switch($_POST['action']){
		  case 'delete':($database->deleteRow("pages",array("id"=>$v)))?$errorsB->appendJSError("Программа под №".$v." успешно удалена !"):$errorsB->appendJSError("Ошибка во время удаления программы под №".$v." !");break;
		  case 'deny': ($database->updateRow("pages",array("status"=>"off"),array("id"=>$v)))?$errorsB->appendJSError("Программа под №".$v."  успешно заблокирована."):$errorsB->appendJSError("Ошибка во время блокировки программы под №".$v." !");break;
		  case 'restore': ($database->updateRow("pages",array("status"=>"on"),array("id"=>$v)))?$errorsB->appendJSError("Программа под №".$v." успешно восстановлена!"):$errorsB->appendJSError("Ошибка во время восстановления программы под №".$v." !");break;
   	  case 'main':
		  		 if($database->updateRow("pages",array("frontpage"=>'0'),array("frontpage"=>'1')))
				 {
              $database->updateRow("pages",array("frontpage"=>1),array("id"=>$v))?$errorsB->appendJSError("Страница под №".$v." успешно установлена в качестве основной !"):$errorsB->appendJSError("Ошибка во время обновления данных !");
				  $stop=1;
				 }
				 break;
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
$errorsB->redirect("/admin/pages");
print $errorsB->outputData();
?>
