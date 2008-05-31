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
$error=new Errors();
if(!$tools->checkValues($data,array("title")))
{
	$error->appendJSError("Ошибка во время проверки формы !");
}else{
	if($database->checkRowExists("developers",array("title"=>rawurlencode($data['title']))))
	{
		$error->appendJSError("Данный поставщик уже добавлен в базу !");
		$error->redirect("/server_.html");
	}else{
		$pid=$database->insertRow("developers",array("",rawurlencode($data['title']),$data['country'],$data['logo'],$data['description'],'on'));
		if(!$database->isError()){
			$error->appendJSError("Поставщик успешно добавлен в базу под №".$pid."!");
		}else{
			$error->appendJSError("Ошибка во время диалога с БД !");
			$error->redirect("/server_.html");
		}
	}
}
$error->redirect("/admin/developers");
print $error->outputData();
?>