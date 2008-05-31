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
$id=$GLOBALS['params']['params'][2];
if(is_numeric($id) && $id>0){
	?> 
	<div class='dT' style='width:400px;margin-left:20%;'>
		<div class='header'>
			<div class='row'>
				<div class='col' style='width:5%;'>#</div>
				<div class='col' style='width:35%;'>Элемент</div>
				<div class='col' style='width:57%;'>Слово</div>
			</div>
		</div>
		<div class='body' id='wlist'>
		<?php
		$q=$database->proceedQuery("SELECT * FROM `#prefix#_texts` WHERE partition='dwords' AND param='".$id."'");
		if($database->isError())
		{
			$error->appendJSError("Ошибка во время диалога с БД !");
			$error->redirect("/server_.html");
		}else{
			if($database->getNumrows($q)!=0)
			{
				while($row=$database->fetchQuery($q))
				{
				?>
					<div class='row'>
						<div class='col' style='width:6%;'>
							<input type='checkbox' id='ids[]' value='4' name='el1'/>
						</div>
						<div class='col' style='width:15%;'><?=$row['name'];?></div>
						<div class='col' style='width:15%;'><?=$row['value'];?></div>
					</div>
				<?php
				}
			}else{
				?>
				<div class='row'>
					<div class='col' style='clear:both;text-align:center;width:100%;'>
						<button onclick='javascript:dicts_words_addField();'>Добавить</button>
					</div>
				</div>
				<?
			}
		}
		?>
		</div>
	</div>
	<?
}else{
	$errors->appendJSError("Ошибка во время проверки параметров !");
}
print $error->outputData();
?>