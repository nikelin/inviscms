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
?><form action='' method='post'>
	<div class='dT'>
	     <div class='header'>
					<span class='col' style='width:5%;height:15px;'>
								<input type='checkbox' name='selAll' onclick='uiTools.selectAll("el_id");return false;'/>
					</span>
					<span class='col' style='width:23%;height:15px;'>Логин</span>
					<span class='col' style='width:20%;height:15px;'>Адрес xETR</span>
					<span class='col' style='width:20%;height:15px;'>IP</span>
					<span class='col' style='width:25%;height:15px;'>Посл. доступ</span>
				</div>
				<div class='body'>
						 <?php
						 $errorB=new Errors();
						 $q=$database->getRows("users","*");
						 if($database->isError()){
							 $errorB->appendJSError("Ошибка во время диалога с БД !");
						 }else{
									 if($database->getNumrows($q)==0){
									 ?>
									   <span class='row' style='width:100%;'>Пользователи не найдены в БД.</span>
									 <?
									 }else{
									       while($row=$database->fetchQuery($q)){
													 ?>
													   <div class='row'>
							 			 			 	   <span class='col' style='width:5%;height:15px;'>
																		 <input type='checkbox' name='ids[]' value='<?=$row['id'];?>'/>
		 		    				 				   </span>
														   <span class='col' style='width:23%;height:15px;'><?=$row['email'];?></span>
													     <span class='col' style='width:20%;height:15px;'><?=$row['extr'];?></span>
												  		 <span class='col' style='width:20%;height:15px;'><?=$row['ip'];?></span>
															 <span class='col' style='width:25%;height:15px;'><?=date("d.m.Y H:i:s",$row['laccess']);?></span>
														 </div>
													 <?
												 }
									 }
						 }
						 ?>
				</div>
		 </div>
	<input type='hidden' name='action_main'/>
	<?=$uinterface->buildActionsTab('pages',array('delete'=>'Удалить','deny'=>'Блокировать','main'=>'Сделать главной','restore'=>'Разблокировать'));?>
</form>
<?php
print $errorB->outputData();
?>
