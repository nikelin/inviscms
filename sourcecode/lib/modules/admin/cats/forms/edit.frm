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
$id=isset($GLOBALS['params']['params'][2])?$GLOBALS['params']['params'][2]:die();
$errors=new Errors();
if(is_numeric($id) && $id>=1)
{
    if($database->checkRowExists("cats",array("id"=>$id))){
        $data=$database->fetchQuery($database->getRows("cats","*",array("id"=>$id)));
        $frm=new forms();
        $frm->init("POST","");
        $frm->addLegend("Редактирование категории");
        $frm->addInput("text","title",$frm->addField("Название категории:","pair"),"","",rawurldecode($data['title']));
        $frm->addInput('text',"pos",$frm->addField("Позиция элемента:","pair"),"","",$data['pos']);
        $frm->addField("Категория родитель:","pair",$tools->buildList("select","pid",array("datasource"=>"cats","value"=>"id","label"=>"title"),array("value"=>$data['pid'])));
       	$frm->addHidden("id",$data['id']);
	    $frm->addSubmit("action_edit","Сохранить");
        print $frm->render(true);
    }else{
        $errors->appendJSError("Данная категория не существует!");
    }
}else{
    $errors->appendJSError("Неверный формат данных!");
}
print $errors->outputData();
?>