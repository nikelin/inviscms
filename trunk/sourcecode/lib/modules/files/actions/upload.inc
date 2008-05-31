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
?>
<?php
$errorsB=new Errors();
$data=$tools->getEnvVars("POST",true);
$file=$_FILES['file'];
if(trim($data['title'])==''){
  $data['title']=$file['name'];
}
if($database->checkRowExists("files",array("title"=>$data['title']))){
	 $errorsB->appendJSError("Файл с таким названием уже существует в базе данных !");
	 $errorsB->redirect("/admin/files/main");
}else{
  $genName=md5(time());
  $name=explode('.',$file['name']);
  $ext=$name[1];
  $filePath='./lib/files';
  if($file['tmp_name']!=''){
  	 $src=$dirs->writeFile($filePath,$ext,file_get_contents($file['tmp_name']));
	  $type=preg_match('/(gif|png|jpeg|jpg|bmp)+/i',$ext)?'image':'file';
	  if(!$database->insertRow('files',array('LAST_INSERT_ID',($data['dir']=='')?'default':$data['dir'],$ext,$data['title'],$src,time(),filesize($file['tmp_name']),$data['comment'],$type,'on')))
			{
			 #die_r($database->sqlErrorString());
			 $errorsB->appendJSError("Ошибка во время диалога с БД !");
			 $errorsB->redirect("/server_.html");
			}else{
			  $errorsB->appendJSError("Информация успешно сохранена !");
			  $errorsB->redirect("/admin/files/main");
			}
		}else
		{
			$errorsB->appendJSError("Ошибка во время сохранения файла на сервере !");
	 		$errorsB->redirect("/server_.html");
  		}
}
print $errorsB->outputData();
?>
