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
$fls=array();
$frm->init("POST","","","","",array("style"=>"display:block;margin-top:20px;margin-bottom:20px;"));
$frm->addLegend("База поставщиков");
$fls['title']=$frm->addInput("text","title",$frm->addField("Наименование поставщика:","pair"));
$fls['country']=$frm->addField("Страна поставки:","pair",$tools->buildList("select","country",array("datasource"=>"countries","label"=>"value","value"=>"id")));
$fls['logo']=$frm->addField("Выберите логотип компании:","pair",$tools->buildList("select","logo",array("datasource"=>"files","label"=>"title","value"=>"id")));
$fls['description']=$frm->addInput("textarea","description",$frm->addField("Описание:","single"),"",array("style"=>"width:100%;"));
$frm->addSubmit("action_add","Добавить");
print $frm->render(true);
?>