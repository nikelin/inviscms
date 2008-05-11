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
$page_id=isset($GLOBALS['params']['params'][0])?$GLOBALS['params']['params'][0]:null;
$additional=isset($GLOBALS['params']['params'][1])?$GLOBALS['params']['params'][1]:null;
if($page_id && trim($page_id)!='')
{
	$q=$database->getRows("pages","*",array('LEFT(MD5(id),6)'=>$page_id,'type'=>'pub','status'=>'on'));
	if(!$database->isError())
	{
		if($database->getNumrows($q)!=0)
		{
			$row=$database->fetchQuery($q);
			$hid=substr(md5($row['id']),0,6);
			?>
				<div class='pageclass'>
					<div class='top' style='clear:both;'>
						<h1 class='title center' style='float:left;width:75%;'><?=$tools->decodeString($row['title']);?></h1>
						<a href='/printversion/articles/<?=$hid;?>' style='text-decoration:none;float:left;width:20%;margin-top:10px;' title='Получить постоянную ссылку на данную публикацию'>
							<strong style='display:block;border:0px #FF0000 dotted;border-bottom-width:2px;'>Версия для печати и PDA</strong>
						</a> 
					</div>
					<blockquote style='clear:both;display:block;margin:0;margin-bottom:30px;height:auto;overflow:auto;width:100%;margin-top:25px;background-color:#FFFFFF;font-weight:bold;text-align:left;'>
						<?=stripslashes($tools->decodeString($row['description']));?>
					</blockquote>
					<div style='font-size:17px;margin-bottom:40px;text-align:left;font-family:Tahoma, Verdana, "Times New Roman",DejaVu;clear:both;'>
						<?=stripslashes($tools->decodeString($row['text']));?>
					</div>
					<div style='clear:both;display:block;text-align:right;font-size:14px;margin-bottom:10px;'><em>Дата публикации: <strong><?=date("d.m.Y",$row['pub_date']);?></strong></em></div>
					<div style='display:block;background-color:#EEEEEE;border:1px #000000 ridge;color:inherit;'>
						<a href='/printversion/articles/<?=$hid;?>' title='Получить постоянную ссылку на публикацию "<?=$tools->decodeString($row['title']);?>'>Версия для печати</a> 
						:: 
						<a href='#' title='Получить постоянную ссылку на данную публикацию' onclick='Invis.tools.changeElVis("permanent","switch");return false;'>Ссылка на статью</a> 
						:: 
						<a href='#' title='Получить код для размещения в своём блоге либо собственном сайте' onclick='Invis.tools.changeElVis("blogum","switch");return false;'>Код для блога</a> 
						::
						<a href='/articles/<?=$hid;?>/comments' title='Комментарии к публикации "<?=$row['title'];?>"'>Комментарии</a> (21 комментарий)
					</div>
					<div id='permanent' style='display:none;text-align:left;margin-top:20px;background-color:#FFFFFF;'>
						<strong>Постоянная ссылка на статью:</strong>
						<input type='text' name='permanent_link' style='width:100%;font-weight:bold;' onclick='this.select()' value='http://futbolkaprint.com.ua/articles/<?=$hid;?>'/>
					</div>
					<div id='blogum' style='display:none;text-align:left;margin-top:20px;background-color:#FFFFFF;'>
						<strong>Постоянная ссылка на статью:</strong>
						<input type='text' name='permanent_link' style='width:100%;font-weight:bold;' onclick='this.select()' value='http://futbolkaprint.com.ua/articles/<?=$hid;?>'/>
					</div>
					
					<div class='related'>
						<h2 class='title'>Похожие статьи:</h2>
						<?=$GLOBALS['uinterface']->getPubFeed(10,$row['keywords']);?>
					</div>
					
					<div class='copyrights' style='background-color:#cccccc;color:inherit;font-size:12px;font-weight:bold;text-align:left;'>
						Все права на данную статью принадлежат исключительно её авторам !(с)
					</div>
				</div>
			<?php	
		}else{
			$errors->appendJSError("Данная страница не существует!");
			$errors->redirect('/');
		}
	}else{
		$errors->appendJSError("Ошибка во время диалога с БД!");
	}
}else
{
	$errors->appendJSError("Неверный формат параметров!");
}
print $errors->outputData();
?>