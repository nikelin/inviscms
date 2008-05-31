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
		  <div class='legend'>Добавление нового клиентского аккаунта</div>
		  <div class='row'>
		       <div class='label label1' style='background-color:#FF3333;'>Имя клиента:</div>
		       <div class='value'>
		            <input type='text' name='fio'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>E-mail клиента:</div>
		       <div class='value'>
		            <input type='text' name='email'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Телефон:</div>
		       <div class='value'>
		            <input type='text' name='phone'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Страна, город:</div>
		       <div class='value'>
		            <input type='text' name='city'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label label1'>Примечания:</div>
		       <div class='value'>
		            <input type='text' name='comment'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label submit'>
						<input style='width:60%;' type='submit' name='action_add' value='Добавить'/>
				 </div>
		  </div>
	</div>
</form>
