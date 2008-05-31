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
$q=$database->proceedQuery("
							SELECT total,uniqued,
							(SELECT COUNT(id) FROM `#prefix#_accounts`) AS registered,
							(SELECT COUNT(id) FROM `#prefix#_orders` WHERE status='active') AS active_orders,
							(SELECT COUNT(id) FROM `#prefix#_orders` WHERE status='closed') AS closed_orders,
							(SELECT COUNT(id) FROM `#prefix#_orders` WHERE status='canceled') AS canceled_orders,
							(SELECT COUNT(id) FROM `#prefix#_messages` WHERE status='unreaded') AS unreaded_messages,
							(SELECT COUNT(id) FROM `#prefix#_orders` WHERE sector='maket') AS recieved_makets,
							(SELECT COUNT(id) FROM `#prefix#_clx_requests`) AS clx_requests,
							(SELECT COUNT(id) FROM `#prefix#_templates`) AS shirts_count,
							(SELECT COUNT(id) FROM `#prefix#_labels`) AS labels_count,
							(SELECT COUNT(id) FROM `#prefix#_catalog`) AS goods_count,
							(SELECT COUNT(id) FROM `#prefix#_files`) AS rfiles_count,
							(SELECT COUNT(id) FROM `#prefix#_developers) AS developers_count,
							(SELECT COUNT(id) FROM `#prefix#_banners`) AS banners_count,
							(SELECT SUMM(views) FROM `#prefix#_banners) AS banners_tviews
							FROM `#prefix#_statistics`
						");
if(!$database->isError())
{
	if($database->getNumrows($q)!=0)
	{
		$data=$database->fetchQuery($q);
		?>
		<div class='forms'>
			<div class='legend'>Статистические данные по сайту</div>
			<div class='row'>
				<div class='label'>Уникальных посетителей:</div>
				<div class='value'><?=$data['uniqued'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Всего посещений:</div>
				<div class='value'><?=$data['total'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Зарегистрировавшихся пользователей:</div>
				<div class='value'><?=$data['registered'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Необработанных заказов:</div>
				<div class='value'><?=$data['active_orders'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Обработанных заказов:</div>
				<div class='value'><?=$data['closed_orders'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Отменённых заказов:</div>
				<div class='value'><?=$data['canceled_orders'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Непрочитанных сообщений:</div>
				<div class='value'><?=$data['unreaded_messages'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Поступило макетов на разработку:</div>
				<div class='value'><?=$data['makets_recieved'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Запросов из конструктора футболок:</div>
				<div class='value'><?=$data['clx_requests'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Количество футболок в базе:</div>
				<div class='value'><?=$data['shirts_count'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Количество изображений в базе:</div>
				<div class='value'><?=$data['labels_count'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Количество товарных позиций:</div>
				<div class='value'><?=$data['catalog_count'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Поставщиков:</div>
				<div class='value'><?=$data['developers_count'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Баннеров в обороте:</div>
				<div class='value'><?=$data['banners_count'];?></div>
			</div>
			<div class='row'>
				<div class='label'>Всего баннеров показано:</div>
				<div class='value'><?=$data['banners_tviews'];?></div>
			</div>
		</div>
		<?php
	}else
	{
		$errors->appendJSError("Ошибка во время диалога с БД!");
		$errors->redirect("/server_.html");
	}
}else
{
	$errors->appendJSError("Ошибка во время диалога с БД!");
	$errors->redirect("/server_.html");
}
print $errors->outputData();
?>
