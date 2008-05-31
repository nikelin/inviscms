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
?><?
$q=$database->proceedQuery("SELECT * FROM `#prefix#_basket` WHERE client='".$clients->getUID()."'");
if(!$database->isError())
{
	if($database->getNumrows($q)!=0)
	{
		$products=array();
		$summ=0;
		while($row=$database->fetchQuery($q))
		{
			$products[]=array("product"=>$row['pid'],"count"=>$row['count'],"p1"=>$row['param1'],"p2"=>$row['param2'],"p3"=>$row['param3']);
		}
		if($database->insertRow("orders",array("",$clients->getUID(),0,time(),serialize($products),"store","active")))
		{
			$message="Поступил новый заказ от одного из клиентов магазина.\n";
			$message.="Чтобы ознакомиться с ним, перейдите по следующей ссылке:\n";
			$message.="http://futbolkaprint.com.ua/admin/orders";
			if(@mail($database->getSQLParameter("settings","email"),"Поступил новый заказ!",$message,"From: robot@futbolkaprint.com.ua"))
			{
				if($basket->clear_basket())
				{
					$errors->appendJSError("Спасибо, ваш заказ успешно отправлен !");
					$errors->appendJSError("Мы свяжемся с вами через некоторое время.");
					$errors->redirect("/");
				}else
				{
					$errors->appendJSError("Ошибка во время диалога с БД!");
					$errors->redirect('/');
				}
			}else
			{
				$errors->appendJSError("Ошибка во время отправки заказа !");
				$errors->redirect("/server_.html");
			}
		}else
		{
			$errors->appendJSError("Ошибка во время диалога с БД!");
			$errors->redirect("/server_.html");
		}
	}else
	{
		$errors->appendJSError("Ваш заказ пуст. Прежде чем отправлять заказ, закажите что-нибудь !");
		$errors->redirect("/");
	}	
}else
{
	$errors->appendJSError("Ошибка во время диалога с БД!");
	$errors->redirect('/server_.html');
}
print $errors->outputData();
?>