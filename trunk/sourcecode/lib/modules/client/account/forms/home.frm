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
?><div class='uform' style='width:98%;padding:0;margin:0;margin-top:30px;margin-left:20px;background-color:#ebf8ff;'>
			<div class='legend' style='height:24px;background-color:#FFFFEF;border:1px #000000 dashed;color:#ff5a00;'>
				{^clients_account^}
			</div>
			<div class='row' style='height:40px;padding-top:15px;'>
				<div class='col'>
					<button style='font-weight:bold;' onclick='window.location.href="/basket/view";return false;'>{^basket^}</button>
					<button style='font-weight:bold;' onclick='window.location.href="/account/moveitems";return false;'>{^move_basket_items^}</button>
					<button style='font-weight:bold;' onclick='window.location.href="/account/orders";return false;'>{^orders^}</button>
					<button style='font-weight:bold;' onclick='window.location.href="/account/profile";return false;'>{^your_settings^}</button>
					<button style='font-weight:bold;' onclick='window.location.href="/account/club";return false;'>{^your_club^}</button>
					<button style='font-weight:bold;' onclick='window.location.href="/logout";return false;'>{^logout^}</button>
				</div>
			</div>
		</div>