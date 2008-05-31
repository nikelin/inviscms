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
$param=$GLOBALS['params']['params'][2];
$q=$database->proceedQuery("SELECT * FROM `#prefix#_users` WHERE extr='".$param."' AND status='off'");
$errors=new Errors();
if(!$database->isError())
{
	if($database->getNumrows($q)!=0)
	{
		$data=$database->fetchQuery($q);
		if($database->updateRow("users",array("status"=>"on"),array("extr"=>$param,"status"=>"off")))
		{
			if($sessions->registerData("key_load_".md5($_SERVER['REMOTE_ADDR']),$key,array(time(),3600*60*3)))
			{
				$errors->appendJSError("Спасибо! Регистрация подтверждена, подождите секунду...");
				$errors->redirect("/load.php?s=session&id=key_load_".md5($_SERVER['REMOTE_ADDR']));
			}else
			{
				$errors->appendJSErorr("Ошибка во время регистрации пользователя!");
				$errors->redirect("/server_.html");
			}
			#$system->blockModule('admin','adduser');
		}else{
			$errors->appendJSError("Ошибка во время внесения правок в БД!");
			$errors->redirect("/");
		}
	}else{
		$errors->appendJSError("Ошибка во время проверки данных (возможно подтверждение уже имело место) !");
		$errors->redirect('/admin');
	}
}else{
	$errors->appendJSError("Ошибка во время диалога с БД!");
	$errors->redirect('/server_.html');
}
print $errors->outputData();
?>