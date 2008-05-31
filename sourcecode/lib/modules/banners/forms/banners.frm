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
$errorsB=new Errors();
?>
    <div class='dT' style='width:100%;margin-left:0%;'>
        <h2 class='title center'>Управление баннерами сети</h2>
        <div class='body'>
            <div class='header'>
                <span class='col' style='width:15%;'>Клиент</span>
				<span class='col' style='width:15%;'>Дата</span>
                <span class='col' style='width:9%;'>Заказано</span>
				<span class='col' style='width:9%;'>Показан</span>
                <span class='col' style='width:11%;'>Кликов</span>
                <span class='col' style='width:8%;'>CTR</span>
                <span class='col' style='width:17%;'>URL</span>
				<span class='col' style='width:10%;'>Статус</span>
            </div>
            <?php
			$q=$database->proceedQuery("SELECT 
												#prefix#_banners.id AS id,
												#prefix#_banners.date AS date,
												#prefix#_banners.views AS views,
									#prefix#_banners.shows AS shows,
												#prefix#_banners.clicks AS clicks,
												(clicks/shows)*100 AS ctr,
												#prefix#_accounts.name AS client,
												#prefix#_banners.url AS url,
												#prefix#_banners.status AS status
										FROM #prefix#_banners,#prefix#_accounts,#prefix#_clients
										WHERE #prefix#_clients.id=#prefix#_banners.client
													AND #prefix#_accounts.id=#prefix#_clients.pid
													AND #prefix#_banners.status='on'
										GROUP by #prefix#_banners.client
										ORDER by #prefix#_banners.id ASC
												");
			if($database->isError())
			{
				?>
            <div class='row'>
                <span class='col' style='width:100%;'>Ошибка во время диалога с БД!</span>
            </div>
            <?php
			 }else{
			  if($database->getNumrows($q)!=0){
				 while($row=$database->fetchQuery($q)){
			 	 ?>
            <div class='row' style='background-color:#FFFFEF;min-height:50px;'>
				<span class='col' style='width:15%;background-color:#<?=(($row['status']!='on')?"FF0000":"00AA00");?>'>
                    <?=rawurldecode($row['client']);?>
                </span>
				<span class='col' style='width:15%;'>
                    <?=date("d.m.Y",$row['date']);?>
                </span>
                <span class='col' style='width:9%;'>
                    <?=$row['views'];?>
                </span>
				<span class='col' style='width:9%;'><?=$row['shows'];?></span>
				<span class='col' style='width:11%;'>
                    <?=$row['clicks'];?>
                </span>
				<span class='col' style='width:8%;'>
                    <?=round($row['ctr'],6);?>%
                </span>
				<span class='col' style='width:17%;'>
                    <a href='<?=$row['url'];?>'><?=$row['url'];?></a>
                </span>
                <span class='col' style='width:10%;'>
                    <?=$row['status'];?>
                </span>
            </div>
			<div class='row'>
				<div class='col' style='clear:both;width:100%;text-align:center;'>
					<button onclick='Invis.core.loadPage("banners","delete/banner/<?=$row['id'];?>");return false;' style='width:25%;font-size:11px;font-weight:bold;'>Удалить</button>
					<button onclick='Invis.core.loadPage("banners","banner/edit/<?=$row['id'];?>");return false;' style='width:25%;font-size:11px;font-weight:bold;'>Изменить</button>
					<button onclick='Invis.core.loadPage("banners","banner/status/<?=$row['id'];?>");return false;' style='width:28%;font-size:11px;font-weight:bold;'>Заблокировать/Разблокировать</button>	
				</div>
			</div>
            <?php
		  		 }
			 }else{
				?>
            <div class='row'>
                <span class='col' style='width:100%;'>Информация не найдена.</span>
            </div>
            <?php
			 }
		 }
			 ?>
            <input type='hidden' name='action_clients'/>
            <div class='row'>
                <div class='col' style='width:100%;background-color:#000000;'>
                    <button onclick="Invis.core.loadPage('banners','banneradd');return false;">
                        Новый баннер
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
print $errorsB->outputData();
?>
