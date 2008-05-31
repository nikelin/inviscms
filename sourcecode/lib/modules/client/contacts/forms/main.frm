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
	<div class='uforms'>
		<div class='legend'>{^contacts_form^}</div>
		<div class='row'>
			<div class='label'>{^your_fio^}:</div>
			<div class='value'>
				<input style='width:100%;' type='text' name='fio'/>
			</div>
		</div>
		<div class='row'>
			<div class='label'>{^message_subject^}:</div>
			<div class='value'>
				<input style='width:100%;' type='text' name='subject'/>
			</div>
		</div>
		<div class='row'>
			<div class='label'>{^replay_to^}:</div>
			<div class='value'>
				<input style='width:100%;' type='text' name='reply_to'/>
			</div>
		</div>
		<div class='row'>
			<blockquote>
				<textarea name='text' style='width:100%;height:50px;'></textarea>
			</blockquote>
		</div>
		<div class='submit'>
			<input type='submit' name='action_main' value='{^send^}'/>
		</div>
	</div>
</form>