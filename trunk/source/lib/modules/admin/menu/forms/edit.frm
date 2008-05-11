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
	                 ?>

<?php
$errorB=new Errors();
$id=$GLOBALS['params']['params'][2];
if($id>0 && is_numeric($id)){
	if($database->checkRowExists("menu",array('id'=>$id))){
		$row=$database->fetchQuery($database->getRows('menu','*',array('id'=>$id)));
		$frm=new forms();
		$fls=array();
		$frm->init("POST","");
		$frm->addLegend("Редактирование нового элемента");
		$fls['text']=$frm->addInput("text","title",$frm->addField("Текст элемента","pair"),"","",$tools->decodeString($row['title']));
		$fls['link']=$frm->addInput("text","link",$frm->addField("Ссылка на элемент","pair"),"","",$row['link']);
		$fls['place']=$frm->addInput("text","place",$frm->addField("Размещение элемента","pair"),"","",$row['place']);
		$fls['alt']=$frm->addInput("text","alt",$frm->addField("Alt-текст","pair"),"","",$tools->decodeString($row['alt']));
		$fls['target']=$frm->addInput("text","target",$frm->addField("Тип открытия","pair"),"","",$row['target']);
		$frm->addHidden("id",$id);
		$frm->addSubmit("action_edit","Сохранить");
		print $frm->render(true);
	}else{
		$errorB->appendJSError("Такая страница не существует !");
		$errorB->redirect("/admin/menu");
	}
}else{
	$errorB->appendJSError("Ошибка во время проверки параметров!");
	$errorB->redirect("/server_.html");
}
print $errorB->outputData();
?>
