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
$frm->init("POST","");
$frm->addLegend("Создание новой категории");
$frm->addInput("text","title",$frm->addField("Название категории:","pair"));
$frm->addField("Категория родитель:","pair",$tools->buildList("select","pid",array("datasource"=>"cats","value"=>"id","label"=>"title"),array("default"=>-1)));
$frm->addSubmit("action_add","Добавить");
print $frm->render(true);
?>