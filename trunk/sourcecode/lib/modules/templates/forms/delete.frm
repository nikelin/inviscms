<?php
/*******
 * FIXME:: need of adding foreign keys checking
 */
$errors=new Errors();
$id=$GLOBALS['params']['params'][2];
if(is_numeric($id) && $id>0)
{
	if($database->checkRowExists('templates',array('id'=>$id)))
	{
		if($database->deleteRow("templates",array('id'=>$id)))
		{
			$errors->appendJSError("Шаблон был успешно удалён !");
		}else
		{
			$errors->appendJSError("Ошибка во время диалога с БД!");
		}
	}else
	{
		$errors->appendJSError("Данный шаблон не существует !");
	}
}else
{
	$errors->appendJSError("Неверный формат данных !");
}
$errors->redirect("/admin/templates/main");
print $errors->outputData();
?>