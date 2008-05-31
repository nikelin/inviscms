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
?><form action='' id='main' method='post'>
		<div class='dT' style='width:40%;margin-bottom:30px;margin-left:31%;display:block;clear:both;'>
		     <div class='header' style='padding-bottom:2px;'>
		          <div class='row'>
					  <div class='col' style='width:44%;height:17px;'>Удалить</div>
			          <div class='col' style='width:53%;height:17px;'>Идентификатор</div>
 					 </div>
			  </div>
			  <div class='body'>
					 <?php
					 	$errorsB=new Errors();
					      $q=$database->getRows("texts","*",array("partition"=>"fdirs"));
					      if($database->isError()){
			 						 $errorsB->appendJSError("Ошибка во время диалога с БД !");
							}else{
									if($database->getNumrows($q)!=0){
									  while($row=$database->fetchQuery($q)){
										 ?>
										      <div class='row'>
										           <div class='col' style='width:44%;height:20px;'>
													  		 <input type='checkbox' name='ids[]' value='<?=$row['id'];?>'/>
															 <input type='hidden' name='ids_d[]' value='<?=$row['id'];?>'/>
														  </div>
										           <div class='col' style='width:53%;height:20px;'><input style='width:100%;' type='text' name='names[]' value='<?=$tools->decodeString($row['value']);?>'/></div>
												</div>
										 <?php
									  }
									}else{
											?>
											<div class='row'>
											     <div class='col' style='width:100%;clear:both;'>
														 Создайте хотя бы одну директорию
												  </div>
											</div>
											<?
									}
							}
					 ?>
					 <div class='row'>
												     <div class='col center' style='width:100%;'>
															 <button style='font-size:11px;width:100px;height:17px;' name='action' value='save_changes'>Сохранить</button>
													  </div>
												</div>
			  </div>
		</div>
		<input type='hidden' name='action_dirs'/>
</form>
<?php
print $errorsB->outputData();
?>
<form action='' method='post'>
	<div class='form' style='width:90%;margin-top:30px;margin-bottom:20px;margin-left:40px;display:block;clear:both;'>
     <div class='legend'>Добавление директории в базу</div>
	  <div class='row'>
					 <span class='label label1'>Введите название директории:</span>
					 <span class='value'>
					 			 <input type='text' name='title' value=''/>
					 </span>
			</div>
	    <div class='row'>
	        <div class='submit'>
					 <input type='hidden' name='action' value='create'/>
							<input type='submit' name='action_dirs' value='Создать директорию'/>
					</div>
	    </div>
	</div>
</form>
