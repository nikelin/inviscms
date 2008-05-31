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
if(!defined("MAIN_SCRIPT_LOADED")) die("Security error!");
$errors=new Errors();
$did=isset($GLOBALS['params']['params'][2])?$GLOBALS['params']['params'][2]:die("wrong param");
#die_R($GLOBALS['params']['params']);
if(is_numeric($did))
{
	if($database->checkRowExists("dicts",array("id"=>$did)))
	{
		$frm=new forms();
		$frm->init("POST","");
		$frm->addLegend("Удаление словаря №".$did);
		$frm->addField("Вы уверены, что хотите очистить данный словарь ?<br/>
		После очистики будет стёрта вся лексическая база словаря.","single");
		$frm->addHidden("did",$did);
		$frm->addSubmit("action_clear","Да, я хочу очистить данный словарь");
		$frm->addSubmit("action_clear","Нет");
		print $frm->render(true);
	}else{
		$errors->appendJSError("Данный словарь не существует!");
	}
}else
{
	$errors->appendJSError("Ошибочный формат параметра!");
}
print $errors->outputData();
?>
