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
	$frmB=new forms();
	$frmB->init("POST","","","userReg","add_page",array("style"=>"margin-bottom:50px;display:block;"));
    $frmB->addLegend("Создание статичной страницы");
    $frmB->addInput("text","title",$frmB->addField("Введите заголовок страницы"));
    $frmB->addField("Язык материала:","pair",$tools->buildList("select","lang",array('datasource'=>'dicts','label'=>'name','value'=>'id')));
	$frmB->addInput("text","ufu",$frmB->addField("Короткий адрес страницы"));
    $frmB->addInput("text","keywords",$frmB->addField("Ключевые слова(теги):"));
    $frmB->addInput("textarea","description",$frmB->addField("Введите описание страницы:","single"),"editor",array("style"=>"width:100%;height:150px;"));
    $frmB->addInput("textarea","text",$frmB->addField("Введите текст страницы:","single"),"content",array("style"=>"width:100%;height:100%;height:150px;"));
    $frmB->addInput("text","slug",$frmB->addField("Текст в заголовке броузера:","pair"));
	$frmB->addInput("select","type",$frmB->addField("Выберите тип страницы:","pair"),"","",array("pub"=>"Публикация","text"=>"Статическая страница"));
    $frmB->addSubmit("action_add","Создать");
    print $frmB->render(true);
	?>