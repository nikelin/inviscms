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
?><div class='dT' style='width:100%;margin-left:0;'>
	<h2 class='title'>Быстроение реагирование</h2>
	<div class='header'>
		<div class='row' style='margin:0;padding:0;'>
			<div class='col' style='width:5%;'>#</div>
			<div class='col' style='width:15%;'>Поставщик</div>
			<div class='col' style='width:15%;'>Тип обновлени</div>
			<div class='col' style='width:15%;'>Размер</div>
			<div class='col' style='width:10%;'>Подпись</div>
			<div class='col' style='width:20%;'>Дата публикации</div>
			<div class='col' style='width:10%'>Действия</div>
		</div>
	</div>
	<div class='body'>
		<div class='row'>
			<div class='col' style='width:10%;'>412223</div>
			<div class='col' style='width:20%;'>InnoWeb Studio</div>
			<div class='col' style='width:25%;'>FIXED bugs #661,#675,#451</div>
			<div class='col' style='width:20%;'><?=date("d.m.Y H:i:s");?></div>
			<div class='col' style='width:20%;'>
				<button style='width:50px;' onclick='Invis.core.loadPage("patch","info/repo/412223");return false;'>INFO</button>
				<button style='width:50px;' onclick='Invis.core.loadPage("patch","install/repo/412223");return false;'>SETUP</button>
			</div>
		</div>
	</div>
</div>
