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
$frm->addLegend("Создание шаблона футболки");
$frm->setCSSValue("formMainStyle","width:100{percent};margin-left:0;");
$frm->addInput("text","title",$frm->addField("Введите название шаблона:","pair"));
$frm->addInput("select","type",$frm->addField("Выберите тип футболки:","pair"),"","",array('male'=>"Мужская","female"=>"Женская","child"=>"Детская"));
$frm->addField("Поставщик продукции:","pair",$tools->buildList('select','developer',array('datasource'=>'developers','label'=>'title','value'=>'id')));
$frm->addInput("text","price",$frm->addField("Цена футболки:","pair"));
$frm->addField("Перёд футболки:","pair",$tools->buildList("select","front",array('datasource'=>'files','value'=>'id','label'=>'title')));
$frm->addField("Спина:","pair",$tools->buildList("select","back",array('datasource'=>'files','value'=>'id','label'=>'title')));
$frm->addField("Категория:","pair",$tools->buildList("select","cat",array('datasource'=>'cats','value'=>'id','label'=>'title')));
$frm->addSubmit("action_add","Добавить");
print $frm->render(true);
?>