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
$errors=new Errors();
?>
<div class='dT' style='width:100%;margin-left:20px;'>
	<h2 class='title'>Шаблоны на сайте</h2>
	<div class='header'>
		<div class='row'>
			<div class='col' style='width:10%;'>
				IMG
			</div>
			<div class='col' style='width:15%;'>
				Доступные типы
			</div>
			<div class='col' style='width:20%;'>
				Поставщик
			</div>
			<div class='col' style='width:10%;'>
				Стоимость
			</div>
			<div class='col' style='width:25%;'>
				Категория
			</div>
			<div class='col'>
				Действия
			</div>
		</div>
	</div>
	<div class='body'>
		<?php
		$q=$database->proceedQuery("SELECT title,id AS tid,price,developer,type,pub_date,status,back,front,
										(SELECT title FROM `#prefix#_developers` WHERE id=developer) AS developer_title,
										(SELECT src FROM `#prefix#_files` WHERE id=front) AS front_src,
										(SELECT src FROM `#prefix#_files` WHERE id=back) AS back_src,
										(SELECT value FROM `#prefix#_texts` WHERE partition='templates' AND id=cid) AS cat_title
									FROM `#prefix#_templates`
									ORDER BY `pub_date` ASC");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{
					#die_r($row);
				?>
					<h2 class='title'><?=$tools->decodeString($row['title']);?></h2>
					<div class='row'>
						<div class='col' style='width:10%;'>
							<button style='width:100%;' onclick='Invis.tools.changeElVis("preview<?=md5($row['tid']);?>","switch");return false;'>V</button>
						</div>
						<div class='col' style='width:15%;'>
							<?php
							switch($row['type'])
							{
								case 'male': print 'Мужская';break;
								case 'female':print 'Женская';break;
								case 'child':print  "Детская";break;
								default:print'Неведома зверушка';break;
							}
							?>
						</div>
						<div class='col' style='width:20%;'>
							<a href='/admin/developers/edit/<?=$row['developer'];?>' title='Просмотреть и отредактировать информацию о поставщике'><?=rawurldecode($row['developer_title']);?></a>
						</div>
						<div class='col' style='width:10%;'>
							<?=$row['price'];?>
						</div>
						<div class='col' style='width:25%;'>
							<?=rawurldecode($row['cat_title']);?>
						</div>
						<div class='col' style='width:15%;'>
							<button style='width:53%;' onclick="Invis.core.loadPage('templates','edit/<?=$row['tid'];?>');return false;">I</button>
							<button style='width:43%;' onclick="Invis.core.loadPage('templates','delete/<?=$row['tid'];?>');return false;">X</button>
						</div>
					</div>
					<div class='row' style='display:none;' id='preview<?=md5($row['tid']);?>'>
						<div class='col' style='width:100%;height:auto;clear:both;'>
							<img  src='<?=($row['front_src'][0]=='.')?substr($row['front_src'],1):$row['front_src'];?>' style='float:left;width:200px;height:150px;' alt='Лицевая сторона'/>
							<img  src='<?=($row['back_src'][0]=='.')?substr($row['back_src'],1):$row['back_src'];?>' style='float:right;width:200px;height:150px;' alt='Спина'/>
						</div>
					</div>
				<?
				}
			}
		}else{
			die_r($database->sqlErrorString());
			$errors->appendJSError("Ошибка во время диалога с БД!");
			$errors->redirect("/server_.html");
		}
		?>
	</div>
</div>
<?php
print $errors->outputData();
?>