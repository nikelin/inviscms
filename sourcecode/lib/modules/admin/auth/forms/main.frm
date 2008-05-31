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
$extr=isset($GLOBALS['params']['params'][2])?$GLOBALS['params']['params'][2]:null;
$method=isset($GLOBALS['params']['params'][1])?$GLOBALS['params']['params'][1]:null;
if($database->getSQLParameter("settings","extr_auth_enabled",1)=='on' && $method && $method=='extr' && $extr)
{
	$errors=new Errors();
	if($security->proceedEXTR($extr))
	{
		$errors->appendJSError("Вы успешно прошли процедуру авторизации !");
		if($sessions->registerData("admin_auth",uniqid('i',true),array(time(),3600*3),true))
		{		
			if($database->updateRow("users",array("laccess"=>time(),"ip"=>$_SERVER['REMOTE_ADDR']),array("extr"=>$extr)))
			{
				$errors->appendJSError("Система доступна для использования с данного компьютера в течении 4 часов.");
				$errors->redirect("/admin/home");
			}else
			{
				$errors->appendJSError("Ошибка во время обновления пользовательских данных !");
				$errors->redirect("/server_.html");
			}
		}else
		{
			$errors->appendJSError("Ошибка во время регистрации пользовательской сессии !");
			$errors->redirect("/server_.html");
		}
	}else{
		$errors->appendJSError("Ошибка во время авторизации !");
		$errors->redirect("/bad_auth.html");
	}
	print $errors->outputData();
}else{
?>
<form action='' method='post' enctype='multipart/form-data'>
	<div class='form' style='margin-top:30px;margin-bottom:30px;'>
		  <span class='header center'><h2>Авторизация</h2></span>
		  <div class='row'>
		       <div class='label label1 center' style='width:100%;clear:both;'>
		            Введите ваш PIN-код
				 </div>
		  </div>
		  <div class='row'>
		       <div class='value center' style='width:100%;clear:both;'>
		            <input type='text' class='ui_input_003' style='width:10%;' name='a[]'/>
		            <input type='text' class='ui_input_003' style='width:10%;' name='a[]'/>
		            <input type='text' class='ui_input_003' style='width:10%;' name='a[]'/>
		            <input type='text' class='ui_input_003' style='width:10%;' name='a[]'/>
			  </div>
		  </div>
	   <div class='row'>
		       <div class='label label1 center' style='width:100%;clear:both;'>
					 Ваш ключ доступа
				 </div>
		  </div>
		  <div class='row'>
		       <div class='value center' style='width:100%;clear:both;'>
					 <input type='file' style='width:60%;background-color:#CCCCCC;' name='dYii'/>
			  </div>
		  </div>
	     <div class='row'>
		       <div class='label label1 submit' style='width:100%;clear:both;'>
					 <button name='action_main' style='width:100%;'>Проверить</button>
				 </div>
		  </div>
	</div>
</form>
<?php
}
?>