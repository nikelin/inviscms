<?
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
if(!$tools->checkValues($data,array("title","link","id"))){
	$errorsB->appendJSError("Ошибка во время проверки введённых данных !");
}else{
			if(!$database->checkRowExists("menu",array("id"=>$data['id']))){
				 $errorsB->appendJSError("Данная страница не существует !");
			}else{
					if(!$database->updateRow("menu",array("title"=>$data['title'],"link"=>$data['link'],"target"=>$data['target'],"place"=>$data['place'],'alt'=>$data['alt']),array("id"=>$data['id']))){
						$errorsB->appendJSError("Ошибка во время диалога с БД !");
						$errorsB->redirect("server_.html");
			 		}else{
					 $errorsB->appendJSError("Информация успешно сохранена !");
					 }
		 }
}
$errorsB->redirect("/admin/menu");
print $errorsB->outputData();
?>
