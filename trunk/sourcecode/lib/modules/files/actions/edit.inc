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
$errorsB=new Errors();
$data=$tools->getEnvVars("POST",true);
$file=$_FILES['file'];
if(trim($data['title'])==''){
  $data['title']=$file['name'];
}
if(!$database->checkRowExists("files",array("id"=>$_POST['id']))){
	 $errorsB->appendJSError("Данный файл не существует в базе !");
	 $errorsB->redirect("/admin/files/main");
}else{
    if(!$database->updateRow('files',array("dir_id"=>($data['dir']=='')?'default':$data['dir'],"title"=>$data['title'],"comment"=>$data['comment']),array("id"=>$data['id'])))
    {
		$errorsB->appendJSError("Ошибка во время диалога с БД !");
		$errorsB->redirect("/server_.html");
	}else{
		$errorsB->appendJSError("Информация успешно сохранена !");
		$errorsB->redirect("/admin/files/main");
	}
}
print $errorsB->outputData();
?>
