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
$frm->init("POST","","multipart/form-data");
$frm->setCSSValue("singleFieldLabelClass","label1");
$frm->addLegend("Пакетная загрузка");
$frm->addField("<span style='font-size:14px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;С помощью данной функции вы можете загрузить архив содержащий<br/> изображения, которые вы хотите загрузить на сайт.
	После загрузки будет произведена автоматическая обработка архива и загрузка изображений на сайт.<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;В качестве директории присваивается директория по-умолчания - <strong>default</strong>.<br/>
	Название устанавливается <strong>аналогичным</strong> имени файла.<br/>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Чтобы вместе с файлом загружалась информация о файле вам необходимо вместе с файлами добавить<br/>
	к архиву документ <strong>info.xml</strong>, который будет содержать следующий текст:<br/>
	<pre style='font-size:15px;font-weight:bold;'>
	&lt;?xml version='1.0'?>
	&lt;data>
		&lt;file name='{имя_файла_в_архиве}'>
			&lt;name>ИМЯ ФАЙЛА&lt;/name>
			&lt;dir>ДИРЕКТОРИЯ&lt;/dir>
			&lt;description>
				ОПИСАНИЕ ФАЙЛА
			&lt;/description>
		&lt;/file>
	&lt;/data></span>
	</pre>","single");
$frm->addField("<strong>Категория файлов:</strong>".$tools->buildList("select","cat",array('datasource'=>'texts','label'=>'value','value'=>'id',"where"=>array('partition'=>'fdirs'))),"single");
$frm->addInput("file","fl",$frm->addField("Выберите файла (*.zip):","pair"));
$frm->addSubmit("action_aupload","Загрузить");
print $frm->render(true);
?>