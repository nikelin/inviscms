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
$client=$GLOBALS['params']['params'][2];
if(is_numeric($client) && $client>=0)
{
	if($database->checkRowExists("clients",array("id"=>$client)))
	{
		$q=$database->proceedQuery("SELECT email FROM `#prefix#_clients` WHERE id=".$client);
		if(!$database->isError())
		{
			$data=$database->fetchQuery($q);
			$recipient=rawurldecode($data['email']);
		}else{
			$recipient='Unknown';
		}
	}else{
		$errors->appendJSError("Данный пользователь не найден!");
	}
}else{
	$recipient='';
}
$frm=new forms();
$frm->init("POST","");
$frm->addLegend("Отправка письма");
$frm->addInput("text","recipient",$frm->addField("E-mail получателя:","pair"),"","",$recipient);
$frm->addInput("text","subject",$frm->addField("Тема письма:","pair"));
$frm->addInput("textarea","text",$frm->addField("E-mail получателя:","single"));
$frm->addSubmit("action_main","Отправить");
print $frm->render(false);
?>