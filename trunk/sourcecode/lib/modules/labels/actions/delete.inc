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
?>
<form action='' method='post'>
	<h3 style='text-align:center;'>Вы действительно хотите удалить данную картинку ?</h3>
	<?php
	$q=$database->proceedQuery("SELECT #prefix#_labels.id AS lid,
								COUNT(#prefix#_catalog.id) AS goods,
								COUNT(#prefix#_basket.id) AS orders
								FROM `#prefix#_labels`, `#prefix#_basket`, `#prefix#_catalog`
								WHERE #prefix#_labels.id=".$_POST['_tid']."
									 AND #prefix#_basket.pid=#prefix#_catalog.id 
									 AND #prefix#_catalog.lid=lid
								GROUP by lid
								ORDER by lid");
	#die_r($database->sqlErrorString());
	if(!$database->isError())
	{
		if($database->getNumrows($q)!=0)
		{
			$row=$database->fetchQuery($q);
			?>
			<blockquote>
				С ней связано:<br/>
					<p><strong><?=$row['goods'];?> товаров</strong>, на которые сделано <strong><?=$row['orders'];?> заказов</strong></p>
				Если вы удалите её, то товары будут заблокированы,<br/>
				а с заказами ничего не случится<br/>
			</blockquote>
			<?php
		}
		?>
		<input type='hidden' name='action_main' value='delete_approve'/>
			<input type='hidden' name='eid' value='<?=$_POST['_tid'];?>'/>
			<div style='background-color:#CCCCCC;text-align:center;'>
				<input type='submit' name='yes' style='width:100px;' value='Да'/>
				<button  style='width:100px;' onclick='Invis.core.loadPage("labels","main");return false'>
					Нет
				</button>
			</div>
		<?php		
	}else
	{
		$errors->appendJSError("Ошибка диалога с БД!");
	}
	?>
</form>
<?php
print $errors->outputData();
?>