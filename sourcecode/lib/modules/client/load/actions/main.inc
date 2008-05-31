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
$error=new Errors();
$clients=&$GLOBALS['clients'];
$data=$tools->getEnvVars("POST");
if($tools->checkValues($data,array("name","contacts")) && ($tools->isEmail($data['contacts']) || $tools->isPhone($data['contacts'])))
{
	if(isset($_FILES['maket']) && filesize($_FILES['maket']['tmp_name'])!=0)
	{
		if($file=$dirs->uploadFile($_FILES['maket']['tmp_name']))
		{
			$client=($clients->getUID());
			$client=($client!=-1)?$client:$_SERVER['REMOTE_ADDR'];
			$q=$database->insertRow("orders",array("",$client,"none",time(),$file,"maket","active"));	
			if(!$database->isError())
			{
				$error->appendJSError("Заказ успешно отправлен!");
				$error->appendJSError("С вами свяжутся в течении 24 часов.");
				$error->appendJSError("Спасибо!");
				$error->redirect("/home");
			}else{
				$error->appendJSError("Ошибка во время диалога с БД!");
				$error->redirect("/server_.html");
			}
		}else{
			$error->appendJSError("Внутренняя ошибка системы!");
			$error->redirect("/server_.html");
		}
	}else{
		$error->appendJSError("Файл не выбран, либо поврёждён.");
	}
}else{
	$error->appendJSError("Ошибка во время проверки данных формы!");
}
print $error->outputData();