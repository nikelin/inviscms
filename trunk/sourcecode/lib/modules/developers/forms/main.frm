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
?>
<form action='' method='post' id='main'>
	<div class='dT'>
		  <span class='header center'><h2>База поставщиков</h2></span>
		  <div class='body'>
				 <div class='header'>
						<span class='col' style='width:10%;'>#</span>
						<span class='col' style='width:37%;'>Компания-поставщик</span>
						<span class='col' style='width:30%;''>Страна</span>
						<span class='col' style='width:18%;'>Действия</span>
				 </div>
				 <?php
				 $q=$database->proceedQuery("SELECT *,(SELECT value FROM `#prefix#_countries` WHERE id=country) AS cnt FROM `#prefix#_developers`");
				 if($database->isError()){
				 	$errorsB->appendJSError("Ошибка во время диалога с БД !");
				 	$errorsB->redirect("/server_.html");
					?>
					<div class='row'>
					     <span class='col' style='width:100%;'>
								  Ошибка во время диалога с БД!
						  </span>
					</div>
					<?
				 }else{
				 	if($database->getNumrows($q)!=0){
				 		while($row=$database->fetchQuery($q)){
				 	 ?>
						 <div class='row'>
								<span class='col' style='width:10%;'>
										<input type='checkbox' name='ids[]' value='<?=$row['id'];?>'/>
								</span>
								<span class='col' style='width:37%;color:#000000;font-weight:bold;background-color:#<?=(($row['status']!='on')?"FF0000":"55EE00");?>'><?=$tools->decodeString($row['title']);?></span>
								<span class='col' style='width:30%;'><?=$tools->decodeString($row['cnt']);?></span>
								<span class='col' style='width:18%;'>
										<button style='width:100px;height:20px;font-size:10px;' onclick='Invis.core.loadPage("developers","edit/<?=$row['id'];?>");return false;'>INFO</button>
								</span>
						 </div>
				 		 <?php
				 		}
				 	}else{
					?>
					<div class='row'>
					     <span class='col' style='width:100%;'>
								  Информация не найдена.
						  </span>
					</div>
					<?php
				 	}
				 }
				 ?>
				 <input type='hidden' name='action_main'/>
				 <?=$uinterface->buildActionsTab('templates',array('delete'=>'Удалить','deny'=>'Блокировать','restore'=>'Разблокировать'));?>
		  </div>
	</div>
</form>
<?php
print $errorsB->outputData();
?>
