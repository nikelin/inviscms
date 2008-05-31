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
<div class='dT'>
	<h2 class='title center'>База подписчиков</h2>
	<div class='header'>
		<div class='row' style='clear:both;width:100%;display:block;'>
			<div class='col' style='width:5%;'>#</div>
			<div class='col' style='width:25%;'>E-mail</div>
			<div class='col' style='width:25%;'>Имя подписчика</div>
			<div class='col' style='width:25%;'>Формат отправки</div>
			<div class='col' style='width:16%;'>Статус</div>
		</div>
	</div>
	<div class='body'>
		<?php
		$q=$database->getRows("subscribers","*");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{
				?>
					<div class='row'>
						<div class='col' style='width:5%;'><input type='checkbox' name='els[]' value='<?=$row['id'];?>'/></div>
						<div class='col' style='width:25%;'><?=$row['email'];?></div>
						<div class='col' style='width:25%;'><?=$row['name'];?></div>
						<div class='col' style='width:25%;'><?=$row['type'];?></div>
						<div class='col' style='width:16%;'><?=($row['status']=='on')?'Подписан':'Отписан';?></div>
					</div>
				<?php
				}
			}else{
				?>
				<div class='row'>
					<div class='col' style='width:100%;clear:both;'>
						Подписчики не найдены в базе!
					</div>
				</div>
				<?
			}
		}else{
			$errors->appendJSError("Ошибка во время диалога с БД!");
		}
		?>
		<div class='row'>
			<div class='col' style='width:100%;clear:both;'>
				<button onclick='Invis.core.loadPage("maillist","add/standart");return false;' style='width:32%;font-size:12px;'>Добавить</button>
				<button onclick='Invis.core.loadPage("maillist","add/gmail");return false;' style='width:32%;font-size:12px;'>Импортировать из GMail</button>
				<button onclick='Invis.core.loadPage("maillist","add/csv");return false;' style='width:32%;font-size:12px;'>Импортировать из CSV</button>
			</div>
		</div>
	</div>
</div>
<?php
print $errors->outputData();
?>
