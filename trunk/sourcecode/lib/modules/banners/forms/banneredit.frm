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
$id=$GLOBALS['params']['params'][2];
$errors=new Errors();
if(!is_numeric($id) || $id<=0)
{
	$errors->appendJSError("Ошибка во время проверки параметров!");
}else
{
	if($database->checkRowExists("banners",array("id"=>$id)))
	{
		$data=$database->getRows("banners","*",array("id"=>$id));
		if(!$database->isError())
		{
			$data=$database->fetchQuery($data);
			?>
			<form action='' method='post'>
				<div class='form'>
					  <div class='legend'>Добавление нового баннера</div>
				     <div class='row'>
					       <div class='label label1'>Клиент:</div>
					       <div class='value'>
			               <?=$tools->buildList('select','cid',array('datasource'=>'clients','value'=>'id','label'=>'fio'),array("value"=>$data['client']));?>
								 </div>
					  </div>
					  <div class='row'>
					       <div class='label label1'>Ссылка для баннера:</div>
					       <div class='value'>
								 			<input type='text' name='url' value='<?=rawurldecode($data['url']);?>'/>
							   </div>
					  </div>
					  <div class='row'>
					       <div class='label label1'>Ссылка на изображение:</div>
					       <div class='value'>
				             <input type='text' name='src' value='<?=rawurldecode($data['src']);?>'/>
							 </div>
					  </div>
				     <div class='row'>
					       <div class='label label1'>...либо, выберите его из архива:</div>
					       <div class='value'>
					            <?=$tools->buildList("select","image",array("datasource"=>"files","value"=>"id","label"=>"title"),array("value"=>$data['image']));?>
							</div>
					  </div>
					  <div class='row'>
					       <div class='label label1'>ALT-текст баннера:</div>
					       <div class='value'>
					            <input type='text' name='alt' value='<?=$data['alt'];?>'/>
							 </div>
					  </div>
					  <div class='row'>
					       <div class='label label1'>Количество показов:</div>
					       <div class='value'>
					            <input type='text' name='views' value='<?=$data['views'];?>'/>
							 </div>
					  </div>
					  <div class='row'>
					       <div class='label label1' style='background-color:#3399ff;width:100%;text-align:center;'>HTML-код:</div>
					  </div>
					  <div class='row'>
					       <div class='label label1'>
					            <textarea name='html' rows='5' style='width:100%;'><?=$data['html'];?></textarea>
						   </div>
					  </div>
					  <div class='row'>
					       <div class='label submit'>
					       			<input type='hidden' name='bid' value='<?=$data['id'];?>'/>
									<button name='action_banneredit'>Загрузить</button>
							 </div>
					  </div>
				</div>
			</form>
			<?php
		}
	}else
	{
		$errors->appendJSError("Данный баннер не существует!");
		$errors->redirect("/admin/banners/banners");		
	}
}
print $errors->outputData();
?>
