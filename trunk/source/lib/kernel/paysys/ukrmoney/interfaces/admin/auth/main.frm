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
$frm=new forms();
$errors=new Errors();
$system=&$GLOBALS['system'];
$tools=&$GLOBALS['tools'];
if(isset($_POST['auth_change']))
{
	$errB=new Errors();
	$data=$tools->getEnvVars("POST",true);
	if(!$tools->checkValues($data,array("login","passwd")))
	{
		$errB->appendJSError("Ошибка во время проводки данных!");
	}else{
		if(!$this->changeAuthInfo('ukrmoney',array('login'=>$data['login'],'passwd'=>$data['passwd'])))
		{
			$errB->appendJSError("Ошибка во время изменения настроек!");
		}else{
			$errB->appendJSError("Информация успешно скорректирована!");
		}
	}
	print $errB->outputData();
}
$data=$this->getAuthInfo('ukrmoney');
if($data)
{
	$frm->init("POST","");
	$frm->addLegend("Настройки авторизационных данных");
	$frm->addInput("text","login",$frm->addField("Логин доступа:","pair"),"","",$data['login']);
	$frm->addInput("text","passwd",$frm->addField("Пароль доступа:","pair"),"","",$data['passwd']);
	if(count($data)>2)
	{
		foreach($data as $k=>$v)
		{
			$frm->addInput("text",$k,$frm->addField("Значения поля ".$k.":","pair"),$v);
		}	
	}
	$frm->addInput("checkbox","crypt",$frm->addField("Произвести шифрование данных?","pair"));
	$frm->addField("Изменить ключ шифрования данных можно в разделе 'Настройки'","single");
	$frm->addSubmit("auth_change","Сохранить изменения");
	print $frm->render('true');
}else{
	$errors->appendJSError("Ошибка во время обработки авторизационного файла!\nВозможно вы не ввели ключ декодирования.\nЕсли вы уверены, что причина не в этом - обращайтесь в службу поддержки.");
	$errors->redirect('/admin/settings');
}
?>