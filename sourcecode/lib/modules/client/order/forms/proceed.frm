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
if($security->authorized("client"))
{
?>
	<div class='table' style='width:100%;border:0;clear:both;'>
			<?php
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
							#die_r($database->sqlErrorString());
				if(!$database->isError())
				{
					if($database->getNumrows($q)!=0)
					{
						$data=array();
						while($data[]=$database->fetchQuery($q)){}
						$row=$data[0];
							#print_r($data);
							?>
						<div class='body'>
							<div class='row'>
								<div class='col' style='height:30px;text-align:left;background-color:#FFFFEF;'>
									<h2 class='contents'><strong>Состав заказа:</strong></h2>
								</div>
							</div>
							<div class='row'>
								<div class='col list1'>
									<span>Общая сумма заказа: <strong class='total_sum_label'><?=round($row['total_sum'],2);?></strong> грн.<?=($row['total_discount']!=0)?"(<span class='discount_label'>-".round($row['total_discount'],2)."грн.</span>)":"";?></span>
									<span>Кол-во <u>футболок</u>: <strong style='margin-left:130px;'><?=$row['total_count'];?></strong> шт.</span>
									<p/>
									<span><strong>Заказанные товары:</strong></span>
									<blockquote>
									<ol style='padding:0;margin-left:20px;'>
										<?php
											for($j=0;$j<count($data)-1;$j++)
											{
												?>
												<li>
													Название футболки "<strong><?=rawurldecode($data[$j]['title']);?></strong>"  x <?=$data[$j]['count'];?> <?=($data[$j]['discount']!=0)?"(<strong title='Акционная скидка на эту футболку'>акция</strong>: <span class='discount_label'>-<strong>".$data[$j]['discount']."</strong> %</span>)":"";?></span>
												</li>
												<?
											}
										?>
									</ol>
									</blockquote>
									<button class='nextstage' onclick='window.location.href="/order/nextstage";return false;'>Оформить заказ</button>
								</div>
							</div>
						</div>
						<?php
					}else
					{
						?>
						<div class='row'>
							<h2 style='margin:0;'>Ваш заказ пуст.</h2>
							<a href='/home' title='Перейти к выбору товаров из каталога'>
								<strong>Назад к каталогу</strong>
							</a>
						</div>
						<?
					}
				}else
				{
					$errors->appendJSError("Ошибка во время диалога с БД!");
					$errors->redirect("/server_.html");
				}
			?>
</div>
<?php
}else{
	$errors->appendJSError("Только авторизированные клиенты имеют доступ к данному разделу!");
}
?>
