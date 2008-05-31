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
$q=$database->proceedQuery("SELECT id,title,description,country,logo,
							(SELECT src FROM `#prefix#_files` WHERE id=logo) AS logo_src,
							(SELECT value FROM `#prefix#_countries` WHERE id=country) AS cntr
							FROM `#prefix#_developers`
							WHERE status='on'");
if($database->isError())
{
	$errors->appendJSError("{^db_error^}!");
	$errors->redirect("/server_.html");
}else
{
	?>
	<div class='devlist'  style='clear:both;width:100%;height:100%;overflow:auto;'>
	<?php
	if($database->getNumrows($q)!=0)
	{
		while($row=$database->fetchQuery($q))
		{
			?>
			<div style='font-size:15px;display:block;background-color:#999999;color:inherit;clear:both;height:150px;margin-bottom:50px;'>
				<div class='logo' style='float:left;width:30%;height:100%;background-color:#EEEEEE;'>
					<img style='width:120px;' src='/lib/files/<?=$row['logo_src'];?>' alt='{^developer_logotype^} <?=rawurldecode($row['title']);?>'/>
				</div>
				<div class='description' style='float:left;width:70%;'>
					<div class='row' style='width:100%;display:block;'>
						<div class='label' style='background-color:#CCCCCC;color:#000000;clear:both;width:100%;float:left;'>{^developer_company_title^}:</div>
						<div class='value' style='float:left;width:100%;background-color:#FFFFFF;font-weight:bold;'><?=rawurldecode($row['title']);?></div>
					</div>
					<div class='row' style='width:100%;display:block;'>
						<div style='background-color:#CCCCCC;color:#000000;clear:both;width:100%;float:left;'>{^developer_country^}:</div>
						<div class='value' style='clear:both;float:left;width:100%;background-color:#FFFFFF;font-weight:bold;'>
							<span style='color:#00AA00;'><?=rawurldecode($row['cntr']);?></span>
						</div>
					</div>
					<div style='height:30px;display:block;'>&nbsp;</div>
					<div class='row' style='width:100%;display:block;'>
						<div class='label' style='border:1px #000000 dashed;border-left-width:0px;border-right-width:0px;clear:both;width:100%;background-color:#FFFFFF;font-weight:bold;font-size:18px;'>
							{^developer_about^}:
						</div>
					</div>
					<div class='row' style='width:100%;display:block;'>
						<div class='value' style='clear:both;width:100%;background-color:#FFFFFF;height:50px;overflow:auto;'>
							<?=rawurldecode($row['description']);?>
						</div>
					</div>
				</div>
			</div>
			<?
		}
	}
	?>
	</div>
	<?php
}
