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
$q=$database->getRows("orders","*",array("client"=>$clients->getUID()));
if(!$database->isError())
{
	if($database->getNumrows($q)!=0)
	{
		?>
		<div class='text' style='color:#000000;'>
			<button style='width:100%;' onclick='window.location.href="/account";return false;'>Вернуться</button>
			<h1 style='text-align:center;'>Ваши заказы на обработке:</h1>
			<?php
			while($row=$database->fetchQuery($q))
			{
				$data=unserialize($row['products']);
				?>
				<h3>Заказ №<?=$row['id'];?></h3>
				<p style='padding-left:30px;'>
					<span><strong>Заказанные товары:</strong></span>
					<blockquote>
						<ol style='padding:0;margin-left:20px;'>
							<?php
							foreach($data as $v)
							{
								$x=$database->proceedQuery("SELECT * FROM `#prefix#_catalog` WHERE id='".$v['product']."'");
								$x=$database->fetchQuery($x);
							?>
								<li>
									Название футболки "<strong><?=$x["title"];?></strong>"  x <?=$v['count'];?> <?=($x['discount']!=0)?"(<strong title='Акционная скидка на эту футболку'>акция</strong>: <span class='discount_label'>-<strong>".$x['discount']."</strong> %</span>)":"";?> = <?=$x['price']*$v['count']*(($x['discount']!=0)?$x['discount']/100:1);?></span>
									<div><?=$x['cost'];?></div>
								</li>
							<?
							}
							?>
						</ol>
					</blockquote>
				</p>
				Статус заказ: <strong><?=$row['status'];?></strong>
				<?php
				}
			}
			?>
		</div>
		<?php
		}
	?>
	<button style='width:100%;' onclick='window.location.href="/account";return false;'>Вернуться</button>
