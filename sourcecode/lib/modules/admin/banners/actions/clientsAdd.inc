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
  $errorB=new Errors();
  $data=$tools->getEnvVars('POST',true);
  if(!$tools->checkValues($data,array('fio','email','url'))){
	$errorB->appendJSError('Ошибка во время проверки переданной информации !');
  }else{
		  if($database->checkRowExists('clients',array("email"=>$data['email'])))
		  {
			 $errorB->appendJSError("Клиент с такими данными уже был добавлен в базу !");
		  }else{
	      		if(!$database->insertRow('clients',array("",$data['fio'],$data['email'],$data['city'],time(),$data['comment'],'banners',$_SERVER['REMOTE_ADDR'],'on')))
		 		{
					$errorB->appendJSError('Ошибка во время диалога с БД !');
				}else{
					$errorsB->redirect("/admin/banners/clients");
				}
        }
  }
$errorB->redirect("/admin/banners/clients");
print $errorB->outputData();
?>
