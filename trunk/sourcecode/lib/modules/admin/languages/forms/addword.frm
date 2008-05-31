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
$errors=new Errors();
if($database->getNumrows("dicts")!=0)
{
    $frm=new forms();
    $frm->init("POST","");
    $frm->addLegend("Добавление нового слова");
    $frm->addField("Выберите словарь:","pair",$tools->buildList("select","dict",array("datasource"=>"dicts","label"=>"name","value"=>"id")));
    $frm->addInput("text","name",$frm->addField("Идентификатор слова:","pair"),"",array('style'=>'width:55%;'));
    $frm->addInput("text","value",$frm->addField("Текст слова:","pair"),"",array('style'=>'width:55%;'));
    $frm->addSubmit('action_addword',"Добавить");
    print $frm->render(true);
}else{
    $errors->redirect("/admin/languages/main");
}
print $errors->outputData();
?>