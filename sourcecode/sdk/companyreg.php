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
include "../lib/core/others/init.php";
if(isset($_POST['proceed']))
{
	$data=$tools->getEnvVars("POST",true);
	if(!$tools->checkValues($data,array("company","url","infourl","email","phone_fax","person","country")))
	{
		$errors->appendJSError("Ошибка во время проверки формы!");
	}else{
		if(!$tools->isEmail($data['email']))
		{
			$errors->appendJSError("Неверный формат e-mail адреса !");
		}else{
			if(!$tools->isURL($data['url']) || !$tools->isURL($data['infourl']))
			{
				$errors->appendJSError("Неверный формат URL-адреса!");
			}else{
				$csc=new csc();
				$csc->openConnection("innoweb.org.ua");
				$csc->sendQuery("POST","/company.php","d=312&f=2");
			}
		}
	}
}
?>
<html>
	<head>
		<title>Регистрация компании-поставщика</title>
		<script type='text/javascript' src='/lib/gt/invis.js'></script>
		<script type='text/javascript' src='/lib/gt/ui.js'></script>
	</head>
	<body>
		<form action='' method='post'>
			<div class='form'>
				<div class='legend'>Регистрация поставщика</div>
				<div class='row'>
					<div class='label label1'>Название компании:</div>
					<div class='value'>
						<input type='text' name='company'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Официальный сайт компании:</div>
					<div class='value'>
						<input type='text' name='url'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Страница содержащая информацию о компании:</div>
					<div class='value'>
						<input type='text' name='infourl'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Страна:</div>
					<div class='value'>
						<input type='text' name='country'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>E-mail:</div>
					<div class='value'>
						<input type='text' name='email'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Телефон либо факс (не обязательно):</div>
					<div class='value'>
						<input type='text' name='phone_fax'/>
					</div>
				</div>
				<div class='row'>
					<div class='label label1'>Контактное лицо:</div>
					<div class='value'>
						<input type='text' name='person'/>
					</div>
				</div>
				<div class='row'>
					<div class='label submit'>
						<input type='submit' name='proceed' value='Продолжить'/>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>
		