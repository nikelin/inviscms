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
$frm->addLegend("Отправка рассылки");
$frm->addInput("text","subject",$frm->addField("Тема рассылки:","pair"),"",array("style"=>"width:55%;"));
$frm->addField("Дата отправки:","pair",$tools->pasteDateForm("detail"));
$frm->addInput("select","type",$frm->addField("Выберите формат данных:","pair","",array("style"=>"text-align:center;")),"",array("style"=>"width:53%;height:95%;font-size:13px;"),array("text/html"=>"HTML-форматированный документ","plain/text"=>"Текст без форматирования и графики"));
$frm->addInput("textarea","text",$frm->addField("Текстовый вариант рассылки","single"),"",array("style"=>"width:100%;height:400px;"));
$frm->addInput("textarea","text",$frm->addField("HTML-вариант рассылки","single"),"editor",array("style"=>"width:100%;height:400px;"));
$frm->addInput("checkbox","forall",$frm->addField("Отправлять всем подписчикам?","pair"));
$frm->addSubmit("send","Отправить");
print $frm->render(true);
?>