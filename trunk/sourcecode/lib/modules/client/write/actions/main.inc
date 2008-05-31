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
$data=$tools->getEnvVars("POST");
if($tools->checkValues($data,array("name","subject","text")))
{
	$q=$database->insertRow('messages',array("",$data['subject'],$data['sender'],$data['reply_to'],$data['text'],time(),$_SERVER['REMOTE_ADDR']));
	if(!$database->isError()){
		$errors->appendJSError("Ваше сообщение успешно отправлено!");
	}else{
		$errors->appendJSError("Ошибка во время диалога с БД!");
		$errors->redirect('/server_.html');
	}
}else{
	$errors->appendJSError("Ошибка при проверки информации!");
}
print $errors->outputData();
?>