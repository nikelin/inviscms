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
/**
 * 
 * DEPRECATED METHODS
 * 
 **/

function auth_main($e=null)
{
	$database=&$GLOBALS['database'];
	$tools=&$GLOBALS['tools'];
	$security=&$GLOBALS['security'];
	
	if(!$security->authorized("client")){
		$e=$tools->encodeArrayData($e);
		if(is_array($e) && $tools->checkValues($e,array("email","passwd")))
		{
			if($security->proceedClientAuthorize($e['email'],$e['passwd']))
			{
				return 200;
			}
		}
	}else{
		return 200;
	}
	return 0;
}
function auth_success()
{
	$errors=new Errors();
	$errors->appendJSError("Спасибо! Авторизация прошла успешно!");
	$errors->redirect("/account");
	return $errors->outputData();
}

function auth_error()
{
	$errors=new Errors();
	$errors->htmlAppendError("Ошибка во время проведения авторизации !");
	return $errors->outputData("html");
}
?>
