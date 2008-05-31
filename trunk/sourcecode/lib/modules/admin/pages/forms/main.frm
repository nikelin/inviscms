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
    <div class='dT'>
        <h2 class='title center'>Статические страницы</h2>
        <div class='header' style='margin:0;padding:0;'>
			<div class='row'>
	            <span class='col' style='width:5%;height:15px;'><input type='checkbox' name='selAll' onclick='uiTools.selectAll("el_id");return false;'/></span><span class='col' style='width:23%;height:15px;'>Заголовок страницы</span>
	            <span class='col' style='width:25%;height:15px;'>Короткий адрес страницы</span>
	            <span class='col' style='width:25%;height:15px;'>Дата добавления</span>
	            <span class='col' style='width:15%;height:15px;'>Статус</span>
			</div>
        </div>
        <div class='body' style='margin:0;padding:0;'>
            <?php
						 $errorB=new Errors();
						 $q=$database->proceedQuery("SELECT * FROM `#prefix#_pages` ORDER by `id` ASC");
						 if($database->isError()){
							 $errorB->appendJSError("Ошибка во время диалога с БД !");
						 }else{
									 if($database->getNumrows($q)==0){
									 ?>
            <span class='row' style='width:100%'>Страницы не найдены в БД.</div>
            <?
									 }else{
									       while($row=$database->fetchQuery($q)){
													 ?>
            <div class='row'>
                <span class='col' style='width:5%;height:15px;'><input type='checkbox' name='ids[]' value='<?=$row['id'];?>'/></span><span class='col' style='width:23%;height:15px;background-color:<?=(($row['type']=='pub')?'#9900ff':(($row['type']=="news")?"#cc0000":"#ff9933"));?> ;' >
                    <a href='/admin/pages/edit/<?=$row['id'];?>' style='color:#000000;' title='Отредактировать страницу'>
                    	<?=$tools->decodeString($row['title']);?>
                    </a>
                </span>
                <span class='col' style='width:25%;height:15px;'>http://host/
                    <?=rawurldecode(($row['ufu']=='')?$row['id']:$row['ufu']);?>
                </span>
                <span class='col' style='width:25%;height:15px;'>
                    <?=date("H:i:s d.m.Y",$row['pub_date']);?>
                </span>
                <span class='col' style='width:15%;height:15px;'>
                    <?=($row['status']=='on')?'Активна':'Отключена';?>
                </span>
                <span class='col' style='background-color:#FF22AA;width:2%;height:15px;'><span onclick='Invis.core.loadPage("pages","edit/<?=$row['id'];?>");return false;' style='font-size:10px;font-weight:bold;color:#FFAAAA;cursor:pointer;'>E</span></span>
            </div>
            <?
												 }
									 }
						 }
						 ?>
        </div>
    </div>
    <div style='margin-left:20%;width:70%;display:block;margin-top:40px;margin-bottom:40px;'>
        <div style='width:100%;text-align:center;'>
            Тип страницы
        </div>
        <div style='width:100%;'>
            <span style='border:2px #FFFFFF dotted;background-color:#9900ff;color:#FFFFFF;width:150px;display:block;float:left;'>ПУБЛИКАЦИЯ</span>
            <span style='border:2px #FFFFFF dotted;background-color:#cc0000;color:#FFFFFF;width:150px;display:block;float:left;'>НОВОСТЬ</span>
            <span style='border:2px #FFFFFF dotted;background-color:#ff9933;color:#FFFFFF;width:150px;display:block;float:left;'>ТЕКСТ</span>
        </div>
    </div>
    <input type='hidden' name='action_main'/>
    <?=$uinterface->buildActionsTab('pages',array('delete'=>'Удалить','deny'=>'Блокировать','main'=>'Сделать главной','restore'=>'Разблокировать'));?>
</form>
<?php
print $errorB->outputData();
?>
