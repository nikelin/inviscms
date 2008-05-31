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
	<div class='form'>
		  <div class='legend'>Конфигурация баннерной системы</div>
		  <div class='row'>
		       <div class='label label1'>Включить прямую адресацию ?</div>
		       <div class='value center' >
					 <select name='target' style='height:20px;width:80%;'>
					         <option>Да</option>
					         <option>Нет</option>
					 </select>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Тип показа баннеров:</div>
		       <div class='value'>
		            <select name='showType' style='height:20px;'>
		                    <option value='slide'>Бегущая строка</option>
		                    <option value='single'>Одиночные баннеры</option>
						</select>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Разрешить подгрузку изображение по URL?</div>
	        <div class='value center'>
	             <select name='urlLoading' style='height:20px;width:80%;'>
					         <option>Да</option>
					         <option>Нет</option>
					 </select>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label submit'>
		            <button name='action_settings'>Добавить</button>
				 </div>
		  </div>
	</div>
</form>
