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
$params=$GLOBALS['params']['params'];
$fs=new Errors();
if($params[0]!=''){
	$q=$database->proceedQuery("SELECT *,(SELECT type FROM `#prefix#_templates` WHERE id=tid) AS type FROM `#prefix#_catalog` WHERE LEFT(MD5(id),6)='".substr($params[0],0,6)."'");
	if(!$database->isError())
	{
		if($database->getNumrows($q)!=0){
			while($row=$database->fetchQuery($q))
			{
    		?>
			<form action='' method='post'>
                <h3 style='background-color:#FFFFEF;'>{^info_about_shirt^} "<?=$row['title'];?>"</h3>
						 <div style='font-size:16px;width:100%;margin-bottom:30px;'>
                              <div style='display:block;clear:both;text-align:center;'>
                                         <div style='display:block;clear:both;width:100%;'>
                                          <img alt='{^detail_info^} "<?=$row['title'];?>"' style='width:500px;height:500px;'
                                          src='/previews.php?type=product&p=<?=substr(md5($row['id']),0,6);?>' />
										</div>
                              </div>
                              <div style='float:left;padding-top:20px;text-align:left;margin-left:10%;width:70%;'>
                                   <span style='font-size:14px;display:block;margin-bottom:10px;margin-bottom:5px;'>{^shirt_title^}: <strong><?=$row['title'];?></strong><hr /></span>
                                   <span style='font-size:14px;display:block;margin-bottom:10px;margin-bottom:5px;'>{^developer^}: <strong><a href='/developers/bcl'>BCL(Бельгия)</a></strong><hr /></span> 
                                   <span style='display:block;margin-bottom:5px;clear:both;'>
                                    {^shirt_type^}: <strong><?=($row['type']=="male")?"Мужская":(($row['type']=="female")?"Женская":(($row['type']=="child")?"Детская":"Никто не знает"));?></strong>
                                    </span>
                                    <span style='display:block;margin-bottom:5px;'>
                                            {^label_format^}:
                                            <select style='margin-left:8%;width:40%;'>
                                                    <option>A4 (27*28 cm)</option>
                                            		<option>A5</option>
                                            		<option>A6</option>
                                            </select>
                                    </span>
                                    <span style='display:block;margin-bottom:5px;'>
                                           	{^shirt_size^}:
                                            <select style='margin-left:8%;width:40%;'>
	                                            <option>S (44-46 см)</option>
	                                            <option>M (46-48 см)</option>
	                                            <option>L (48-50 см)</option>
	                                            <option>XL (50-52 см)</option>
	                                            <option>XXL (52-54 см)</option>
	                                            <option>XXXL (54 см)</option>
                                            </select>
                                    </span>
                                    <span style='display:block;margin-bottom:10px;margin-bottom:5px;clear:both;'>
                                            {^price^}: 
                                            <span style='margin-left:30%;font-weight:bold;color:#FF0000;' id='price'>
                                                    <?=($row['price']-(($row['discount']!=0)?$row['price']*$row['discount']/100:0));?>
                                                    грн.
						    <?php
						    if($row['discount']!=0)
						    {
							?>
							<span style='color:#000000;'>скидка:</span> <span style='color:#cc00ff;font-weight:bold;border:0px #000000 dotted;border-bottom-width:2px;'>-<?=$row['discount'];?>%</span>!!!
							<?
						    }
						    ?>
                                            </span>
                                    </span>
                                    <span style='display:block;margin-bottom:10px;margin-bottom:5px;'>Наличие: <span style='margin-left:10%;font-weight:bold;color:#22AA55;'><?=($row['available'])?'ЕСТЬ':'НЕТ';?></span></span>
                            </div>
                            <div style='clear:both;background-color:#FFFFFF;color:inherit;margin-top:40px;'>
                                <button name='action_main' title='{^basket_add_title^}' >{^basket_add^}</button>
                            </div>
                    </div>
				</form>
    <?php
			}
		}else{
			$fs->appendJSError("{^product_ne^}!");
		}
	}else{
		$fs->appendJSError("{^db_error^}!");
	}
}else{
	$fs->appendJSError('Error while proceeding the script !');
}
print $fs->outputData();
?>
