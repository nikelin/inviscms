<?php
$data=$tools->getEnvVars("POST",true);
if($tools->checkValues($data,array("email","url")))
{
	if(!$database->checkRowExists("aff_requests",array("email"=>$data['email'])))
	{
		if($database->insertRow("aff_requests",array("",$data['email'],$data['url'],$_SERVER['REMOTE_ADDR'],"on")))
		{
			$attempts->send("Новый запрос на участие в партнёрке","Пользователь с e-mail: ".$data['email'].", и сайтом: ".$data['url'],"LoRd1990@gmail.com");
			$errors->appendJSError("Спасибо! Мы оповестим вас, когда программа стартует.");
			$errors->redirect("/");
		}else
		{
			$errors->appendJSError("Ошибка во время диалога с БД!");
			$errors->redirect('/server_.html');
		}
	}else
	{
		$errors->appendJSError("Вы уже зарегистрировались. Ждите!");
		$errors->redirect("/");
	}
}else
{
	$errors->appendJSError("Вы не ввели необходимую информацию!");
	$errors->redirect("/");
}
print $errors->outputData();
?>