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
		  <span class='header center'><h2>База клиентов системы</h2></span>
		  <div class='body'>
				 <div class='header'>
						<span class='col' style='width:10%;'>#</span>
						<span class='col' style='width:25%;'>Клиент</span>
						<span class='col' style='width:25%;'>E-mail</span>
						<span class='col' style='width:20%;'>Дата регистрации</span>
						<span class='col' style='width:10%;'>Сектор</span>
						<span class='col' style='width:10%;'>Действия</span>
				 </div>
				 <?php
				 $q=$database->getRows("clients","*");
				 if($database->isError()){
				 	$errorsB->appendJSError("Ошибка во время диалога с БД !");
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
								<span class='col'>
										<input type='checkbox' name='ids[]' value='<?=$row['id'];?>'/>
								</span>
								<span class='col' style='color:#000000;font-weight:bold;background-color:#<?=(($row['status']!='on')?"FF0000":"55EE00");?>'><?=$tools->decodeString($row['fio']);?></span>
								<span class='col'>
									<a href='javascript:Invis.core.loadPage("write","main/<?=$tools->decodeString($row['email']);?>");return false;'>
										<?=$tools->decodeString($row['email']);?></span>
									</a>
								</span>
								<span class='col'><?=$tools->decodeString($row['date']);?></span>
								<span class='col'><?=$tools->decodeString($row['type']);?></span>
								<span class='col'>
										<button style='width:100px;height:20px;font-size:10px;' onclick='core.loadPage("clients","info/<?=$row['id'];?>");return false;'>INFO</button>
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
				 <div class='row'>
				      <div class='col' style='width:100%;background-color:#000000;'>
							  <button onclick="Invis.core.loadPage('banners','clientsAdd');return false;">Добавить клиента</button>
						</div>
				 </div>
				 <input type='hidden' name='action_main'/>
				 <?=$uinterface->buildActionsTab('templates',array('delete'=>'Удалить','deny'=>'Блокировать','restore'=>'Разблокировать'));?>
		  </div>
	</div>
</form>
<?php
print $errorsB->outputData();
?>
