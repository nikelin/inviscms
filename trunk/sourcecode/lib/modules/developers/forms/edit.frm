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
$fls=array();
$error=new Errors();
$params=$GLOBALS['params'];
$id=isset($params['params'][2])?$params['params'][2]:$error->appendJSError("Ошибка во время проверки параметров !");
#die_r($GLOBALS['params']);
if($id && is_numeric($id))
{
	$q=$database->proceedQuery("SELECT title, country, logo,
									(SELECT value FROM `#prefix#_countries` WHERE id=country) as country_title,
									(SELECT src FROM `#prefix#_files` WHERE id=logo) AS logo_src,
									description 
								FROM `#prefix#_developers` 
								WHERE id=".$id);
	if(!$database->isError())
	{
		if($database->getNumrows($q)!=0)
		{
			$data=$database->fetchQuery($q);
			$frm->init("POST","","","","",array("style"=>"display:block;margin-top:20px;margin-bottom:20px;"));
			$frm->addLegend("База поставщиков");
			$fls['title']=$frm->addInput("text","title",$frm->addField("Наименование поставщика:","pair"),"","",rawurldecode($data['title']));
			$fls['country']=$frm->addField("Страна поставки:","pair",$tools->buildList("select","country",array("datasource"=>"countries","label"=>"value","value"=>"id"),array("value"=>$data['country'])));
                        $logo_data=$tools->buildList("select","logo",array("datasource"=>"files","label"=>"title","value"=>"id"),array("value"=>$data['logo']));
                        $logo_data=($logo_data!=-1)?$logo_data:'<button onclick="Invis.core.loadPage(\'files\',\'upload\');return false;">Загрузить</button>';
			$fls['logo']=$frm->addField("Выберите логотип компании:","pair",$logo_data);
			$frm->addHidden("tid",$id);
			$fls['description']=$frm->addInput("textarea","description",$frm->addField("Описание:","single"),"",array("style"=>"width:100%;"),rawurldecode($data['description']));
			$frm->addSubmit("action_add","Добавить");
			print $frm->render(true);
		}else{
			$error->appendJSError("Данная запись не существует !");
		}
	}else{
		$error->appendJSError("Ошибка во время диалога с БД!");
	}
}else{
	$error->redirect("/admin/developers");
}
print $error->outputData();
?>