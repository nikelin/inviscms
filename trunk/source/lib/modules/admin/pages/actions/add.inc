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
?><?
	                 /**
	                  * Исходный код официального сайта организации "НСПУ"
	                  * Все права на данный код защищены согласно закона об авторском праве Украины,
	                  * и несанкционированное использование данного файла или части исходного кода
	                  * программы преследуются по закону.
	                  *
	                  * Автор комплекса: Карпенко Кирилл
	                  * Служба техподдержки: LoRd1990@gmail.com
	                  * Все права принадлежат компании ИНПП "ТНТ-43"
	                  */
	                 ?><?php
$data=$tools->getEnvVars("POST");
$errorsB=new Errors();
if(!$tools->checkValues($data,array("title","lang","text"))){
	$errorsB->appendJSError("Ошибка во время проверки введённых данных !");
}else{
	$ufu=(in_array("ufu",$data) && trim($data['ufu'])!='')?$data['ufu']:$tools->translit($data['title']);
	$type=(isset($data['type']) && trim($data['type'])!='')?$data['type']:'text';
			if($database->checkRowExists("pages",array("title"=>$data['title'])) && !$database->isError()){
				 $errorsB->appendJSError("Страница с таким заголовком уже существует !");
			}else{
						if(!$database->insertRow("pages",array(
																"",
																$data['title'],
																$data['keywords'],
																$data['text'],
																$data['description'],
																0,
																0,
																0,
																$data['lang'],
																'admin',
																time(),
																0,
																$ufu,
																$data['slug'],
																$type,
																'on'
																))){
						$errorsB->appendJSError("Ошибка во время диалога с БД !");
					 }else{
								 $errorsB->appendJSError("Страница с заголовком `".$data['title']."` успешно добавлена в БД!");
					 }
		 }
}
$errorsB->redirect("/admin/pages");
print $errorsB->outputData();
?>