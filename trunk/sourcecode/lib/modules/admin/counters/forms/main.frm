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
<form action='' method='post' id='main'>
	<div class='dT'>
		<h2 class='title'>Счётчики посещений сайта</h2>
		<div class='header'>
			<div class='row'>
				<div class='col' style='width:40%;'>>Название</div>
				<div class='col' style='width:30%;'>>Вид</div>
				<div class='col' style='width:10%;'>Статус</div>
				<div class='col' style='width:20%;'>&nbsp;</div>
			</div>
		</div>
		<div class='body'>
			<?php
			$q=$database->getRows("counters","*",array("status"=>"on"));
			if(!$database->isError())
			{
			?>
				<div class='col' style='width:40%;'><?=$row['title'];?></div>
				<div class='col' style='width:20%;'><?=$row['html'];?></div>
				<div class='col' style='width:10%;'><?=$row['status'];?></div>
				<div class='col' style='width:10%;' style='text-align:center;'>
					<button style='width:30px;' onclick='Invis.core.loadPage("counters","delete/<?=$row['id'];?>")'>X</button>
					<button style='width:30px;' onclick='Invis.core.loadPage("counters","edit/<?=$row['id'];?>")'>E</button>
					<button style='width:30px;' onclick='Invis.core.loadPage("counters","deny/<?=$row['id'];?>")'>D</button>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</form>
<?php
print $errorsB->outputData();
?>
