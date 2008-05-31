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
	<input type='hidden' name='action' value='register'/>
	<div class='uform' style='width:100%;font-size:17px;'>
		<div class='legend'>Регистрация клиента</div>
		<div class='row'>
			<blockquote style='font-size:18px;'>
				После первого заказа вы автоматически заноситесь в нашу базу,
				что означает активацию дисконтной системы, которая позволяет 
				не только быть стильным с футболками от <strong><span style='color:#FF0000;'>Ф</span>утболка<span style='color:#00AA00;'>P</span>rint</strong>, но и 
				в значительной степени экономить (от <strong>5%</strong> до <strong>25%</strong>) !
			</blockquote>
			<button onclick='window.location.href="/vip";return false;' style='background-color:#EEEEEE;width:100%;text-align:center;font-weight:bold;'>
				Подробнее
			</button>
		</div>
		<div class='row' style='text-align:left;width:100%;'>
			<h2 onclick='Invis.tools.changeElVis("authinfo","switch");return false;' title='Основная информация, включающая адрес доставки и другое'>
				<span style='display:block;cursor:pointer;'>
					+ Авторизационные данные
				</span>
			</h2>
		</div>
		<div class='row' id='authinfo' style='display:none;'>
			<blockquote>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Ваш e-mail:</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='text' name='email'/>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Пароль для доступа:</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='password' name='passwd'/>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Повторите, пожалуйста, ваш пароль:</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='password' name='retype'/>
					</div>
				</div>
			</blockquote>
		</div>
		<div class='row' style='text-align:left;width:100%;'>
			<h2 onclick='Invis.tools.changeElVis("maininfo","switch");return false;' title='Основная информация, включающая адрес доставки и другое'><span style='display:block;cursor:pointer;'>+ Общая информация</span></h2>
		</div>
		<div class='row' id='maininfo' style='display:none;'>
			<blockquote>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Предпочитаемое обращение:</div>
					<div class='value' style='width:50%;float:left;'>
						<select name='title' style='width:100%;'>
							<option value='0x1'>Господин</option>
							<option value='0x2'>Госпожа</option>
							<option value='0x3'>Уважаемый</option>
							<option value='0x4'>Уважаемая</option>
							<option value='0x5'>Товарищ</option>
						</select>
					</div>
				</div>
				<div class='row' style='height:30px'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Страна проживания:</div>
					<div class='value' style='width:50%;float:left;'>
						<?=$tools->buildList("select","country",array("datasource"=>"countries","label"=>"value","value"=>"id"));?>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Ваше имя и фамилия:</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='text' style='width:100%;' name='name'/>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Контактный мобильный или городской номер (Украина):</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='text' style='width:100%;' name='phone'/>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Адрес доставки:</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='text' style='width:100%;' name='address'/>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Способ доставки:</div>
					<div class='value' style='width:50%;float:left;'>
						<select name='delivery' style='width:100%;'>
							<option value='0x1'>Курьером (Киев)</option>
							<option value='0x2'>Наложеным платежом</option>
							<option value='0x3'>Получение товара в нашем офисе</option>
							<option value='0x4'>Отправка в страны СНГ</option>
							<option value='0x5'>Отправка в страны Европы и дальнего зарубежья</option>
						</select>
					</div>
				</div>
			</blockquote>
		</div>
		<div class='row' style='width:100%;text-align:left;'>
			<h2 onclick='Invis.tools.changeElVis("otherinfo","switch");return false;' title='Необязательные дополнительные данные для наших менеджеров'><span style='display:block;cursor:pointer;' >+ Дополнительная информация</span></h2>
		</div>
		<div class='row' id='otherinfo' style='display:none;'>
			<blockquote>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Как вы попали на наш сайт ?</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='text' name='fromwhere' style='float:left;width:100%;'/>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='text-align:left;width:35%;float:left;'>Как вы можете оценить наш сайт ?</div>
					<div class='value' style='width:50%;float:left;'>
						<select name='rank' style='width:100%;'>
							<option value='0x1'>Мне понравилось</option>
							<option value='0x2'>Вполне подойдёт</option>
							<option value='0x3'>Можно лучше</option>
							<option value='0x4'>Немного не то, что нужно</option>
							<option value='0x5'>Совсем не понравился</option>
						</select>
					</div>
				</div>
				<div class='row' style='height:30px;'>
					<div class='col' style='width:35%;float:left;'>Вы согласны подписаться на нашу рассылку?</div>
					<div class='value' style='width:50%;float:left;'>
						<input type='checkbox' style='width:25px;height:25px;' name='subscribe' checked/>
					</div>
				</div>
			</blockquote>
		</div>
		<div class='row' style='text-align:left;width:100%;'>
			<h2 onclick='Invis.tools.changeElVis("paymentinfo","switch");return false;' title='Информация для проведения оплаты заказанных футболок'><span style='display:block;cursor:pointer;' >+ Платёжные данные</span></h2>
		</div>
		<div class='row' id='paymentinfo' style='display:none;'>
			<blockquote>
				<div class='row'>
					<strong>Каким образом вам будет удобнее оплачивать заказ?</strong>
				</div>
				<div class='row' style='text-align:left;'> 
					<span style='display:block'><input type='radio' name='paysys' value='ukrmoney'/> Система онлайн-платежей <a href='http://ukrmoney.com.ua'>UkrMoney</a></span>
					<span style='display:block'><input type='radio' name='paysys' value='rupay'/>Система онлайн-платежей <a href='http://rupay.ru'>RuPay</a></span>
					<span style='display:block'><input type='radio' name='paysys' value='cash'> Наличными</span>
					<span style='display:block'><input type='radio' name='paysys' value='banking'> Банковским переводом</span>
					<span style='display:block'><input type='radio' name='paysys' value='post'> Наложеным платежём</span>
				</div>
				<div class='row'>
					<strong>Платёжная информация (которая бы характеризовала вас как плательщика</strong>
				</div>
				<div class='row'>
					<textarea name='payinfo' style='width:100%;height:50px;'></textarea>
				</div>

			</blockquote>
		</div><input type='hidden' name='action' value='register'/>	
		<div class='row' style='margin-top:30px;'>
			<input type='submit' name='action_main' value='Продолжить' style='width:100%;background-color:#FFFFEF;color:#00AA00;font-weight:bold;cursor:pointer'/>
		</div>
	</div>
</form>