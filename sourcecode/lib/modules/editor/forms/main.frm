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
$dir=isset($GLOBALS['params']['params'][0])?$GLOBALS['params']['params'][0]:'/';
?>
<div class='dT'>
	<h2 class='title'>Файловая система</h2>
	<div class='header'>
		<div class='row'>
			<div class='col'>Имя объекта</div>
			<div class='col'>Тип</div>
			<div class='col'>Доступ</div>
			<div class='col'>Действия</div>
		</div>
	</div>
	<div class='body'>
		<?php
		$data=$dirs->fsListing($dir);
		for($i=0;$i<count($data);$i++)
		{
			?>
			<div class='row'>
				<div class='col'>
					<input type='checkbox' name='els[]'/>
				</div>
				<div class='col'><?=$data[$i]['name'];?></div>
				<div class='col'><?=$data[$i]['type'];?></div>
				<div class='col'><?=$data[$i]['access'];?></div>
				<div class='col'>
					<button name='action_main' value='delete' onclick='Invis.core.loadPage("fs","delete/<?=base64_encode($data[$i]['name']);?>");return false;'>X</button>
					<?php
					if($dirs->isEditable($data[$i]['name']))
					{
					?>
						<button name='action_main' value='edit' onclick='Invis.core.loadPage("fs","delete");return false;'>E</button>
					
					<?php
					}
					?>
				</div>
			</div>
			<?
		}
		?>
		<div class='row'>
			Выделенные элементы: <button>Удалить</button>
		</div>
	</div>
