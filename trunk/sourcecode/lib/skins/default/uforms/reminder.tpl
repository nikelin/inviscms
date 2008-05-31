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
$part=(isset($GLOBALS['params']['params'][1]))?$GLOBALS['params']['params'][1]:'main';
switch($part)
{
	case 'main':
		?>
		<div class='uform' style='width:100%;padding:0;margin:0;margin-top:30px;margin-left:20px;'>
			<div class='row' style='background-color:#FFFFFF;font-size:17px;margin-bottom:10px;'>
				Если вы забыли сразу всю информацию о вашем клиентском аккаунте,
				и восстановить пароль стандартными методами вы не можете, звоните
				к нам, или пишите на e-mail.<br/>
				Мы обязательно восстановим доступ к аккаунту для их владельцев.
			</div>
			<div style='background-color:#ebf8ff;'>
				<div class='legend' style='height:24px;background-color:#FFFFEF;border:1px #000000 dashed;color:#ff5a00;'>
					{^reminder_title^}
				</div>
				<div class='row'>
					<button onclick='window.location.href="/form/reminder/email";return false;'>{^forgot_password^}</button>
					<button onclick='window.location.href="/form/reminder/personal";return false;'>{^forgot_p_e^}</button>
					<button onclick='window.location.href="/form/reminder/nothing";return false;'>{^forgot_all^}</button>
				</div>
			</div>
		</div>
		<?php
		break;
	case 'email':
		?>
		<form id='order_form_object' action='/proceed/reminder/email' method='post'>
			<div class='uform' style='width:100%;padding:0;margin:0;margin-top:30px;margin-left:20px;'>
				<div style='background-color:#ebf8ff;'>
					<div class='legend' style='height:24px;background-color:#FFFFEF;border:1px #000000 dashed;color:#ff5a00;'>
						{^account_restore^}
					</div>
					<div class='row' style='text-align:center;margin:20px 0 20px 0'>
						<div class='col'>{^your_email^}</div>
						<div class='col'>
							<input type='text' style='width:100%;' name='email'/>
						</div>
					</div>
					<div style='clear:both;width:100%;text-align:center;'>
						<input type='hidden' name='action' value='reminder'/>
						<input type='submit' name='action_reminder' value='{^continue^}' style='font-weight:bold;font-size:17px;width:100%;background-image:url(/images/sys/menusep.gif);color:#FFFFFF;'/>
					</div>
				</div>
			</div>
		</form>
		<?
		break;
	case 'personal':
		?>
		<form action='/proceed/reminder/personal' style='margin-left:5px;' method='post'>
			<div class='row' id='maininfo'>
				<h2 class='title'>Сложное восстановление пароля:</h2>
				<input type='hidden' name='action' value='reminder'/>
				<blockquote style='background-color:#FFFFFF;color:#000000;font-size:12px;width:90%;font-weight:bold;'>
					<div class='row' style='height:30px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span title='Фамилия, имя и отчество, указанные во время регистрации'>
								{^your_fio^}:
							</span>
						</div>
						<div class='value' style='width:50%;float:left;'>
							<input type='text' name='fio' style='width:100%;'/>
						</div>
					</div>
					<div class='row' style='height:30px;margin-top:10px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span title='Указанный при регистрации номер телефона'>
								{^contact_phone^}:
							</span>	
						</div>
						<div class='value' style='width:50%;float:left;'>
							<input type='text' name='phone' style='width:100%;'/>
						</div>
					</div>
					<div class='row' style='height:30px;margin-top:10px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span title='Когда аккаунт был зарегистрирован (год,месяц,число)'>
								{^probably_reg_date^}:
							</span>	
						</div>
						<div class='value' style='width:50%;float:left;'>
							<input type='text' name='regdate' style='width:100%;'/>
						</div>
					</div>
					<div class='row' style='height:30px;margin-top:10px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span title='Дата дня, в который вы совершили последнюю покупку'>
								{^last_bought_date^}:
							</span>
						</div>
						<div class='value' style='width:50%;float:left;'>
							<input type='text' name='lastbought' style='width:100%;'/>
						</div>
					</div>
					<div class='row' style='height:30px;margin-top:10px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span title='Приблизительное число заказов, совершённых вами с этого аккаунта'>
								{^probably_total_orders^}:
							</span>
						</div>
						<div class='value' style='width:50%;float:left;'>
							<input type='text' name='totalorders' style='width:100%;'/>
						</div>
					</div>
					<div class='row' style='height:30px;margin-top:10px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span style='width:100%;' title='Напишите, как примерно звучал ваш адрес e-mail'>
								{^probably_email^}:
							</span>
						</div>
						<div class='col' style='width:50%;float:left;'>
							<input type='text' name='email' style='width:100%;'/>
						</div>
					</div>
					<div class='row' style='height:30px;margin-top:10px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span title='Вспомните, как предположительно звучал ваш пароль'>
								{^probably_password^}:
							</span>
						</div>
						<div class='value' style='width:50%;float:left;'>
							<input type='text' name='password' style='width:100%;'/>
						</div>
					</div>
					<div class='row' style='height:30px;margin-top:10px;'>
						<div class='col' style='text-align:left;width:45%;float:left;'>
							<span title='Интернет-провайдер, услугам которого вы прибегли во время последнего посещения сайта'>
								{^your_ip^}:
							</span>
						</div>
						<div class='value' style='width:50%;float:left;'>
							<input type='text' name='inet_provider' style='width:100%;'/>
						</div>
					</div>
				</blockquote>
				<div class='row'>
					<input type='submit' name='restore' value='{^continue^}' style='font-weight:bold;font-size:17px;width:100%;background-image:url(/images/sys/menusep.gif);color:#FFFFFF;'/>
				</div>
			</div>
		</form>
		<?php
		break;
}