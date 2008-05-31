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
?><form action='' method='post'>
    <div class='dT' style='width:100%;margin-left:0;'>
        <div class='body'>
            <?php
						 $errorB=new Errors();
						 $q=$database->proceedQuery("SELECT id AS product,description,tags,price,title,tid,lid,cid,discount,
						 							(SELECT developer FROM `#prefix#_templates` WHERE id=tid) as dev_id,
													(SELECT title FROM `#prefix#_developers` WHERE id=dev_id) AS dev_title,
													(SELECT title FROM `#prefix#_texts` WHERE id=cid) as cat_title
													 FROM `#prefix#_catalog` ORDER by `id` ASC");
						 if($database->isError())
						 {
							 $errorB->appendJSError("Ошибка во время диалога с БД !");
							 $errorB->redirect("/server_.html");
						 }else{
									 if($database->getNumrows($q)==0)
									 {
									 ?>
							            <span class='row' style='width:100%'>Позиции не найдены в БД.</span>
							          <?
									 }else
									 {
									       while($row=$database->fetchQuery($q))
										   {
											?>
												<h2 class='title' style='background-color:#EEEEFE;'>
													<a href='/admin/store/delete/<?=$row['product'];?>' style='cursor:pointer;font-size:18px;font-weight:bold;color:#AA3333;'>X</a>&nbsp;&nbsp;<span onclick='Invis.tools.changeElVis("position_<?=$row['product'];?>","switch")' style='cursor:pointer'>Футболка "<?=$row['title'];?>"</a>
												</h2>
									            <form action='' method='post'>
													<input type='hidden' name='pid' value='<?=$row['product'];?>'/>
													<div class='position' id="position_<?=$row['product'];?>" style='display:none;margin:0;padding:0;background-color:#EEEEFF;width:100%;'>
														<div class='row' style='margin-bottom:10px;'>
															 <input type='submit' name='save' value='Сохранить' style='display:block;width:100%;height:20px;background-color:#EEEEEE;'/>
														</div>
														<div class='row'>
															<img src='/previews.php?type=product&p=<?=substr(md5($row['product']),0,6);?>' alt='Превью'/>
														</div>
														<div class='row' style='margin:0;padding:0;'>
												            <span class='col' style='width:35%;'>
												            	Футболка:
															</span>
															<span class='col' style='width:55%;'>
																<?=$tools->buildList("select","tid",array("datasource"=>"templates","value"=>"id","label"=>"title"),array("value"=>$row['tid']));?>
												            </span>
														</div>
														<div class='row' style='margin:0;padding:0;'>
												            <span class='col' style='width:35%;'>
												            	Изображение:
															</span>
															<span class='col' style='width:55%;'>
																<?=$tools->buildList("select","lid",array("datasource"=>"labels","value"=>"id","label"=>"title"),array("value"=>$row['lid']));?>
												            </span>
														</div>
														<div class='row' style='margin:0;padding:0;'>
												            <span class='col' style='width:35%;'>
												            	Название товарной позиции:
															</span>
															<span class='col' style='width:55%;'>
																<input type='text' name='title' value='<?=$row['title'];?>' style='width:100%;'/>
												            </span>
														</div>
														<div class='row'>
															<span class='col' style='width:35%;'>
															    Категория:
															</span>
															<span class='col' style='width:55%;'>
																<?=$tools->buildList("select","cid",array('datasource'=>'cats','where'=>array('status'=>'on','pid!'=>'-1'),'value'=>'id','label'=>'title'),array("value"=>$row['cid']));?>
															</span>    
														</div>
														<div class='row'>
															<span class='col' style='width:35%;'>
															    Цена товарной позиции:
															</span>
															<span class='col' style='width:55%;height:15px;'>
															    <input type='text' name='price' value='<?=$row['price'];?>' style='width:100%;'/>
															</span>
														</div>
														<div class='row'>
															<span class='col' style='width:35%;'>
															    Скидка (%):
															</span>
															<span class='col' style='width:55%;height:15px;'>
															    <input type='text' name='price' value='<?=$row['discount'];?>' style='width:100%;'/>
															</span>
														</div>
														<div class='row'>
												        	<span class='col' style='width:100%;'>
																Описание товарной позиции
															</span>
												        </div>
														<div class='row'>
												        	<span class='col' style='width:100%;'>
																<textarea name='description' style='width:100%;'><?=$row['description'];?></textarea>
															</span>
												        </div>
														<div class='row' style='display:none;' id='product_desc_<?=$row['product'];?>'>
															<div class='col' style='width:100%;clear:both;height:40px;overflow:auto;'>
																<?=$row['description'];?>
															</div>
														</div>
												        <div class='row' style='font-size:16px;'>
												            <strong>Теги</strong>: 
												            <input style='width:100%;' type='text' name='tags' value='<?=$row['tags'];?>'/>
												        </div>
												        <div class='row center' style='background-color:#000000;color:#FFFFFF;font-size:18px;font-weight:bold;'>
												            <input type='radio' name='active' value='0'/>НЕТ В НАЛИЧИИ
												            <input type='radio' name='active' value='1'/>ЕСТЬ В НАЛИЧИИ
												        </div>
														<div class='row' style='margin-top:10px;'>
															 <input type='submit' name='action_list' value='Сохранить' style='display:block;width:100%;height:20px;background-color:#EEEEEE;'/>
														</div>
													</div>
												</form>
									        <?
												 }
									 }
						 }
						 ?>
    </div>
    </div>
    <input type='hidden' name='action_main'/>
    <?=$uinterface->buildActionsTab('pages',array('delete'=>'Удалить','deny'=>'Блокировать','restore'=>'Разблокировать'));?>
</form>
<?php
print $errorB->outputData();
?>
