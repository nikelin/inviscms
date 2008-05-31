<form action='' method='post'>
<input type="hidden" name="action_main"/>
			<div class='dT'>
			<span class='header center'><h2>Статичные странички</h2></span>
		     <div class='header'>
						<span class='col' style='width:5%;height:15px;'>
									<input type='checkbox' name='selAll' onclick='uiTools.selectAll("el_id");return false;'/>
						</span>
						<span class='col' style='width:23%;height:15px;'>Текст</span>
						<span class='col' style='width:25%;height:15px;'>Ссылка</span>
						<span class='col' style='width:22%;height:15px;'>Позиция</span>
						<span class='col' style='width:15%;height:15px;'>Размещение</span>
						<span class='col' style='width:3%;height:15px;'>Act</span>
					</div>
					 <div class='body' style='margin-bottom:26px;'>
					      <?php
								$data=$database->getRows('menu','*',1,'pos');
								while($row=$database->fetchQuery($data)){
								?>
								<div class='row'>
										 <span class='col' style='width:5%;'><input type='checkbox' name='ids[]' value='<?=$row['id'];?>'/></span>
										 <span class='col' style='width:23%;height:19px;'><?=rawurldecode($row['title']);?></span>
										 <span class='col' style='width:25%;height:19px;'>
										 			 <a href='http://<?=$_SERVER['HTTP_HOST'];?>/<?=$row['link'];?>'>
															/root/<?=$row['link'];?>
														</a>
											</span>
										 <span class='col' style='width:22%;height:19px;'><?=$row['pos'];?></span>
										 <span class='col' style='width:15%;height:19px;'><?=($row['place']=="horizontal_top")?"Верхнее меню":"Нижнее меню";?></span>
										 <span class='col' style='width:3%;height:19px;'>
                 <span onclick='Invis.core.loadPage("menu","edit/<?=$row['id'];?>");return false;' style='font-size:10px;font-weight:bold;color:#FFAAAA;cursor:pointer;'>E</span>
										 </span>
								</div>
								<?
								}
								?>
					 </div>
					 <?=$uinterface->buildActionsTab('menu',array('delete'=>'Удалить','deny'=>'Блокировать','restore'=>'Разблокировать'));?>
			</div>
</form>
