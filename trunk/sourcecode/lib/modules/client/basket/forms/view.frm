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
$client=$clients->getUID();
?>

<div class='basket' style='clear:both;''>
	<form method='post'>
    <div class='logo'>
        {^your_boughts^} ({^total_amount^}: <?=$basket->totalCost($client);?> гривен)
    </div>
	<div class='top'>
		<button onclick='window.location.href="/basket/view";return false'>{^basket_recalculate^}</button>
		<button onclick='window.location.href="/order";return false;'>{^order^}</button>
		<button onclick='Invis.modules.basket.clear.kick();return false;'>{^clear^}</button>
	</div>
    <div class='listing'>
       	<?
       	$q=$database->proceedQuery("SELECT id, pid, count,
									(SELECT title FROM `#prefix#_catalog` WHERE id=pid) AS title,
									(SELECT coords FROM `#prefix#_catalog` WHERE id=pid) AS coords,
									(SELECT price FROM `#prefix#_catalog` WHERE id=pid) AS price,
									(SELECT tid FROM `#prefix#_catalog` WHERE id=pid) AS template,
									(SELECT lid FROM `#prefix#_catalog` WHERE id=pid) AS label,
									(SELECT type FROM `#prefix#_templates` WHERE id=template) AS shirt_type,
									(SELECT src FROM `#prefix#_files` WHERE id=(SELECT front FROM `#prefix#_templates` WHERE id=template AND status='on') AND status='on') AS template_src,
									(SELECT src FROM `#prefix#_files` WHERE id=(SELECT fid FROM `#prefix#_labels` WHERE id=label AND status='on')) AS label_src
									FROM `#prefix#_basket` 
									WHERE client='".$client."'
									");
       	if(!$database->isError()){
       		if($database->getNumrows($q)!=0)
       		{
       			while($row=$database->fetchQuery($q))
       			{
       				$idh=substr(md5($row['id']),0,6);
				?>
				    <div class='item' id="item0x<?=$idh;?>">
			            <div class='left'>
			                <div onclick='Invis.modules.store.basket.plus.kick("<?=$idh;?>");return false;' class='btn center'>
			                    +
			                </div>
			                <div onclick='Invis.modules.store.basket.minus.kick("<?=$idh;?>");return false;' class='btn center'>
			                    -
			                </div>
			            </div>
			            <div class='center'>
			                <div class='top'>
			                    <div class='image'>
			                        	<img src='/previews.php?type=product&p=<?=substr(md5($row['pid']),0,6);?>' alt='{^shirt_image^}' class='preview'/>
			                    </div>
			                    <div class='description'>
			                        <div class='title'>
			                            <span><?=substr(rawurldecode($row['title']),0,2);?> </span><?=substr($row['title'],2);?>
			                        </div>
			                        <div class='price'>
			                            <strong><?=$row['price'];?>грн.</strong> за ед.
			                        </div>
									 <div class='type'>
			                            <span>{^shirt_type^}</span>
										<strong><?=('{^'.$row['shirt_type'].'_shirt^}');?></strong>
			                        </div>
			                        <div class='quantity'>
			                            <span class='label'>{^count^}</span>
			                          	  <span><input type='text' id='basket_count_<?=$idh;?>' value='<?=$row['count'];?>' size='2'/></span>
										  <span><input type='submit' value='{^add^}' onclick='Invis.modules.store.basket.change_quantity.kick("<?print $idh;?>",document.getElementById("basket_count_<?=$idh;?>").value);return false;'/></span>
								    </div>
									 <div class='discount'>
			                            Скидка для членов <span class='club'>{^club^}</span>: <span style='color:#00AA00;'>5%</span>
			                        </div>
									<div class='text'>
										<?=$row['description'];?>
									</div>
			                    </div>
			                </div>
							<div class='spacer'>&nbsp;</div>
			                <div class='middle'>
								<span>
									{^total_to_pay^}: <strong><?=$row['count']*$row['price'];?>грн.</strong>
								</span>
							</div>
							<div class='footer'>
			                    <button onclick='window.location.href="/basket/remove/<?=$idh;?>";return false;'>{^drop^}</button>
			            	</div>
			            </div>
			<?php
       			}
       		}else{
			?>
			{^basket_empty^}.<br/>
			<button onclick='window.location.href="/home";return false;'>{^to_catalog^}</button>
			<?
       		}
       	}else{
       		die_r($database->sqlErrorString());
       	}
	?>
	</div>
	</div>
	<div class='bottom'>
		<button>{^recalculate^}</button>
		<button onclick='window.location.href="/order";return false;'>{^order^}</button>
		<button onclick='window.location.href="/basket/clear";return false;'>{^clear^}</button>
	</div>
	</form>
    </div>
</div>
