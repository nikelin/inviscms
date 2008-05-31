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
$error=new Errors();#die_r($tools->getTextCollage("files"));
$q=$database->proceedQuery("SELECT #prefix#_labels.id AS id,fid,cid,#prefix#_labels.title,#prefix#_files.comment AS fdesc,fid,src,ext,size
							FROM `#prefix#_labels`, `#prefix#_files`
							WHERE #prefix#_files.id=#prefix#_labels.fid
									AND #prefix#_labels.status='on' AND #prefix#_files.status='on'
								   ");
if(!$database->isError()){
	if($database->getNumrows($q)==0){
		?>
		<div style='background-color:#EEEEEE;' class='center'>
			<button onclick='Invis.core.loadPage("labels","add");return false;'>Добавить картинку</button>
		</div>
		<?
	}else{
        
		while($row=$database->fetchQuery($q)){
			$src=($row['src'][0]=='.')?substr($row['src'],1):$row['src'];
			?>
			<span class='header center'><h2>Картинки</h2></span>
				<div class='form' style='margin-bottom:40px;width:400px;margin-left:17%;'>
						<div class='row' >
							<div class='label center' style='clear:both;width:100%;height:auto;'>
								<button style='width:100%;font-weight:bold;' onclick='Invis.tools.changeElVis("img<?=$row['id'];?>","switch");return false;' id='btn<?=$row['id'];?>'>
									Изображение
								</button>
							</div>
						</div>
						<div class='row'>
							<div id='img<?=$row['id'];?>'  class='label center' style='display:none;width:100%;clear:both;height:200px;'>
								<div style='clear:both;'>
									<img style='float:left;width:35%'  src='<?=$src;?>'  width='150' height='100' alt='Image Screenshot'/>
									<div style='float:right;background-color:#FFFFFF;'>
										Расширение: <strong><?=$row['ext'];?></strong><br/>
										Размер: <strong><?=filesize('.'.$src)/1000;?>KB</strong><br/>
										Дата добавления: <strong><?=date("d.m.Y H:i:s",fileatime('.'.$src));?></strong><br/>
									</div>
								</div>
							<form action='' method='post'>	
								<div style='clear:both;width:100%;'>
									Изображение:<br/>
									<form action='' method='post'>
										<?php
										if(false!==($d=$tools->buildList("select","file",array("value"=>"id","label"=>"title","datasource"=>'files','where'=>array('status'=>"on"),array('value'=>$row['fid'])))))
										{
											print $d;
										}else{
											?>
											<input type='hidden' name='uploadimg'/>
											<input type='hidden' name='action_main' value='imagechange'/>
											<input type='file' name='ufile'/>
											<?
										}
										?>
										<input type='button' name='add' value='Сохранить'/>
									</form>
									<input type='button' onclick='Invis.core.loadPage("files","main");return false' value='Архив'/>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class='label1' style='float:left;width:40%;height:25px;'>Название картинки:</div>
							<div class='value'>
								<input type='text' name='title' value='<?=rawurldecode($row['title']);?>'/>
							</div>
						</div>
						<div class='row'>
							<div class='label1' style='float:left;width:40%;height:25px;'>Категория:</div>
							<div class='value'>
								<?php
									
									if(($d=$tools->buildList("select","cat",array("datasource"=>"texts","where"=>array("partition"=>"labels"),"label"=>"value","value"=>"id"),array("value"=>$row['cid']))!==true))
									{
										?>
										<button onclick='Invis.core.loadPage("labels","cats");return false;'>Добавить</button>
										<?php
									}else{
										print $d;
									}
								?>
							</div>
						</div>
						<div class='row'>
                                                    <form action='' method='post'>
							<div class='submit'>
								<input type='hidden' name='_tid' value='<?=$row['id'];?>'/>
								<input type='submit' name='action_main' value='delete'/>
								<input type='submit' name='action_main' value='save'/>
							</div>
                                                        </form>
						</div>
				</div>
		
			<?php
			}
		}
	}else{
		die($database->sqlErrorString());
		$errors->appendJSError("Ошибка во время диалога с БД !");
		$errors->redirect("/server_.html");
	}
	print $errors->outputData();
?>