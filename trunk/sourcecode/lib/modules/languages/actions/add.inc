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
$error=new Errors();
$data=$tools->getEnvVars("POST");
if(!$tools->checkValues($data,array("name"))){
	$error->appendJSError("Ошибка при проверке формы !");
}else{
	if($database->checkRowExists("dicts",array("name"=>$data['name']))){
		$error->appendJSError("Данный словарь уже существует в БД!");
	}else{
		$tid=$database->insertRow("dicts",array("",$data['name'],time()));
		if($database->isError()){
			$error->appendJSError("Ошибка во время диалога с БД!");
			$error->_redirect("/server_.html");
		}else{
			$error->appendJSError("Словарь успешно сохранён под №".$tid."!");
			if($data['fsource']!='' && is_numeric($data['fsource']) && $data['fsource']!=0)
			{
				$q=$database->getRows("texts","*",array("param"=>$data['fsource'],"partition"=>'dicts'));
				if($database->isError())
				{
					$error->appendJSError("Ошибка во время диалога с БД!");
					$error->redirect("/server_.html");
				}else{
					if($database->getNumrows($q)!=0)
					{
						while($row=$database->fetchQuery($q))
						{
							$q=$database->insertRow("texts",array("",$row['value'],$row['name'],"dicts",$tid));
						}
						if($database->isError())
						{
							$errors->appendJSError("Ошибка во время диалога с БД!");
							$errors->redirect("/server_.html");
						}else{
							$error->appendJSError("Лексика словаря успешно скопирована!");
							$error->redirect("/admin/languages/edit/".$tid);
						}
					}
				}
			}else{
				$error->redirect("/admin/languages/edit/".$tid);
			}
		}
	}
}
print $error->outputData();
?>