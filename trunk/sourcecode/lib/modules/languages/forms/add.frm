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
	$errors=new Errors();
	$frm=new forms();
	$frm->init("POST","");
	$frm->addLegend("Создание словаря");
	$frm->addInput("text","name",$frm->addField("Название словаря:","pair"));
	if($database->checkRowExists("dicts")){
		$frm->addField("Создать на основе другого словаря:","pair",$tools->buildList("select","fsource",array("datasource"=>"dicts","label"=>"name","value"=>"id")));
	}	
	$frm->addSubmit("action_add","Создать");
	print $frm->render(true);
?>