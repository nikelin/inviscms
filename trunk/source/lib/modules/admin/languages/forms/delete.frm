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
$id=$GLOBALS['params']['params'][2];
$errors=new Errors();
if(is_numeric($id) && $id!=0)
{
	if($database->checkRowExists("dicts",array("id"=>$id)))
	{
		$frm=new forms();
		$frm->init("POST","");
		$frm->addLegend("Удаление словаря №".$id);
		$frm->addField("Вы уверены, что хотите удалить данный словарь ?<br/>
		Вместе со словарём, будет так же удалена и база лексики.","single");
		$frm->addHidden("did",$id);
		$frm->addSubmit("action_delete","Да, я хочу удалить данный словарь");
		$frm->addSubmit("action_delete","Нет");
		print $frm->render(true);
	}else{
		$errors->appendJSError("Данный словарь не существует !");
	}
}
print $errors->outputData();
?>