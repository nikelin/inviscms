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
?><div class='dT'>
	<h2 class='title'>Полученные сообщения</h2>
	<div class='header'>
		<div class='row'>
			<div class='col'>#</div>
			<div class='col'>Тема</div>
			<div class='col'>Отправитель</div>
			<div class='col'>Обратный адрес</div>
			<div class='col'>Дата отправки</div>
			<div class='col'>&nbsp;</div>
		</div>
	</div>
	<div class='body'>
		<?php
		$q=$database->getRows("messages","*");
		if(!$database->isError())
		{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{
					?>
					<div class='row'>
						<div class='col'><?=$row['id'];?></div>
						<div class='col'><?=$row['subject'];?></div>
						<div class='col'><?=$row['sender'];?></div>
						<div class='col'><?=$row['reply_to'];?></div>
						<div class='col'><?=date("H:i:s d.m.Y",$row['time']);?></div>
						<div class='col'>
							X V
						</div>
					</div>
					<?
				}
			}
		}
		?>
	</div>
</div>