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
$data=$tools->getEnvVars("POST",true);
$errors=new Errors();
if(!$tools->checkValues($data,array("email","passwd","retype","country","name","phone","address","paysys")))
{
		$errors->appendJSError("Ошибка во время проверки данных формы!");
}else
{
	if($data['retype']!=$data['passwd'])
	{
		$errors->appendJSError("Пароль и повторение не совпадают!");
	}else{
		if(!$tools->isEmail($data['email']))
		{
			$errors->appendJSError("Неверный формат электронного адреса!");	
		}else
		{
			if(!$tools->isPhone($data['phone']))
			{
				$errors->appendJSError("Неверный формат телефонного номера!");	
			}else
			{
				if($database->checkRowExists("clients",array("email"=>$email)))
				{
					$errors->appendJSError("Вы уже зарегистрированы в магазине!");
					$errors->redirect("/order/proceed");
				}else
				{
					$profile=$clients->createProfile($data);
					if(!$profile)
					{
						$errors->appendJSError("Внутренняя ошибка системы!");
						$errors->redirect("/server_.html");
					}else
					{
						if($clients->createAccount($data['email'],$data['passwd'],$profile,"customer"))
						{
							if($security->proceedClientAuthorize($data['email'],$data['passwd']))
							{
								$errors->appendJSError("Спасибо! Ваш профиль успешно создан!");
								if($basket->moveItems($_SERVER['REMOTE_ADDR'],$clients->getUID()))
								{
									$errors->appendJSError("Заказанные ранее товары успешно переведены под ваш текущий аккаунт !");
								}else
								{
									$errors->appendJSError("Ошибка во время перевода ранее заказанных товаров !..");
								}
								$attempts->send("Новый клиент","На сайте зарегистрировался новый клиент с e-mail `".$data['email']."`.");
								$message="Спасибо, за регистрацию на сайте модной одежды ФутболкаPrint&copy; !\n\т";
								$message.="С этого момента вам в полном объёме доступны функции нашего сайта, а так же\n";
								$message.="раздел сайта `Личный Кабинет` в котором вам доступен широкий набор функции\n";
								$message.="для настройки, управления и получения свежей информации о линейках нашей продукции.\n";
								$message.="\nДля доступа к `Личному Кабинету`, вам необходимо перейти по адресу: http://futbolkaprint.com.ua/account\n";
								$message.="\nИнформация для авторизации:\n\n";
								$message.="Логин: ".$data['email']."\n";
								$message.="Пароль: ".$data['passwd']."\n";
								$message.='---------------------\n';
								$message.="С уважением, служба поддержки клиентнов магазина ФутболкаPrint&copy;\n";
								die_r($message);
								$errors->redirect("/account");
							}else{
								$errors->appendJSError("Ошибка во время инициализации пользовательской сессии!");
								$errors->redirect("/server_.html");
							}
						}else{
							$errors->appendJSError("Внутренняя ошибка системы!");
							$errors->redirect("/server_.html");
						}						

					}
					
				}
			}
		}	
	}
}
print $errors->outputData();
?>