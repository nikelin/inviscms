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
$frm->addLegend("Служба поддержки сайта");
$frm->addInput('text','subject',$frm->addField("Введите тему письма:","pair"));
$frm->addInput('text','page',$frm->addField("Страница на которой произошла ошибка:","pair"));
$frm->addInput('textarea','when',$frm->addField("Ваши действия, предшествующие сбою:","signle"));
$frm->addInput('textarea','comments',$frm->addField("Сообщение службе поддержки:","pair"));
$frm->addInput('text','reply_type',$frm->addField("Каким образом нам с вами связатся:","pair"));
$frm->addInput('text','reply_to',$frm->addField("Контактный адрес (в зависимости от выбранного способа связи):"));
$frm->addSubmit("action_support","Отправить");
print $frm->render(true);
?>