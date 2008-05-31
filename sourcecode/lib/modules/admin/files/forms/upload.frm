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
$fls=array();
$frmB->init("POST","","multipart/form-data");
$frmB->setCSSValue('formMainStyle','width:100{percent};margin-left:0;');
$frmB->addLegend("Загрузка файла на сайт");
$fls['title']=$frmB->addInput('text','title',$frmB->addField("Название файла:","pair"),"",array("style"=>"width:55%;"));
$fls['file']=$frmB->addInput("file","file",$frmB->addFIeld("Выберите файл для загрузки:","pair"));
$d=$tools->buildList("select","dir",array("datasource"=>"texts","where"=>array("partition"=>"fdirs"),"label"=>"value","value"=>"id"));
$d=($d)?$d:'<button style="display:block;" onclick=\'Invis.core.loadPage("files","dirs");return false;\'>Добавить</button>';
$fls['dir']=$frmB->addField("Директория для загрузки:","pair",$d);
$fls['comment']=$frmB->addInput("textarea","comment",$frmB->addField("Примечание к файлу","single"),"",array("style"=>"width:100%;"));
$frmB->addSubmit("action_upload","Загрузить");
print $frmB->render(true);
?>