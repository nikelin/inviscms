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
 $id=$GLOBALS['params'][3];
 if(!$database->checkRowExists("clients",array("id"=>$id))){
	$errorsB->appendJSError("Данный клиент не существует !");
	$errorsB->redirect("/admin/clients");
 }else{
		 $q=$database->proceedQuery("SELECT * FROM `#prefix#_clients` WHERE id=".$id." LIMIT 1");
		 $row=$database->fetchQuery($q);
?>
<div class='form' style='width:95%;margin-left:20px;'>
	  <div class='legend'>Информация о клиенте</div>
	  <div class='row'>
	       <div class='label label1' style='width:65%;'>ФИО:</div>
	       <div class='value center' style='width:35%;height:20px;'>
					<?=rawurldecode($row['fio']);?>
			 </div>
	  </div>
	  <div class='row'>
	       <div class='label label1' style='width:65%;'>Дата регистрации:</div>
	       <div class='value center' style='width:35%;height:20px;'>
	            <?=date("d.m.Y",$row['date']);?>
			 </div>
	  </div>
	  <div class='row'>
	       <div class='label label1' style='width:65%;'>E-mail адрес:</div>
	       <div class='value center' style='width:35%;height:20px;'>
	            <?=rawurldecode($row['email']);?>
			 </div>
	  </div>
	  <div class='row'>
	       <div class='label label1' style='width:65%;'>URL-сайта:</div>
	       <div class='value center' style='width:35%;height:20px;'>
	            <?=$row['url'];?>
			 </div>
	  </div>
	  <div class='row'>
	       <div class='label label1' style='width:65%;'>Сектор заинтересованности:</div>
	       <div class='value center' style='width:35%;height:20px;'>
	            <?=$row['type'];?>
			 </div>
	  </div>
	  <div class='row'>
	       <div class='label label1' style='width:65%;'>Статус клиента ("VIP", "обычный", "нежелательный"):</div>
	       <div class='value center' style='width:35%;height:20px;'>
	            <?=$row['status'];?>
			 </div>
	  </div>
	  <div class='row'>
	       <div class='label label1 center' style='width:100%;background-color:#3399ff;text-align:center;'>Примечания:</div>
	  </div>
	  <div class='row' style='width:100%;'>
	            <span class='value' style='width:100%;clear:both;'><?=$row['comments'];?>&nbsp;</span>
	  </div>
	  <div class='row'>
	       <div class='label submit'>
	            <button>Связаться</button>
	            <button disable="true">К сайту</button>
</div>
		<div style='height:50px;background-color:inherit;'></div>
		<?php
		}
		?>
