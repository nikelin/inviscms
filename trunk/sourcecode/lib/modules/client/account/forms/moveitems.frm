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
$errors=new Errors();
if($database->getNumrows("SELECT COUNT(*) FROM `#prefix#_basket` WHERE client='".$_SERVER['REMOTE_ADDR']."'")!=0)
{
	if($basket->moveItems($_SERVER['REMOTE_ADDR'],$clients->getUID()))
	{
		$errors->appendJSError("Состав заказа успешно восстановлен !");
		$errors->redirect("/account");
	}else
	{
		$errors->appendJSError("Ошибка во время восстановления элементов корзины!");
		$errors->redirect("/server_.html");
	}
}else
{
	$errors->appendJSError("К сожалению мы не может найти товары, заказанные ранее по вашему IP...");
	$errors->redirect('/account');
}
print $errors->outputData();
?>