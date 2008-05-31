<?php
$data=$tools->getEnvVars('POST',true);
$errorB=new Errors();
if(!$tools->checkValues($data,array('title','link'))){
  $errorB->appendJSError("Ошибка во время проверки формы !");
}else{
  if(!$database->checkRowExists('menu',array('title'=>$data['title'])))
  {
      $lang=(isset($data['lang']))?$data['lang']:0;
	if(!$database->insertRow('menu',array('',$data['title'],$data['link'],$data['alt'],$data['target'],$data['place'],'LAST_INSERT_ID()',$lang,'on')))
	{
	  $errorB->appendJSError("Ошибка во время создания элемента меню !");
		$errorB->redirect("/server_.html");
	}else{
	  $errorB->appendJSError("Элемент успешно добавлен в БД !");
	  $errorB->redirect("/admin/menu/main");
	}
  }else
  {
	$errorB->appendJSError("Элемент с таким текстом уже существует !");
  	$errorB->redirect("/admin/menu/main");
  }
}
print $errorB->outputData();
?>
