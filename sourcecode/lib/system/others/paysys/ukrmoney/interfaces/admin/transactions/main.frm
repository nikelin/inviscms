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
$ukrmoney=new ukrmoney();
$errors=new Errors();
$acc=$GLOBALS['params']['params'][4];
if(!is_numeric($acc) || $acc<=0)
{
	$errors->appendJSError("Ошибка во время проверки параметров!");
	$errors->redirect("/admin/payment/sys/ukrmoney/balance");
}else{
	$ain=$this->getAuthInfo("ukrmoney");
	if($ain){
		if(!$ukrmoney->auth($ain['login'],$ain['passwd']))
		{
			$errors->appendJSError("Ошибка во время авторизации в системе!");
			$errors->redirect("/admin/payment/ukrmoney/settings");
		}
	}else{
		$errors->appendJSError("Ошибка во время чтения авторизационной информации!");
	}
	print $errors->outputData();
	$transactions=$ukrmoney->transactions_list($acc);
	print_r($transactions);
}
print $errors->outputData();
?>