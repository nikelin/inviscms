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
if(!isset($GLOBALS['params']['params'][0]))
{
	if($basket->itemsCount()!=0)
	{
		if(!$security->authorized("client"))
		{
		?>
			<h2 class='title'>Приоретали ли вы наши товары ранее?</h2>
			<button style='margin-bottom:60px;width:450px;height:45px;padding-top:10px;font-weight:bold;' onclick='window.location.href="/form/auth_form";return false;'>Да</button>
			<button style='width:450px;height:45px;padding-top:10px;font-weight:bold;' onclick='window.location.href="/order/registration";return false;'>Нет, я здесь впервые</button>
			<?php
		}else
		{
			@include $GLOBALS['path_to_site'].'/lib/modules/client/order/forms/proceed.frm';
		}
	}else{
		$errors->appendJSError("Вы ещё не добавли ни одиного товара в корзину заказов!");
		$errors->redirect("/");
	}
	print $errors->outputData();
}else{
	@include $GLOBALS['path_to_site'].'/lib/modules/client/order/forms/'.addslashes($GLOBALS['params']['params'][0]).'.frm';
}
?>