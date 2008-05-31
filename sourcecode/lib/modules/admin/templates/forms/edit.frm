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
$id=$GLOBALS['params']['params'][2];
if(!is_numeric($id) || $id<=0)
{
	$errors->appendJSError("Ошибка во время проверки параметров!");
	$errors->redirect('/admin/templates/main');
}else
{
	if($database->checkRowExists("templates",array('id'=>$id)))
	{
		$q=$database->getRows("templates","*",array("id"=>$id));
		$data=$database->fetchQuery($q);
		$frm->init("POST","");
		$frm->addHidden("id",$id);
		$frm->addLegend("Правка шаблона №".$id);
		$frm->setCSSValue("formMainStyle","width:100{percent};margin-left:0;");
		$frm->addInput("text","title",$frm->addField("Введите название шаблона:","pair"),"","",rawurldecode($data['title']));
		$frm->addInput("select","type",$frm->addField("Выберите тип футболки:","pair"),$data['type'],"",array('male'=>"Мужская","female"=>"Женская","child"=>"Детская"));
		$frm->addField("Поставщик продукции:","pair",$tools->buildList('select','developer',array('datasource'=>'developers','label'=>'title','value'=>'id'),array('value'=>$data['developer'])));
		$frm->addInput("text","price",$frm->addField("Цена футболки:","pair"),"","",$data['price']);
		$frm->addField("Перёд футболки:","pair",$tools->buildList("select","front",array('datasource'=>'files','value'=>'id','label'=>'title'),array('value'=>$data['front'])));
		$frm->addField("Спина:","pair",$tools->buildList("select","back",array('datasource'=>'files','value'=>'id','label'=>'title'),array('value'=>$data['back'])));
		$frm->addField("Категория:","pair",$tools->buildList("select","cat",array('datasource'=>'cats','value'=>'id','label'=>'title')));
		$frm->addSubmit("action_edit","Сохранить изменения");
		print $frm->render(true);
	}else{
		$errors->appendJSError("Данная футболка не существует!");
		$errors->redirect('/admin/templates/main');
	}
}
print $errors->outputData();
?>