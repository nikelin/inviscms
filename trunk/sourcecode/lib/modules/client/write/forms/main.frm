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
?><form action='' method='post'>
	<div class='uform' style='width:100%;margin-left:0;font-size:17px;'>
		<div class='legend'>Новое сообщение</div>
		<blockquote style='margin:0;'>
			<div class='row' style='height:30px;'>
				<div class='col' style='text-align:left;width:35%;float:left;'>Ваше имя и фамилия:</div>
				<div class='value' style='width:60%;float:left;'>
					<input type='text' style='width:100%;' name='sender'/>
				</div>
			</div>
			<div class='row' style='height:30px;'>
				<div class='col' style='text-align:left;width:35%;float:left;'>Тема письма:</div>
				<div class='value' style='width:60%;float:left;'>
					<input type='text' style='width:100%;' name='subject'/>
				</div>
			</div>
			<div class='row' style='height:30px;'>
				<div class='col' style='text-align:left;width:35%;float:left;'>Обратный адрес:</div>
				<div class='value' style='width:60%;float:left;'>
					<input type='text' style='width:100%;' name='reply_to'/>
				</div>
			</div>
			<div class='row' style='background-color:#FFFFEF;'>
				<h3 style='margin-top:10px;margin-bottom:10px;padding:0;'>Текст письма</h3>
			</div>
			<div class='row' style='background-color:#FFFFEF;text-align:center;'>
				<textarea name='text' style='width:95%;height:60px;'></textarea>
			</div>
			<div class='row' style='height:30px;'>
				<div class='col' style='text-align:left;width:35%;float:left;'><strong>Обратный адрес:</strong></div>
				<div class='value' style='width:60%;float:left;'>
					<input type='text' style='width:100%;' name='reply_to'/>
				</div>
			</div>
		</blockquote>
		<div class='submit'>
			<input type='submit' name='action_main' value='Отправить'/>
		</div>
	</div>
</form>