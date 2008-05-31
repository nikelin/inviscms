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
if($this->deniedModule('admin','adduser')) exit;
$data=$tools->getEnvVars('POST');
$errors=new Errors();
if(!$tools->checkValues($data,array("email")))
{
	$errors->appendJSError("Ошибка во время проверки формы !");
}else{
	if($database->checkRowExists("users",array("email"=>$data['email'])))
	{
		$errors->appendJSError("Данный пользователь уже существует!");
		$errors->redirect("/admin/auth");
	}else{
		$pin=mt_rand(10,99).mt_rand(10,99).mt_rand(10,99).mt_rand(10,99);
		$extr=$security->generateEXTR();
		$rnd_str=system::makeRandString(32);
		$key=system::crypt($pin.$data['email'],$rnd_str);
		$uid=$database->insertRow("users",array("",$extr,$pin,$key,$_SERVER['REMOTE_ADDR'],time(),0,$data['email'],"off"));
		if($database->isError()){
			$errors->appendJSError("Ошибка во время диалога с БД!");
			$errors->redirect("/server_.html");
		}else{
			$data.="Для того, чтобы получить ваши регистрационные данные, пожалуйста перейдите по следующей ссылке:<br/>"."\n";;
			$data.="<a href='".$GLOBALS['site_addr']."/admin/admins/approve/".$extr."' title='Нажмите для завершения регистрации'>";
			$data.=$GLOBALS['site_addr']."/admin/admins/approve/".$extr."\n";
			$data.="</a><br/>"."\n";;
			$data.="<hr/>"."\n";;
			$data.="Ссылка будет активна до ".date("H:i:s d.m.Y",time()+3600*60*3)."<br/>\n";
			$data.="\n";
			$mail=new mail();
			$mail->addTo($data['email'],"Администратору");
			$mail->setSubject("ФутболкаPrint: персональные данные");
			$mail->setFrom("robot@futbolkaprint.com.ua","Информационная служба магазина ФутболкаPrint(с)");
			$mail->setBodyHTML($data);
			if(@$mail->send())
			{
				$errors->appendJSError("Пользователь №".$uid." успешно создан!");
				#
				$errors->redirect("/admin");
			}else{
				$errors->appendJSError("Ошибка во время отправки данных по e-mail !");
				$errors->redirect("/server_.html");
			}
		}
	}
}
print $errors->outputData();