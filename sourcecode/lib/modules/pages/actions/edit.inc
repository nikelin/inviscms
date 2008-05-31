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
$data=$tools->getEnvVars("POST",true);
$errorsB=new Errors();
$id=$GLOBALS['params']['params'][2];
if(!$tools->checkValues($data,array("title","lang","text"))){
	$errorsB->appendJSError("Ошибка во время проверки введённых данных !");
}else{
			if(!$database->checkRowExists("pages",array("id"=>$id)) || $database->isError()){
				 $errorsB->appendJSError("Данная страница не существует !");
			}else{
					$ufu=(trim($data['ufu'])=='')?$tools->translit($data['title']):$data['ufu'];
					if(!$database->updateRow("pages",array("title"=>$data['title'],"type"=>$data['type'],"text"=>$data['text'],"description"=>$data['description'],"lang"=>$data['lang'],"ufu"=>$ufu),array("id"=>$id))){
						$errorsB->appendJSError("Ошибка во время диалога с БД !");
			 		}else{
					 $errorsB->appendJSError("Информация успешно сохранена !");
					 }
		 }
}
print $errorsB->outputData();
?>