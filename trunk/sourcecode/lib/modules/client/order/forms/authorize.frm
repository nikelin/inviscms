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
?><form id='order_form_object' action='' method='post'>
	<div class='uform' style='width:100%;font-size:17px;'>
		<div class='legend'>Вход для клиентов</div>
		<div class='row'>
			<input type='text' name='login' value='Ваш e-mail'/>
			<input type='password' name='passwd' value='Ваш пароль'/>
		</div>
		<div class='submit'>
			<input type='hidden' name='action' value='auth'/>
			<input type='submit' name='action_order' value='Далее'/>
		</div>
	</div>
</form>