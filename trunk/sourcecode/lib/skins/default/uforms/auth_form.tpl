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
?><form id='order_form_object' action='/proceed/auth_form' method='post'>
	<div class='uform' style='width:100%;padding:0;margin:0;margin-top:30px;margin-left:20px;'>
		<div class='row' style='background-color:#FFFFFF;font-size:17px;margin-bottom:10px;'>
				После первого заказа вы автоматически заноситесь в нашу базу,
				что означает активацию дисконтной системы, которая позволяет 
				не только быть стильным с футболками от <strong><span style='color:#FF0000;'>Ф</span>утболка<span style='color:#00AA00;'>P</span>rint</strong>, но и 
				в значительной степени экономить (от <strong>5%</strong> до <strong>25%</strong>) !
			<button onclick='window.location.href="/vip";return false;' style='background-color:#EEEEEE;width:100%;text-align:center;font-weight:bold;'>
				{^buy_shirt^}
			</button>
		</div>
		<div style='background-color:#ebf8ff;'>
			<div class='legend' style='height:24px;background-color:#FFFFEF;border:1px #000000 dashed;color:#ff5a00;'>
				{^client_auth^}
			</div>
			<div class='row' style='text-align:center;margin:20px 0 20px 0'>
				<input type='text' name='email' value='{^your_email^}' style='width:40%;margin-right:20px;' onclick='this.select();'/>
				<input type='password' name='passwd' value='{^your_password^}' style='width:40%;' onclick='this.select();'/>
			</div>
			<div style='clear:both;width:100%;text-align:center;'>
				<input type='hidden' name='action' value='auth'/>
				<input type='submit' name='action_order' value='{^continue^}' style='font-weight:bold;font-size:17px;width:100%;background-image:url(/images/sys/menusep.gif);color:#FFFFFF;'/>
			</div>
		</div>
	</div>
</form>