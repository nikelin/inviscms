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
	<div class='form' style='margin-top:30px;margin-left:60px;'>
		  <div class='legend'>Добавление категории</div>
		  <div class='row'>
		       <div class='label label1'>Название категории</div>
		       <div class='value'>
		            <input type='text' name='title'/>
				 </div>
		  </div>
		  <div class='row'>
		       <div class='label submit'>
		            <input type='hidden' name='add'/>
		            <button name='action_cats'>Добавить</button>
				 </div>
		  </div>
	</div>
	<div class='dT' style='width:60%;margin-left:20%;margin-top:3%;'>
		  <div class='header center'>
		         <span class='row'>Категории шаблонов</span>
		  </div>
		  <div class='body'>
				 <div class='row'>
						<span class='col' style='width:9%;margin:0px 1px 0px 0px;padding:3px 0px 0px 0px;'>
								<input type='checkbox' name='ids[]'/>
						</span>
						<span class='col' style='width:91%;font-size:15px;font-weight:bold;margin:0;padding:0;'>Cool:)</span>
				 </div>
				 <div class='row'>
						<span class='col' style='width:9%;margin:0px 1px 0px 0px;padding:3px 0px 0px 0px;'>
								<input type='checkbox' name='ids[]'/>
						</span>
						<span class='col' style='width:91%;font-size:15px;font-weight:bold;margin:0;padding:0;'>Cool:)</span>
				 </div>
				 <div class='row'>
						<span class='col' style='width:9%;margin:0px 1px 0px 0px;padding:3px 0px 0px 0px;'>
								<input type='checkbox' name='ids[]'/>
						</span>
						<span class='col' style='width:91%;font-size:15px;font-weight:bold;margin:0;padding:0;'>Cool:)</span>
				 </div>
		  </div>
	</div>
</form>
	<?=$uinterface->buildActionsTab('templates',array('delete'=>'Удалить','deny'=>'Блокировать','restore'=>'Разблокировать'));?>
