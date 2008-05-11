<?php
$errorsB=new Errors();
if(isset($_POST['ids']) && count($_POST['ids'])>0){
  foreach($_POST['ids'] as $k=>$v){
	 if(is_numeric($v) && $v!=0){
		switch($_POST['action']){
		  case 'delete':($database->deleteRow("menu",array("id"=>$v)))?$errorsB->appendJSError("Программа под №".$v." успешно удалена !"):$errorsB->appendJSError("Ошибка во время удаления программы под №".$v." !");break;
		  case 'deny': ($database->updateRow("menu",array("status"=>"off"),array("id"=>$v)))?$errorsB->appendJSError("Программа под №".$v."  успешно заблокирована."):$errorsB->appendJSError("Ошибка во время блокировки программы под №".$v." !");break;
		  case 'restore': ($database->updateRow("menu",array("status"=>"on"),array("id"=>$v)))?$errorsB->appendJSError("Программа под №".$v." успешно восстановлена!"):$errorsB->appendJSError("Ошибка во время восстановления программы под №".$v." !");break;
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
$errorsB->redirect("/admin/menu/main");
print $errorsB->outputData();
?>
