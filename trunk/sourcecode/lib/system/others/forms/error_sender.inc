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
function error_sender_main($data)
{
	$result=0;
	$database=&$GLOBALS['database'];
	$tools=&$GLOBALS['tools'];
	if($tools->checkValues($data,'email'))
	{
		if($tools->isEmail($data['email']))
		{
			$q=$database->insertRow("messages",array("","Ошибка на сайте","System Robot",$data['email'],"",time(),$_SERVER['REMOTE_ADDR']));
			if(!$database->isError())
			{
				$result=200;
			}
		}
	}
	return $result;
}

function error_sender_success()
{
	$errors=new Errors();
	$errors->appendJSError("Спасибо! Мы обязательно устраним все проблемы!");
	$errors->redirect("/");
	return $errors->outputData();	
}

function error_sender_error()
{
	$errors=new Errors();
	$errors->appendJSError("Внутренняя ошибка системы!");
	$errors->redirect("/server_.html");
	return $errors->outputData();	
}
?>
