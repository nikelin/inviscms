<?php
$id=$GLOBALS['params']['params'][2];
$errors=new Errors();
if($database->deleteRow("catalog",array("id"=>$id)))
{
	$errors->appendJSError("Товар успеш удалён !");
	$errors->redirect("/admin/store/main");
}else
{
	$errors->appendJSError("Ошибка во время удаления товара !");
	$errors->redirect("/server_.html");
}

print $errors->outputData();
?>