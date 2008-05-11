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
$errorsB=new Errors();
if(isset($_POST['id'])){
	$v=$_POST['id'];
	 if(is_numeric($v) && $v!=0){
		switch($_POST['action']){
		  case 'delete_approved':
		  	if($dirs->deleteFile("./lib/files/".$database->getSQLParameter("files","src",array("id"=>$_POST['id']))))
		  	{
		  		$errorsB->appendJSError("Файл успешно удалён. Удаляем записи БД...");
		  	}else{
		  		$errorsB->appendJSError("Ошибка во время удаления файла !");
		  	}
		  	if($database->proceedForeignKeys("files","id",$_POST['id'],array(array("templates","labels"),"fid"),"deny"))
			{
				$errorsB->appendJSError("Связи обработаны, приступаем к удалению записи о файле....");
				if($database->deleteRow("files",array('id'=>$_POST['id'])))
				{
					$errorsB->appendJSError("Файл успешно удалён!");
					$errorsB->redirect('/admin/files');
				}else{
					$errorsB->appendJSError("Ошибка во время удаления файла !");
					$errorsB->redirect('/server_.html');
				}
			}else{
				$errorsB->appendJSError("Ошибка во время обработки связей!");
				$errorsB->redirect("/server_.html");
			}
			print $errorsB->outputData();
			break;
		  case 'delete':
		  		$check=$database->proceedQuery("SELECT id AS file_id,
		  											(SELECT COUNT(id) AS d FROM `#prefix#_labels` WHERE fid=file_id) AS dld,
		  											(SELECT COUNT(id) AS f FROM `#prefix#_templates` WHERE back=file_id OR front=file_id) AS dtd,
		  											(SELECT COUNT(id) AS t FROM `#prefix#_catalog` WHERE (SELECT COUNT(id) FROM `#prefix#_labels` WHERE id=lid AND fid=file_id)>0
																										 OR (SELECT COUNT(id) FROM `#prefix#_templates` WHERE id=tid AND back=file_id OR front=file_id)>0) AS ctd
											FROM `#prefix#_files`
		  									WHERE id=".$v);
		  		if($database->getNumrows($check)!=0){
		  			$data=$database->fetchQuery($check);
		  			$z=false;
		  			if($data['dld']!=0){
		  				?>
		  				С Данным файлом связано <strong><?=$data['dld'];?></strong> картинок.<br/>
		  				<?php
		  				$z=true;
		  			}
		  			if($data['dtd']!=0)
		  			{
		  				?>
		  				C данным файлом связано <strong><?=$data['dtd'];?></strong> шаблонов.<br/>
		  				<?php
						$z=true;		  			
		  			}
					if($data['ctd']!=0){
						?>
						Так же в связке участвует <strong><?=$data['ctd'];?></strong> товарных позиций.</br>
					<?php
					}
		  			if($z){
		  				?>
		  				<div>
		  				В случае удаления файла данные элементы будут заблокированы и не будут доступны пользователям сайта.<br/>
		  				Для удаления нажимите кнопку "<strong>Удалить</strong>":<br/>
		  				</div>
		  				<?php
		  			}
		  			?>
		  				<form action='' method='post'>
		  					<input type='hidden' name='id' value='<?=$v;?>'/>
		  					<input type='hidden' name='action' value='delete_approved'/>
		  					<input type='submit' name='action_main' value='Удалить'/>
		  				</form>
		  				<input type='button' onclick='Invis.core.loadPage("files","main");' value='Вернутся'/>
		  				<?
		  				die();
		  		}else{
		  			$errorsB->appendJSError("Данный файл не существует !");
		  			$errorsB->redirect("/admin/files/main");
		  		}
		  	break;
		  default: $errorsB->appendJSError("Ошибка при проверке параметров!");$errorsB->redirect("/admin/files/main");break;
		}
		if($database->isError()){
		  $errorsB->appendJSError("Ошибка во время диалога с БД!".$database->sqlErrorString());
		  $errorsB->redirect("/server_.html");
		}
	 }
}
print $errorsB->outputData();
?>
