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
if($_POST['action']=="save_changes"){
	if(isset($_POST['ids_d']) && count($_POST['ids_d'])>0){
	  foreach($_POST['ids_d'] as $k=>$v){
		 if(is_numeric($v)){
			  $data=$tools->getEnvVars("POST",true);
			  foreach($_POST['ids_d'] as $k=>$v){
				 $act=(is_array($data['ids']) && in_array($v,$data['ids']))?
			  	 											 ($database->deleteRow("texts",array("id"=>$v)))?'':$errorsB->appendJSError("Ошибка во время удаления директории !")
			  	 											 :
			  	 											 ($database->updateRow("texts",array("value"=>$data['names'][$k]),array("id"=>$v)))?1:$errorsB->appendJSError("Ошибка во время изменения настроек директории!");break;
															 ;
															 print $act;
				 }
				if($database->isError()){
				  $errorsB->appendJSError("Ошибка во время диалога с БД !");
				}
	   }else{
				$errorsB->appendJSError("WrongID!");
		}
	  }
	}
}elseif($_POST['action']=="create"){
		$data=$tools->getEnvVars("POST",true);
		if(trim($data['title'])==''){
		  $errorsB->appendJSError("Вы не ввели название директории !");
		}else{
		  if($database->checkRowExists("texts",array("value"=>$data['title'],"partition"=>"fdirs"))){
			 $errorsB->appendJSError("Директория с таким идентификатором уже существует !");
		  }else{
		      if(!$database->insertRow('texts',array('',"dir",$data['title'],'fdirs',""))){
				$errors->appendJSError("Ошибка во время диалога с БД !");
			  }
		  }
		}
}
$errorsB->redirect("/admin/files/dirs");
#print $errorsB->outputData();
?>
