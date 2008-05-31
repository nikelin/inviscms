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
$error=new Errors();
?>
<div class='dT'>
	<div class='header'>
		<div class='row'>
			<div class='col' style='width:6%;'>#</div>
			<div class='col' style='width:14%;'>Словарь</div>
			<div class='col' style='width:7%;'>Слов</div>
			<div class='col' style='width:25%;'>Размер (в КБ)</div>
			<div class='col' style='width:28%;'>Последнее изменение</div>
            <div class='col' style='width:14%;'>&nbsp;</div>
		</div>
	</div>
	<div class='body'>
	<?php
	$q=$database->proceedQuery("SELECT id AS dict_id,
										   name,
										   (
											   	SELECT COUNT(id) as wcount 
											   	FROM `#prefix#_texts` 
											   	WHERE partition='dicts' AND param=dict_id
										   ) AS wcount,
										   (
										   		SELECT SUM(LENGTH(value)) AS tsize 
										   		FROM `#prefix#_texts` 
										   		WHERE partition='dicts' AND param=dict_id
										   	) AS tsize,
										   lchange
							 		FROM `#prefix#_dicts`");
	if($database->isError())
	{
		$error->appendJSError("Ошибка во время диалога с БД !".$database->sqlErrorString());
		$error->redirect("/server_.html");
	}else{
		if($database->getNumrows($q)!=0)
		{
			while($row=$database->fetchQuery($q))
			{
			?>
				<div class='row'>
					<div class='col' style='width:6%;'>
						<button style='width:100%;' onclick='Invis.core.loadPage("languages","delete/<?=$row['dict_id'];?>");return false;'>
							X
						</button>
						<button style='width:100%;' onclick='Invis.core.loadPage("languages","clear/<?=$row['dict_id'];?>");return false;'>
							C
						</button>
					</div>
					<div class='col' style='width:14%;'>
						<span class='link' onclick='Invis.core.loadPage("languages","view/<?=$row['dict_id'];?>");return false;' title='Просмотреть'>
							<?=rawurldecode($row['name']);?>
						</span>
					</div>
					<div class='col' style='width:7%;'><?=$row['wcount'];?></div>
					<div class='col' style='width:25%;'><?=$row['tsize']/1000;?>KБайт</div>
					<div class='col' style='width:28%;'><?=date("d.m.Y H:i:s",$row['lchange']);?></div>
                                        <div class='col' style='width:14%;'>
                                            <button style='width:100%;' onclick='Invis.core.loadPage("languages","edit/<?=$row['dict_id'];?>");'>VIEW</button>
                                        </div>
				</div>
			<?php
			}
		}else{
			?>
			<div class='row'>
				<div class='col' style='clear:both;text-align:center;width:100%;'>
					<button onclick='Invis.core.loadPage("languages","add");return false;'>Добавить</button>
				</div>
			</div>
			<?
		}
	}
	?>
	</div>
</div>
<?php
print $error->outputData();
?>