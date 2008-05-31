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
	<h2 class='title'>Системы оплаты услуг</h2>
	<div class='header'>
		<div class='row'>
			<div class='col center' style='width:100%;clear:both;'>
				На данный момент в системе поддерживаются следующие типы
				систем оплаты услуг:<br/>
				<?php
				$data=$paymentcontroller->getActiveSystems();
				#die_r($data);
				for($i=0;$i<count($data);$i++)
				{
				?>
					<button style='width:25%;' onclick='Invis.core.loadPage("payment","sys/<?=$data[$i]['id'];?>");return false'>
						<strong><?=$data[$i]['title'];?></strong>
					</button>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
