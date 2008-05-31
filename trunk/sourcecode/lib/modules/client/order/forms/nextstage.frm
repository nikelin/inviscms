<?php
if($security->authorized("client"))
{
	$q=$database->proceedQuery("SELECT #prefix#_basket.id AS id, 
													#prefix#_catalog.price AS cost, 
													SUM(#prefix#_catalog.price*#prefix#_basket.count-#prefix#_basket.count*#prefix#_catalog.price*(#prefix#_catalog.discount/100)) AS total_sum,
													SUM(#prefix#_basket.count*#prefix#_catalog.price*(#prefix#_catalog.discount/100)) AS total_discount,
													SUM(#prefix#_basket.count) AS total_count,
													#prefix#_basket.count AS count,
													#prefix#_basket.param1 AS size,
													#prefix#_basket.param2 AS format,
													#prefix#_basket.param3 AS type,
													#prefix#_catalog.title AS title,
													#prefix#_developers.title AS developer,
													#prefix#_catalog.discount AS discount,
													#prefix#_catalog.id AS pid,
													#prefix#_catalog.status AS status
													FROM #prefix#_developers, 
														 #prefix#_catalog, 
														 #prefix#_basket,
														 #prefix#_templates
													WHERE #prefix#_catalog.id=#prefix#_basket.pid
														AND #prefix#_basket.client='".$clients->getUID()."'
														AND #prefix#_templates.id=#prefix#_catalog.tid
														AND #prefix#_developers.id=#prefix#_templates.developer
													GROUP by #prefix#_basket.id
													ORDER by #prefix#_catalog.title DESC
													");
	if(!$database->isError())
	{
		if($database->getNumrows($q)!=0)
		{
			?>
				<h2>Спасибо, ваш заказ успешно обработан !</h2>
				
				Номер вашего заказа: <strong>№<?=$tid;?></strong><br/>
				
				Для контакта со службой доставки звоните по указанным в <a href='/contacts' title='Перейти к разделу "Контакты"'>контактах</a>
				номерам, 
				либо пишите с помощью <a href="/write" title="Написать письмо в службу по работе с клиентами">соответствующей формы</a>.
				<br/>
				<br/>
				<?php
													$icq=$database->getSQLParameter("settings","icq");
													?>
				<blockquote class='contacts'>
				Наши телефоны: <strong>
					   <?=$database->getSQLParameter("settings","telephone");?>
				</strong>
				</br>
				ICQ: <strong>
					   <?=$icq;?>
				</strong>
				<img class='icq' src="http://status.icq.com/online.gif?icq=<?=str_replace('-','',$icq);?>&img=5">
				<br/>
				</blockquote>
				<button onclick='window.location.href="/order/saveorder/<?=$tid;?>";return false;' style='color:#0000AA;' title='Отправить ваш заказ в отдел обработки заказов'><strong>Подтвердить заказ</strong></button>
				<hr/>
				<div class='order_form_cntr' style='text-align:center;'>
					   <a href='/order/payment_proceed/<?=$tid;?>' style='color:#0000AA;' title='Произвести оплату заказа с помощью удобной для вас системы'><strong>Оплата заказа</strong></a>
					   :: <a href='/order/clear' style='color:#0000AA;' title='Очистить корзину заказанных товаров'><strong>Удалить заказ</strong></a>
				</div>
				<?
		}else
		{
			$errors->appendJSError("Ваша корзина пуста !");
			$errors->redirect("/");
		}
	}else
	{
	$errors->appendJSError("Ошибка во время диалога с БД!");
	$errors->redirect('/server_.html');
	}				
}else
{
	$errors->appendJSError("Данная часть сайта предназначена исключительно для зарегистрированных клиентов !");
}
print $errors->outputData();
?>