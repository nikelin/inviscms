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
$errorB=new Errors();
$params=$GLOBALS['params']['params'];
if(!$database->checkRowExists("pages",array('id'=>$params[2])) || $database->isError()){
	$errorB->appendJSError("Такая страница не существует !");
  $errorB->redirect("/admin/pages");
}else{
	$row=$database->fetchQuery($database->getRows("pages","*",array("id"=>$params[2])));
	$frmB=new forms();
	$frmB->init("POST","","","userReg","add_page",array("style"=>"margin-bottom:50px;display:block;"));
    $frmB->addLegend("Создание статичной страницы");
    $frmB->addInput("text","title",$frmB->addField("Введите заголовок страницы","pair"),"","",$tools->decodeString($row['title']));
    $frmB->addField("Язык материала:","pair",$tools->buildList("select","lang",array('datasource'=>'dicts','label'=>'name','value'=>'id'),array('value'=>$row['lang'])));
	$frmB->addInput("text","ufu",$frmB->addField("Короткий адрес страницы","pair"),"","",$row['ufu']);
    $frmB->addInput("text","keywords",$frmB->addField("Ключевые слова(теги):"),"","",rawurldecode($row['keywords']));
    $frmB->addInput("textarea","description",$frmB->addField("Введите описание страницы:","single"),"editor",array("style"=>"width:100%;height:150px;"),stripslashes(rawurldecode($row['description'])));
    $frmB->addInput("textarea","text",$frmB->addField("Введите текст страницы:","single"),"content",array("style"=>"width:100%;height:100%;height:150px;"),stripslashes(rawurldecode($row['text'])));
    $frmB->addInput("text","slug",$frmB->addField("Текст в заголовке броузера:","pair"),"","",rawurldecode($row['slug']));
	$frmB->addInput("select","type",$frmB->addField("Выберите тип страницы:","pair"),"","",array("pub"=>"Публикация","text"=>"Статическая страница"));
    $frmB->addSubmit("action_edit","Сохранить");
    print $frmB->render(true);
}
print $errorB->outputData();
?>
