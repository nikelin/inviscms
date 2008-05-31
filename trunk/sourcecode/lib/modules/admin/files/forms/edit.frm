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
$id=$GLOBALS['params']['params'][2];//CHECK
if(!$database->checkRowExists("files",array("id"=>$id))){
    $errors->appendJSError("Данный файл не существует в базе !");
    $errors->redirect("/admin/files/main");
}else{
    $q=$database->getRows("files","*",array("id"=>$id));
    if(!$database->isError()){
        $row=$database->fetchQuery($q);
        $frmB=new forms();
        $fls=array();
        $frmB->init("POST","","multipart/form-data");
        $frmB->addHidden("id",$id);
        $frmB->setCSSValue('formMainStyle','width:100{percent};margin-left:0;');
        $frmB->addLegend("Внесение изменений");
        $fls['title']=$frmB->addInput('text','title',$frmB->addField("Название файла:","pair"),"",array("style"=>"width:55%;"),$tools->decodeString($row['title']));
        $d=$tools->buildList("select","dir",array("datasource"=>"texts","where"=>array("partition"=>"fdirs"),"label"=>"value","value"=>"id"),array("value"=>$row['dir_id']));
        $d=($d)?$d:'<button style="display:block;width:100%;" onclick=\'Invis.core.loadPage("files","dirs");return false;\'>Добавить</button>';
        $fls['dir']=$frmB->addField("Директория для загрузки:","pair",$d);
        $fls['comment']=$frmB->addInput("textarea","comment",$frmB->addField("Примечание к файлу","single"),"",array("style"=>"width:100%;"),$row['comment']);
        $frmB->addSubmit("action_edit","Сохранить");
        print $frmB->render(true);
    }else{
        $errors->appendJSError("Ошибка во время диалога с БД!");
    } 
}
?>