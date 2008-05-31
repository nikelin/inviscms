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
$data=$tools->getEnvVars('POST');
$errorB=new Errors();
#die_R($data);
if(!$tools->checkValues($data,array('title',"param1","param2","param3","param4","param5","param6","description")))
{
	$errorB->appendJSError("Ошибка во время проверки переданных данных !");
	$errorB->redirect('/admin/store/add');
}else{
	$tmpl=$jsonencoder->encode(array('template'=>$data['parm5'],'label'=>$data['parm6'],'x'=>$data['parm1'],'y'=>$data['parm2'],'width'=>$data['parm3'],'height'=>$data['parm4']));
	if($database->checkRowExists("catalog",array('title'=>$data['title'])))
	{
		$errorB->appendJSError("Товар с таким названием уже существует !");
		$errorB->redirect("/admin/store/add");
	}else
	{
		$tid=$database->insertRow("catalog",array("",$data['cat'],$data['parm5'],$data['parm6'],$data['title'],$data['description'],$data['tags'],$data['price'],str_replace('%','',$data['discount']),
							  stripslashes($jsonencoder->encode(array('x'=>$data['parm1'],'y'=>$data['parm2'],'width'=>$data['parm3'],'height'=>$data['parm4']))),1,'on'));
		if($database->isError())
		{
			die_r($database->sqlErrorString());
			$errorB->appendJSError("Ошибка во время диалога с БД !");
			$errorB->redirect("/server_.html");
		}else{
			#die_r($database->lastQuery());
			$errorB->appendJSError("Товар успешно добавлен под №".$tid."!");
			$errorB->redirect('/admin/store');
		}
	}
}
$errorB->redirect("/admin/store");
print $errorB->outputData();
?>
