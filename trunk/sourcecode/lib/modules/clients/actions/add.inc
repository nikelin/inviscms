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
	$data=$tools->getEnvVars('POST',true);
	if(!$tools->checkValues($data,array('fio','email'))){
	  $error->appendJSError("Ошибка во время проверки данных формы.");
	}else{
   		if(!$database->checkRowExists("clients",array("email"=>$email))){
			  if(!$database->insertRow('clients',array(
		                                             array('name'=>'id','value'=>'LAST_INSERT_ID()','type'=>'funct'),
				  													array('name'=>'fio','value'=>$data['fio'],'type'=>'string'),
				  													array('name'=>'email','value'=>$data['email'],'type'=>'string'),
				  													array('name'=>'city','value'=>$data['city'],'type'=>'string'),
																	array('name'=>'comment','value'=>$data['comment'],'type'=>'string'),
		                                             array('name'=>'type','value'=>'banners','type'=>'string'),
		                                             array('name'=>'status','value'=>'on','type'=>'string'),
																	)))
					{
					  $error->appendJSError('Ошибка во время диалога с БД !');
	  		      }else{
							$error->redirect("/admin/clients/main");
					}
	   }else{
		  $error->appendJSError("Клиент с такими данными уже существует в базе.");
		}
 }
 print $error->outputData();
?>
