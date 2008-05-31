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
	<div class='dT' style='margin-bottom:40px;'>
		<span class='header center'><h2>Файловый Склад</h2></span>
		<div class='header'>
 			<div class='row'>
			      	<div class='col' style='width:6%;'>#</div>
					<div class='col' style='width:27%;'>Название файла</div>
					<div class='col' style='width:19%;'>Размер файла</div>
					<div class='col' style='width:18%;'>Директория</div>
					<div class='col' style='width:20%;'>Статус файла</div>
		     </div>
		</div>
	 	<?
			$q=$database->proceedQuery("SELECT id,title,size,status,src,(SELECT value FROM `#prefix#_texts` WHERE id=dir_id) AS dir  FROM `#prefix#_files`");
			if(!$database->isError()){
				if($database->getNumrows($q)!=0){
				?>
					<div class='body' style='height:350px;overflow:scroll;'>
						<?php
						while($row=$database->fetchQuery($q)){
						?>
						<form action='' method='post' id='main'>
		      				<div class='row'>
								<div class='col' style='width:6%;'>
									<input type='checkbox' name='sid' value='<?=$row['id'];?>'/>
								    <input type='hidden' name='id' value='<?=$row['id'];?>' />
								</div>
								<div class='col' style='width:28%;background-color:#<?=(($row['status']!='on')?"FF0000":"55EE00");?>;font-weight:bold;color:#000000;'>
									<span style='cursor:pointer;color:#3F3FAF;background-color:inherit;' onclick='Invis.tools.changeElVis("area<?=$row['id'];?>","switch");return false;'>
										<?=($tools->decodeString($row['title']==''))?'CLICK':$tools->decodeString($row['title']);?>
									</span>	
								</div>
								<div class='col' style='width:20%;'><?=$row['size']/1000;?>KB</div>
								<div class='col' style='width:19%;'><?=rawurldecode((($row['dir']=='')?'Основная':$row['dir']));?></div>
								<div class='col' style='width:20%;'><?=($row['status']=="on")?"Активен":"Заблокирован";?></div>
						  	</div>
						  	<div class='center' style='background-color:#FFFFFF;' class='row' id='area<?=$row['id'];?>'>
						  	</div>
						  	<script type='text/javascript'>
								<!--
									Invis.tools.imagePreload("area<?=$row['id'];?>","<?=($row['src'][0]=='.')?substr($row['src'],1):$row['src'];?>");
									Invis.tools.changeElVis("area<?=$row['id'];?>","off");
								-->
							</script>
							<div class='row'>
								<button onclick='Invis.core.loadPage("files","edit/<?=$row['id'];?>");return false'>Править</button>
								<input type='hidden' name='action' value='delete'/>
								<button name='action_main'>Удалить</button>
							</div>
						</form>
						<?php
						}
				}else{
				?>
					<div class='row center' style='font-weight:bold;background-color:#000000;color:#FFFFFF;'>
						Файлы не найдены в архиве !
					</div>
				<?php
				}
			}else{
				 $errorsB->appendJSError("Ошибка во время диалога с БД !");
				?>
					<div class='row'>
					    <div class='col'>
						Ошибка во время диалога с БД !
					    </div>
					</div>
			<?php
			}
			?>
	</div>
	<input type='hidden' name='action_main'/>
	<?=$uinterface->buildActionsTab('templates',array('delete'=>'Удалить'));?>
</form>
<?php
	print $errorsB->outputData();
?>
