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
$sys=@$GLOBALS['params']['params'][2];
$interface=@$GLOBALS['params']['params'][3];
if($sys)
{
	if(!$interface){
		$interfaces=$paymentcontroller->getInterfaces($sys);
		#die_r($interfaces);
		?>
		<div class='dT'>
			<h2 class='title center'>Управление платежами</h2>
			<div class='header'>
				<div class='row'>
					<div class='col' style='width:100%;clear:both;'>
						<?php
							for($i=0;$i<count($interfaces);$i++)
							{
								?>
									<button onclick='Invis.core.loadPage("payment","sys/<?=$sys;?>/<?=$interfaces[$i]['id'];?>");return false;'>
										<strong><?=$interfaces[$i]['title'];?></strong>
									</button>
								<?
							}
						?>
					</div>
				</div>
			</div>
		</div>
<?
	}else{
		print $paymentcontroller->loadInterfaceUI($sys,"admin",$interface);
	}
}
?>
